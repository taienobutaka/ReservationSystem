<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗情報管理</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
    <div class="content">
        <div class="shop-owner">ShopOwner</div>
        <div class="button-grid">
            <button onclick="location.href='{{ route('shopOwner.ownerShop') }}'">店舗一覧</button>
            <button onclick="location.href='{{ route('shopOwner.createShop') }}'">店舗作成</button>
            <button onclick="location.href='{{ route('shopOwner.ownerReservation') }}'">予約状況</button>
            <button onclick="location.href='{{ route('shopOwner.showMailForm') }}'">メール</button>
        </div>
    </div>
</body>
</html>