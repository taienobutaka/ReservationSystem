<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約状況</title>
    <link rel="stylesheet" href="{{ asset('css/owner-reservation.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap">
</head>
<body>
    <div class="header">
        <h1 class="title">予約状況</h1>
        <button onclick="location.href='{{ route('shopOwner.dashboard') }}'" class="button right">戻る</button>
    </div>
    <div class="container">
        <div class="reservation-status">
            @if ($reservations->isEmpty())
                <p>予約がありません。</p>
            @else
                @php
                    $reservationCount = 1;
                    $visitCount = 1;
                    $ratings = [
                        5 => '大変満足している',
                        4 => '美味しかった',
                        3 => 'ふつう',
                        2 => '少し不満がある',
                        1 => '美味しくなかった',
                    ];
                @endphp
                @foreach ($reservations->sortByDesc('start_at') as $reservation)
                    <div class="reservation-box {{ $reservation->start_at->isPast() ? 'past-reservation' : '' }}">
                        <div class="reservation-header">
                            <span>
                                @if ($reservation->start_at->isPast())
                                    来店{{ $visitCount++ }}
                                @else
                                    予約{{ $reservationCount++ }}
                                @endif
                            </span>
                            <form action="{{ route('reservation.delete') }}" method="POST" class="cancel-form">
                                @csrf
                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                <button type="submit" class="cancel-button">
                                    <span class="material-symbols-outlined">cancel</span>
                                </button>
                            </form>
                        </div>
                        <div class="reservation-info-horizontal">
                            <div class="reservation-item">
                                <span class="label">Shop</span>
                                <span class="value">{{ $reservation->shop->name }}</span>
                            </div>
                            <div class="reservation-item">
                                <span class="label">Date</span>
                                <span class="value" id="date-{{ $reservation->id }}">{{ $reservation->start_at->format('Y-m-d') }}</span>
                            </div>
                            <div class="reservation-item">
                                <span class="label">Time</span>
                                <span class="value" id="time-{{ $reservation->id }}">{{ $reservation->start_at->format('H:i') }}</span>
                            </div>
                            <div class="reservation-item">
                                <span class="label">Number</span>
                                <span class="value" id="num_of_users-{{ $reservation->id }}">{{ $reservation->num_of_users }}人</span>
                            </div>
                        </div>
                        @if ($reservation->start_at->isFuture())
                            <form action="{{ route('shopOwner.updateReservation', ['id' => $reservation->id]) }}" method="POST" id="reservation-{{ $reservation->id }}">
                                @csrf
                                @method('PUT')
                                <div class="reservation-item">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" value="{{ $reservation->start_at->format('Y-m-d') }}" required>
                                    @error('date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="reservation-item">
                                    <label for="time">Time</label>
                                    <select name="time" required>
                                        @for ($i = 0; $i < 24; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00" {{ $reservation->start_at->format('H:i') == str_pad($i, 2, '0', STR_PAD_LEFT) . ':00' ? 'selected' : '' }}>
                                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                            </option>
                                        @endfor
                                    </select>
                                    @error('time')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="reservation-item">
                                    <label for="num_of_users">Number</label>
                                    <select name="num_of_users" required>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ $reservation->num_of_users == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('num_of_users')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="button">更新する</button>
                                <a href="{{ route('shopOwner.showQRCode', ['id' => $reservation->id]) }}" class="button">QRコード</a>
                            </form>
                        @else
                            @if (session('reviewed_reservation_id') == $reservation->id || ($reservation->rating && $reservation->comment))
                                <div class="reservation-item">
                                    <span class="label">Rating</span>
                                    <span class="value">{{ $reservation->rating }} {{ $ratings[$reservation->rating] }}</span>
                                </div>
                                <div class="reservation-item">
                                    <span class="label">Comment</span>
                                    <span class="value">{{ $reservation->comment }}</span>
                                </div>
                            @else
                                <form action="{{ route('reservation.saveReview') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                    <div class="reservation-item">
                                        <label for="rating">Rating</label>
                                        <select name="rating" required>
                                            <option value="5">5 大変満足している</option>
                                            <option value="4">4 美味しかった</option>
                                            <option value="3">3 ふつう</option>
                                            <option value="2">2 少し不満がある</option>
                                            <option value="1">1 美味しくなかった</option>
                                        </select>
                                    </div>
                                    <div class="reservation-item">
                                        <label for="comment">Comment</label>
                                        <textarea name="comment" required style="width: 100%; height: 100px;"></textarea>
                                    </div>
                                    <button type="submit" class="button">評価する</button>
                                </form>
                            @endif
                        @endif
                        @if (session('qr_code_reservation_id') == $reservation->id)
                            <div class="qr-code">
                                <img src="data:image/png;base64,{{ session('qr_code') }}" alt="QR Code">
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>