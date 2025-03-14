<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール送信</title>
    <link rel="stylesheet" href="{{ asset('css/owner-mail.css') }}">
</head>
<body>
    <div class="header">
        <h1 class="title">メール送信</h1>
        <button onclick="location.href='{{ route('shopOwner.dashboard') }}'" class="button right">戻る</button>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('shopOwner.sendMail') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="subject">件名</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">メッセージ</label>
                <textarea id="message" name="message" rows="10" required></textarea>
            </div>
            <button type="submit" class="button">送信</button>
        </form>
    </div>
</body>
</html>