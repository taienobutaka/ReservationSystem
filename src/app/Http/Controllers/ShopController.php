<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $query = Shop::query();

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('area', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('genre', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $shops = $query->with(['area', 'genre'])->get();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function detail($shop_id)
    {
        $shop = Shop::with(['area', 'genre'])->findOrFail($shop_id);

        // 現在の時刻から次の1時間単位の時間を計算
        $now = Carbon::now();
        $nextHour = $now->copy()->addHour()->minute(0)->second(0);

        return view('shop', compact('shop', 'nextHour'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string',
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

        return redirect()->route('shop.index')->with('success', 'お店情報が登録されました。');
    }

    public function show($id)
    {
        $shop = Shop::with(['area', 'genre'])->findOrFail($id);
        return view('shopOwner.dashboard', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'description' => 'required|string',
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

        return redirect()->route('shopOwner.dashboard')->with('success', 'お店情報が更新されました。');
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();

        return redirect()->route('shopOwner.dashboard')->with('success', 'お店情報が削除されました。');
    }

    public function updateSummary(Request $request, $shop_id)
    {
        // セッションに選択された値を保存
        $request->session()->put('date', $request->input('date'));
        $request->session()->put('time', $request->input('time'));
        $request->session()->put('num_of_users', $request->input('num_of_users'));

        return redirect()->route('shop.detail', ['shop_id' => $shop_id]);
    }
}
