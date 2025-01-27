<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗作成</title>
    <link rel="stylesheet" href="{{ asset('css/owner-create.css') }}">
</head>
<body>
    <div class="header">
        <h1 class="title">店舗作成</h1>
        <button onclick="location.href='{{ route('shopOwner.dashboard') }}'" class="button right">戻る</button>
    </div>
    <div class="content">
        <form id="loadShopForm" action="{{ route('shopOwner.loadShop') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="shop_id">店舗ID</label>
                <input type="text" id="shop_id" name="shop_id" value="{{ old('shop_id') }}">
                <button type="submit">入力</button>
            </div>
        </form>
        <form id="shopForm" action="{{ route('shopOwner.storeShop') }}" method="POST">
            @csrf
            <input type="hidden" id="shop_id_hidden" name="shop_id" value="{{ old('shop_id') }}">
            <div class="form-group">
                <label for="shop_name">店名</label>
                <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}" required>
            </div>
            <div class="form-group">
                <label for="area">エリア</label>
                <input type="text" id="area" name="area" value="{{ old('area') }}" required>
            </div>
            <div class="form-group">
                <label for="genre">ジャンル</label>
                <input type="text" id="genre" name="genre" value="{{ old('genre') }}" required>
            </div>
            <div class="form-group">
                <label for="image">画像</label>
                <input type="text" id="image" name="image" value="{{ old('image') }}" required>
            </div>
            <div class="form-group">
                <label for="description">詳細</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}" required>
            </div>
            <div class="form-group">
                <label for="owner">オーナーID</label>
                <input type="text" id="owner" name="owner" value="{{ old('owner') }}">
            </div>
            <div class="form-group">
                <button type="submit" id="submitButton">{{ old('shop_id') ? '更新' : '登録' }}</button>
            </div>
        </form>
        @if(old('shop_id'))
        <form id="deleteForm" action="{{ route('shopOwner.deleteShop', ['id' => old('shop_id')]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">削除</button>
        </form>
        @endif
    </div>
    <script>
        function resetForm() {
            document.getElementById('shopForm').reset();
            document.getElementById('shopForm').action = '{{ route('shopOwner.storeShop') }}';
            document.getElementById('submitButton').innerText = '登録';
        }
    </script>
</body>
</html>