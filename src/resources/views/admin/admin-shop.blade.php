<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者オーナー一覧</title>
    <link rel="stylesheet" href="{{ asset('css/admin-shop.css') }}">
</head>
<body>
    <div class="header">
        <h1 class="title">オーナー一覧</h1>
        <button onclick="location.href='{{ route('admin.dashboard') }}'" class="button right">戻る</button>
    </div>
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>店舗ID</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($owners as $owner)
                    <tr>
                        <td>{{ $owner->id }}</td>
                        <td>{{ $owner->name }}</td>
                        <td>{{ $owner->email }}</td>
                        <td>{{ $owner->shop_id }}</td>
                        <td>
                            <form action="{{ route('admin.shop.delete', $owner->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $owners->links() }}
        </div>
    </div>
</body>
</html>