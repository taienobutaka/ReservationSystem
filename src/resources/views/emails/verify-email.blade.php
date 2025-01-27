<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証</title>
</head>
<body>
    <h1>メール認証</h1>
    <p>以下のリンクをクリックして、メールアドレスの認証を完了してください。</p>
    <p><a href="{{ $verificationUrl }}">メール認証リンク</a></p>
    <p>このリンクは{{ config('auth.verification.expire', 60) }}分後に期限切れとなります。</p>
    <p>もしこのメールに心当たりがない場合は、このメールを無視してください。</p>
</body>
</html>