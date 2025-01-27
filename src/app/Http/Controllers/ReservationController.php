<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\ReservationMail;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create(ReservationRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', '予約するにはログインが必要です。');
        }

        // セッションに選択された値を保存
        Session::put('date', $request->input('date'));
        Session::put('time', $request->input('time'));
        Session::put('num_of_users', $request->input('num_of_users'));

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'shop_id' => $request->input('shop_id'),
            'num_of_users' => $request->input('num_of_users'),
            'start_at' => $request->input('date') . ' ' . $request->input('time') . ':00',
        ]);

        // QRコード生成
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate('Reservation ID: ' . $reservation->id));

        // メール送信
        Mail::to(Auth::user()->email)->send(new ReservationMail($reservation, $qrCode));

        // 予約完了画面にリダイレクト
        return redirect()->route('reservation.done');
    }

    public function done()
    {
        return view('done');
    }

    public function delete(Request $request)
    {
        $reservation = Reservation::where('user_id', Auth::id())
                                  ->where('id', $request->input('reservation_id'))
                                  ->first();

        if ($reservation) {
            $reservation->delete();
            return redirect()->back()->with('success', '予約を取り消しました。');
        }

        return redirect()->back()->with('error', '予約が見つかりませんでした。');
    }
}