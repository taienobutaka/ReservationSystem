<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Favorite;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();

        $reservations = $user ? Reservation::where('user_id', $user->id)->with('shop')->get() : collect();
        $favorites = $user ? Favorite::where('user_id', $user->id)->with('shop.area', 'shop.genre')->get() : collect();

        return view('mypage', compact('reservations', 'favorites'));
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $reservation = Reservation::find($request->reservation_id);

        if (!$reservation) {
            return redirect()->route('mypage')->with('error', '予約が見つかりませんでした。');
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => 'Reservation at ' . $reservation->shop->name,
                    ],
                    'unit_amount' => 5000, // 価格を設定
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('mypage') . '?success=true',
            'cancel_url' => route('mypage') . '?cancel=true',
        ]);

        return redirect($session->url);
    }

    public function updateReservation(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if ($reservation) {
            $reservation->start_at = $request->input('date') . ' ' . $request->input('time');
            $reservation->num_of_users = $request->input('num_of_users');
            $reservation->save();

            return redirect()->route('mypage')->with('success', '予約が更新されました。');
        }

        return redirect()->route('mypage')->with('error', '予約が見つかりませんでした。');
    }
}
