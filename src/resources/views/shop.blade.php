<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗詳細</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
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
        <div class="shop-details">
            <div class="shop-header">
                <a href="/" class="back-icon">
                    <div class="icon">
                        <span class="icon-text"><</span>
                    </div>
                </a>
                <h2>{{ $shop->name }}</h2>
            </div>
            <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" class="shop-image">
            <p class="shop-info">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
            <p class="description">{{ $shop->description }}</p>
        </div>
        <div class="reservation-box">
            <h3>予約</h3>
            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif
            <form id="reservation-form" action="{{ route('shop.updateSummary', ['shop_id' => $shop->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <div class="input-group">
                    <input type="date" id="date" name="date" value="{{ session('date', old('date', date('Y-m-d'))) }}" required onchange="this.form.submit()">
                    @error('date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <select id="time" name="time" required onchange="this.form.submit()">
                        @for ($i = 0; $i < 24; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00" {{ session('time', old('time', $nextHour->format('H:i'))) == str_pad($i, 2, '0', STR_PAD_LEFT) . ':00' ? 'selected' : '' }}>
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                            </option>
                        @endfor
                    </select>
                    <span class="material-symbols-outlined">arrow_drop_down</span>
                    @error('time')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <select id="num_of_users" name="num_of_users" required onchange="this.form.submit()">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ session('num_of_users', old('num_of_users', 1)) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <span class="material-symbols-outlined">arrow_drop_down</span>
                    @error('num_of_users')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </form>
            <div class="summary-box">
                <div class="reservation-item">
                    <span class="label">Shop</span>
                    <span class="value">{{ $shop->name }}</span>
                </div>
                <div class="reservation-item">
                    <span class="label">Date</span>
                    <span class="value" id="summary-date">{{ session('date', old('date')) }}</span>
                </div>
                <div class="reservation-item">
                    <span class="label">Time</span>
                    <span class="value" id="summary-time">{{ session('time', old('time')) }}</span>
                </div>
                <div class="reservation-item">
                    <span class="label">Number</span>
                    <span class="value" id="summary-num_of_users">{{ session('num_of_users', old('num_of_users')) }}</span>
                </div>
            </div>
            <form action="{{ route('reservation.create') }}" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <input type="hidden" name="date" value="{{ session('date', old('date')) }}">
                <input type="hidden" name="time" value="{{ session('time', old('time')) }}">
                <input type="hidden" name="num_of_users" value="{{ session('num_of_users', old('num_of_users')) }}">
                <button type="submit" id="reserve-button" class="button">予約する</button>
            </form>
        </div>
    </div>
</body>
</html>