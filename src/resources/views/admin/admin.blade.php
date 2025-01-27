<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
        <div class="admin">Admin</div>
        <div class="button-grid">
            <button onclick="location.href='{{ route('shopOwner.register') }}'">Owner 作成</button>
            <button onclick="location.href='{{ route('admin.shop') }}'">Owner 一覧</button>
        </div>
    </div>
</body>
</html>