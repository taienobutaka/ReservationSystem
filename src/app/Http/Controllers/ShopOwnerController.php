<?php

namespace App\Http\Controllers;

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
use SimpleSoftwareIO\QrCode\Facades\QrCode; // 追加

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
        // すべての店舗の予約情報を取得
        $reservations = Reservation::all();

        return view('shopOwner.reservations', compact('reservations'));
    }

    public function create()
    {
        return view('shopOwner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string',
            'owner' => 'nullable|exists:owners,id', // オーナーのバリデーションを追加
        ]);

        // エリアとジャンルを取得または作成
        $area = Area::firstOrCreate(['name' => $request->input('area')]);
        $genre = Genre::firstOrCreate(['name' => $request->input('genre')]);

        $shop = new Shop();
        $shop->name = $request->input('shop_name');
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->description = $request->input('description');
        $shop->image_url = $request->input('image');
        $shop->save();

        if ($request->filled('owner')) {
            $owner = ShopOwner::find($request->input('owner'));
            $owner->shop_id = $shop->id;
            $owner->save();
        }

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

    public function storeShop(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string',
            'owner' => 'nullable|exists:owners,id', // オーナーのバリデーションを追加
        ]);

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
        $shop->save();

        if ($request->filled('owner')) {
            $owner = ShopOwner::find($request->input('owner'));
            $owner->shop_id = $shop->id;
            $owner->save();
        }

        return redirect()->route('shopOwner.dashboard')->with('success', 'お店情報が登録されました。');
    }

    public function updateShop(Request $request, $id)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string',
            'owner' => 'nullable|exists:owners,id', // オーナーのバリデーションを追加
        ]);

        $shop = Shop::findOrFail($id);

        // エリアとジャンルを取得または作成
        $area = Area::firstOrCreate(['name' => $request->input('area')]);
        $genre = Genre::firstOrCreate(['name' => $request->input('genre')]);

        $shop->name = $request->input('shop_name');
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->description = $request->input('description');
        $shop->image_url = $request->input('image');
        $shop->save();

        if ($request->filled('owner')) {
            $owner = ShopOwner::find($request->input('owner'));
            $owner->shop_id = $shop->id;
            $owner->save();
        }

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

        return redirect()->route('shopOwner.createShop')->withInput([
            'shop_id' => $shop->id,
            'shop_name' => $shop->name,
            'area' => $shop->area->name,
            'genre' => $shop->genre->name,
            'image' => $shop->image_url,
            'description' => $shop->description,
            'owner' => $shop->owner->id ?? null, // オーナーを設定
        ]);
    }

    public function ownerReservation()
    {
        $shopOwner = Auth::guard('shop_owner')->user();
        $shopId = $shopOwner->shop_id;

        // すべての予約を取得
        $reservations = Reservation::where('shop_id', $shopId)->with('shop')->get();

        return view('shopOwner.owner-reservation', compact('reservations'));
    }

    public function updateReservation(Request $request, $id)
    {
        $reservation = Reservation::where('shop_id', Auth::guard('shop_owner')->user()->shop_id)->where('id', $id)->firstOrFail();

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
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = User::all();
        foreach ($users as $user) {
            Mail::raw($request->message, function ($mail) use ($user, $request) {
                $mail->to($user->email)
                     ->subject($request->subject);
            });
        }

        return redirect()->route('shopOwner.dashboard')->with('success', 'メールが送信されました。');
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
