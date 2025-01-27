<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約完了</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
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
    <div class="thanks-container">
        <div class="thanks-header">
            <p>ご予約ありがとうございます</p>
        </div>
        <button type="button" onclick="location.href='/'">戻る</button>
    </div>
</body>
</html>