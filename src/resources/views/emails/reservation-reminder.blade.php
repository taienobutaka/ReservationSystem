<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約リマインダー</title>
</head>
<body>
    <p>{{ $reservation->user->name }}様</p>
    <p>以下の内容で予約が入っています。</p>
    <p>日時: {{ $reservation->start_at }}</p>
    <p>店舗: {{ $reservation->shop->name }}</p>
    <p>ご来店をお待ちしております。</p>
</body>
</html>