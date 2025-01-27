<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>サンクス</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap"> <!-- Almaraiフォントを追加 -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/thanks.css">
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
            <p>会員登録ありがとうございます</p>
        </div>
        @if (session('message'))
            <div class="success-message">
                {{ session('message') }}
            </div>
        @endif
    </div>
</body>
</html>