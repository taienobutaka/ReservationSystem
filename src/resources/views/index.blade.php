<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲食店一覧</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <div class="header">
        <form action="{{ route('showModal') }}" method="GET" style="margin: 0;">
            <button type="submit" style="background: none; border: none; padding: 0; width: 40px; height: 40px;">
                <div class="title-mark">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
            </button>
        </form>
        <h1 class="title"><span class="title-r">R</span>ese</h1>
        <div class="search-bar">
            <div class="search-item">
                All area <span class="arrow">▼</span>
                <ul class="dropdown">
                    @foreach ($areas as $area)
                        <li><a href="?area_id={{ $area->id }}">{{ $area->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="search-item">
                All genre <span class="arrow">▼</span>
                <ul class="dropdown">
                    @foreach ($genres as $genre)
                        <li><a href="?genre_id={{ $genre->id }}">{{ $genre->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="search-item search-long">
                <span class="material-symbols-outlined">search</span>
                <form action="/" method="GET" style="display: inline;">
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                </form>
            </div>
        </div>
    </div>
    <div class="content">
        @if ($shops->isEmpty())
            <p>該当する飲食店が見つかりませんでした。</p>
        @else
            @foreach ($shops as $shop)
                <div class="shop">
                    <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">
                    <h2>{{ $shop->name }}</h2>
                    <p class="shop-info">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                    <a href="{{ route('shop.detail', ['shop_id' => $shop->id]) }}" class="detail-button">詳しくみる</a>
                    <form action="{{ route('favorite.toggle') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <button type="submit" class="favorite-btn {{ Auth::check() ? ($shop->favorites->where('user_id', Auth::id())->isNotEmpty() ? 'favorite' : '') : (in_array($shop->id, session('favorites', [])) ? 'favorite' : '') }}">
                            <span class="heart">❤</span>
                        </button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>

    @if(session('showModal'))
    <!-- モーダル -->
    <div id="modal" class="modal" style="display: block;">
        <div class="modal-content">
            <div class="modal-header">
                <form action="{{ route('hideModal') }}" method="GET" style="margin: 0;">
                    <button type="submit" style="background: none; border: none; padding: 0; width: 40px; height: 40px;">
                        <div class="title-mark">
                            <div class="close-icon">&times;</div>
                        </div>
                    </button>
                </form>
            </div>
            <div class="modal-body">
                @guest
                    <p class="modal-item"><a href="{{ route('hideModal') }}" class="modal-link">Home</a></p>
                    <p class="modal-item"><a href="/register" class="modal-link">Registration</a></p>
                    <p class="modal-item"><a href="/login" class="modal-link">Login</a></p>
                @else
                    <p class="modal-item"><a href="{{ route('hideModal') }}" class="modal-link">Home</a></p>
                    <form action="{{ route('logout') }}" method="POST" class="modal-item">
                        @csrf
                        <button type="submit" class="modal-link" style="background: none; border: none; padding: 0; color: #4169E1; cursor: pointer;">Logout</button>
                    </form>
                    <p class="modal-item"><a href="{{ route('mypage') }}" class="modal-link">Mypage</a></p>
                @endguest
            </div>
        </div>
    </div>
    @endif
</body>
</html>