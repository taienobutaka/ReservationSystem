<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopOwnerRequest;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Genre;
use App\Models\ShopOwner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShopOwnerController extends Controller
{
    public function dashboard(Request $request)
    {
        $savedShops = Shop::all();
        $reservations = Reservation::all(); // 予約情報を取得

        return view('shopOwner.dashboard', compact('savedShops', 'reservations'));
    }

    public function reservations()
    {
        $shopOwner = Auth::guard('shop_owner')->user();
        $shopIds = $shopOwner->shops->pluck('id');

        // すべての予約を取得
        $reservations = Reservation::whereIn('shop_id', $shopIds)->with('shop')->get();

        return view('shopOwner.owner-reservation', compact('reservations'));
    }

    public function create()
    {
        return view('shopOwner.create');
    }

    public function store(StoreShopRequest $request)
    {
        // エリアとジャンルを取得または作成
        $area = Area::firstOrCreate(['name' => $request->input('area')]);
        $genre = Genre::firstOrCreate(['name' => $request->input('genre')]);

        $shop = new Shop();
        $shop->name = $request->input('shop_name');
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->description = $request->input('description');
        $shop->image_url = $request->input('image');
        $shop->owner_id = $request->input('owner');
        $shop->save();

        return redirect()->route('shopOwner.dashboard')->with('success', 'お店情報が登録されました。');
    }

    public function ownerShop()
    {
        $shops = Shop::with('area', 'genre', 'owner')->paginate(5); // ページネーションで5店舗ずつ表示
        return view('shopOwner.owner-shop', compact('shops'));
    }

    public function createShop()
    {
        return view('shopOwner.owner-create');
    }

    public function storeShop(StoreShopRequest $request)
    {
        if ($request->has('shop_id') && $request->input('shop_id') != '') {
            return $this->updateShop($request, $request->input('shop_id'));
        }

        // エリアとジャンルを取得または作成
        $area = Area::firstOrCreate(['name' => $request->input('area')]);
        $genre = Genre::firstOrCreate(['name' => $request->input('genre')]);

        $shop = new Shop();
        $shop->name = $request->input('shop_name');
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->description = $request->input('description');
        $shop->image_url = $request->input('image');
        $shop->owner_id = $request->input('owner');
        $shop->save();

        return redirect()->route('shopOwner.dashboard')->with('success', 'お店情報が登録されました。');
    }

    public function updateShop(UpdateShopRequest $request, $id)
    {
        $shop = Shop::findOrFail($id);

        // エリアとジャンルを取得または作成
        $area = Area::firstOrCreate(['name' => $request->input('area')]);
        $genre = Genre::firstOrCreate(['name' => $request->input('genre')]);

        $shop->name = $request->input('shop_name');
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->description = $request->input('description');
        $shop->image_url = $request->input('image');
        $shop->owner_id = $request->input('owner');
        $shop->save();

        return redirect()->route('shopOwner.dashboard')->with('success', 'お店情報が更新されました。');
    }

    public function deleteShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();

        return redirect()->route('shopOwner.dashboard')->with('success', 'お店情報が削除されました。');
    }

    public function loadShop(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        $shop = Shop::with('area', 'genre', 'owner')->findOrFail($request->input('shop_id'));

        // オーナーが存在しない場合、$shop->ownerがnullとなり、nullのプロパティ「id」を読み取ろうとするためエラーが発生します。
        // これを防ぐために、オーナーが存在するかどうかをチェックし、存在しない場合はnullを設定します。
        return redirect()->route('shopOwner.createShop')->withInput([
            'shop_id' => $shop->id,
            'shop_name' => $shop->name,
            'area' => $shop->area->name,
            'genre' => $shop->genre->name,
            'image' => $shop->image_url,
            'description' => $shop->description,
            'owner' => $shop->owner ? $shop->owner->id : null, // オーナーが存在する場合のみIDを設定
        ]);
    }

    public function ownerReservation()
    {
        $shopOwner = Auth::guard('shop_owner')->user();
        $shopIds = $shopOwner->shops->pluck('id');

        // すべての予約を取得
        $reservations = Reservation::whereIn('shop_id', $shopIds)->with('shop')->get();

        return view('shopOwner.owner-reservation', compact('reservations'));
    }

    public function updateReservation(Request $request, $id)
    {
        $reservation = Reservation::whereIn('shop_id', Auth::guard('shop_owner')->user()->shops->pluck('id'))->where('id', $id)->firstOrFail();

        $reservation->update([
            'start_at' => $request->input('date') . ' ' . $request->input('time') . ':00',
            'num_of_users' => $request->input('num_of_users'),
        ]);

        return redirect()->route('shopOwner.ownerReservation')->with('success', '予約が更新されました。');
    }

    public function showMailForm()
    {
        return view('shopOwner.owner-mail');
    }

    public function sendMail(Request $request)
    {
        \Log::info('sendMail method called');
        \Log::info('Request data: ', $request->all());

        $users = User::all();
        \Log::info('Total users: ' . $users->count());

        foreach ($users as $user) {
            \Log::info('Sending email to: ' . $user->email);
            try {
                Mail::raw($request->message, function ($mail) use ($user, $request) {
                    $mail->to($user->email)
                         ->subject($request->subject);
                });
                \Log::info('Email sent to: ' . $user->email);
            } catch (\Exception $e) {
                \Log::error('Failed to send email to: ' . $user->email . ' Error: ' . $e->getMessage());
            }
        }

        \Log::info('All emails have been sent.');

        return redirect()->route('shopOwner.showMailForm')->with('success', 'メールが送信されました。');
    }

    public function showQRCode($id)
    {
        $reservation = Reservation::findOrFail($id);
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate('Reservation ID: ' . $reservation->id));

        Session::flash('qr_code_reservation_id', $id);
        Session::flash('qr_code', $qrCode);

        return redirect()->route('shopOwner.ownerReservation');
    }
}