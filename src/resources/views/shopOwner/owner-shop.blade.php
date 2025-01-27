<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗一覧</title>
    <link rel="stylesheet" href="{{ asset('css/owner-shop.css') }}">
</head>
<body>
    <div class="header">
        <h1 class="title">店舗一覧</h1>
        <button onclick="location.href='{{ route('shopOwner.dashboard') }}'" class="button right">戻る</button>
    </div>
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>画像</th>
                    <th>店舗名</th>
                    <th>エリア</th>
                    <th>ジャンル</th>
                    <th>オーナー氏名</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shops as $shop)
                    <tr>
                        <td>{{ $shop->id }}</td>
                        <td><img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" width="100"></td>
                        <td>{{ $shop->name }}</td>
                        <td>{{ $shop->area->name }}</td>
                        <td>{{ $shop->genre->name }}</td>
                        <td>{{ $shop->owner->name ?? '未設定' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $shops->links() }}
        </div>
    </div>
</body>
</html>