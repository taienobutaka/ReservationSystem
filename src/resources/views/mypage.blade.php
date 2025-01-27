<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
</head>
<body>
    <div class="header">
        <div class="title-mark">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
        <h1 class="title"><span class="title-r">R</span>ese</h1>
    </div>
    <div class="container">
        <div class="reservation-status">
            <h2>予約状況</h2>
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
                            <span class="material-symbols-outlined">schedule</span>
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
                        <div class="reservation-info">
                            <div class="reservation-item">
                                <span class="label">店名</span>
                                <span class="value">{{ $reservation->shop->name }}</span>
                            </div>
                            <div class="reservation-item">
                                <span class="label">月日</span>
                                <span class="value" id="date-{{ $reservation->id }}">{{ $reservation->start_at->format('Y-m-d') }}</span>
                            </div>
                            <div class="reservation-item">
                                <span class="label">時間</span>
                                <span class="value" id="time-{{ $reservation->id }}">{{ $reservation->start_at->format('H:i') }}</span>
                            </div>
                            <div class="reservation-item">
                                <span class="label">人数</span>
                                <span class="value" id="num_of_users-{{ $reservation->id }}">{{ $reservation->num_of_users }}人</span>
                            </div>
                        </div>
                        @if ($reservation->start_at->isFuture())
                            <form action="{{ route('reservation.update', ['reservation' => $reservation->id]) }}" method="POST" id="reservation-{{ $reservation->id }}">
                                @csrf
                                @method('PUT')
                                <div class="reservation-item">
                                    <label for="date">月日</label>
                                    <input type="date" name="date" value="{{ $reservation->start_at->format('Y-m-d') }}" required>
                                    @error('date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="reservation-item">
                                    <label for="time">時間</label>
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
                                    <label for="num_of_users">人数</label>
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
                            </form>
                        @else
                            @if (session('reviewed_reservation_id') == $reservation->id || ($reservation->rating && $reservation->comment))
                                <div class="reservation-item">
                                    <span class="label">評価</span>
                                    <span class="value">{{ $reservation->rating }} {{ $ratings[$reservation->rating] }}</span>
                                </div>
                                <div class="reservation-item">
                                    <span class="label">投稿</span>
                                    <span class="value">{{ $reservation->comment }}</span>
                                </div>
                            @else
                                <form action="{{ route('reservation.saveReview') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                    <div class="reservation-item">
                                        <label for="rating">評価</label>
                                        <select name="rating" required>
                                            <option value="5">5 大変満足している</option>
                                            <option value="4">4 美味しかった</option>
                                            <option value="3">3 ふつう</option>
                                            <option value="2">2 少し不満がある</option>
                                            <option value="1">1 美味しくなかった</option>
                                        </select>
                                    </div>
                                    <div class="reservation-item">
                                        <label for="comment" class="comment-label">投稿</label>
                                        <textarea name="comment" required class="comment-textarea"></textarea>
                                    </div>
                                    <button type="submit" class="button">評価する</button>
                                </form>
                            @endif
                            <form action="{{ route('createCheckoutSession') }}" method="POST">
                                @csrf
                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                <button type="submit" class="button" {{ $reservation->start_at->isFuture() ? 'disabled' : '' }}>会計する</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        <div class="favorites">
            <h2>{{ Auth::check() ? Auth::user()->name : 'ゲスト' }}さん</h2>
            <p class="favorites-title">お気に入り店舗</p>
            @if ($favorites->isEmpty())
                <p>お気に入り店舗がありません。</p>
            @else
                <div class="favorites-list">
                    @foreach ($favorites as $favorite)
                        <div class="shop">
                            <img src="{{ $favorite->shop->image_url }}" alt="{{ $favorite->shop->name }}">
                            <h2>{{ $favorite->shop->name }}</h2>
                            <p class="shop-info">#{{ $favorite->shop->area->name }} #{{ $favorite->shop->genre->name }}</p>
                            <a href="{{ route('shop.detail', ['shop_id' => $favorite->shop->id]) }}" class="detail-button">詳しくみる</a>
                            <form action="{{ route('favorite.toggle') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="shop_id" value="{{ $favorite->shop->id }}">
                                <button type="submit" class="favorite-btn favorite">
                                    <span class="heart">❤</span>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>