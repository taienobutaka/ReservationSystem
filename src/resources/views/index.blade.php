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
            <form action="/" method="GET" style="display: flex; align-items: center;">
                <div class="search-item">
                    All area <span class="arrow">▼</span>
                    <ul class="dropdown">
                        @foreach ($areas as $area)
                            <li><a href="#" onclick="event.preventDefault(); document.getElementById('area_id').value='{{ $area->id }}'; this.closest('form').submit();">{{ $area->name }}</a></li>
                        @endforeach
                    </ul>
                    <input type="hidden" id="area_id" name="area_id" value="{{ request('area_id') }}">
                </div>
                <div class="search-item">
                    All genre <span class="arrow">▼</span>
                    <ul class="dropdown">
                        @foreach ($genres as $genre)
                            <li><a href="#" onclick="event.preventDefault(); document.getElementById('genre_id').value='{{ $genre->id }}'; this.closest('form').submit();">{{ $genre->name }}</a></li>
                        @endforeach
                    </ul>
                    <input type="hidden" id="genre_id" name="genre_id" value="{{ request('genre_id') }}">
                </div>
                <div class="search-item search-long">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <button type="submit" style="display: none;"></button>
            </form>
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