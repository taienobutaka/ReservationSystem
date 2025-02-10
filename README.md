# ReservationSystem(飲食店予約管理システム)

利用者、オーナー、管理者のそれぞれの権限と機能をつけています。

![店舗一覧画面](<スクリーンショット 2025-02-10 084311.png>)

### 利用者

ログインに関係なく、店舗一覧画面よりお気に入り機能が使用できます。<br>

![登録画面](<スクリーンショット 2025-02-06 114906.png>)

バリデーションによるパスワード認証・メール認証によりログインすることができます。




また、マイページより予約の変更・評価・コメント・Stripeによる決済機能・



## 環境構築

**Dockerビルド**
1. `git clone git@github.com:taienobutaka/AttendanceManegement.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```
**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```

## 使用技術(実行環境)
- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26

## ER図
![スクリーンショット 2024-09-27 113511](https://github.com/user-attachments/assets/9fdbbb6a-0d28-40f2-9a6f-e25c4e64073c)

## 機能一覧
![スクリーンショット 2024-11-07 102701](https://github.com/user-attachments/assets/721acbe9-e691-41f1-9111-9134fe18f1c3)

## テーブル仕様
![スクリーンショット 2024-11-04 215120](https://github.com/user-attachments/assets/aca458f9-1b0e-4e88-9a4b-ef8e0b74ef80)

## 基本設計
![スクリーンショット 2024-11-08 093539](https://github.com/user-attachments/assets/b2122e26-4375-4510-bec8-e8bf0f229041)
![スクリーンショット 2024-11-08 093955](https://github.com/user-attachments/assets/ce485481-ff97-41d2-bd09-6a3874a5f7e1)

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
- 実行環境でメール認証を使用する際は、.envファイルの下記の設定を変更してください。

