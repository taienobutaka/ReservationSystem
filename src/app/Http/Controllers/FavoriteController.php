<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'shop_id' => $request->input('shop_id'),
        ]);

        return redirect()->back()->with('success', 'お気に入りに追加しました。');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        $favorite = Favorite::where('user_id', Auth::id())
                            ->where('shop_id', $request->input('shop_id'))
                            ->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'お気に入りを解除しました。');
        }

        return redirect()->back()->with('error', 'お気に入りが見つかりませんでした。');
    }

    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $shopId = $request->input('shop_id');

        if ($user) {
            $favorite = Favorite::where('user_id', $user->id)->where('shop_id', $shopId)->first();

            if ($favorite) {
                $favorite->delete();
            } else {
                Favorite::create([
                    'user_id' => $user->id,
                    'shop_id' => $shopId,
                ]);
            }
        } else {
            $favorites = session('favorites', []);
            if (in_array($shopId, $favorites)) {
                $favorites = array_diff($favorites, [$shopId]);
            } else {
                $favorites[] = $shopId;
            }
            session(['favorites' => $favorites]);
        }

        return redirect()->back();
    }
}
