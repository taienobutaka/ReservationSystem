<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗代表者登録</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner-register.css') }}">
</head>
<body>
    <div class="header">
        <button class="back-button" onclick="location.href='{{ route('admin.dashboard') }}'">戻る</button>
    </div>
    <div class="registration-container">
        <div class="registration-header">
            <h2>Owner Registration</h2>
        </div>
        @if (session('message'))
            <div class="success-message">
                {{ session('message') }}
            </div>
        @endif
        <form action="{{ route('shopOwner.register.store') }}" method="POST" novalidate>
            @csrf
            <div class="input-group">
                <span class="material-symbols-outlined">person</span>
                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
            </div>
            @if ($errors->has('name'))
                <div class="error">{{ $errors->first('name') }}</div>
            @endif
            <div class="input-group">
                <span class="material-symbols-outlined">mail</span>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            </div>
            @if ($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
            <div class="input-group">
                <span class="material-symbols-outlined">enhanced_encryption</span>
                <input type="password" name="password" placeholder="Password">
            </div>
            @if ($errors->has('password'))
                <div class="error">{{ $errors->first('password') }}</div>
            @endif
            <div class="input-group">
                <span class="material-symbols-outlined">store</span>
                <input type="text" name="shop_id" placeholder="Shop ID (任意)" value="{{ old('shop_id') }}">
            </div>
            @if ($errors->has('shop_id'))
                <div class="error">{{ $errors->first('shop_id') }}</div>
            @endif
            <button type="submit">登録</button>
        </form>
    </div>
</body>
</html>