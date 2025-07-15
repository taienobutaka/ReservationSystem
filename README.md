# ReservationSystem(飲食店予約管理システム)

利用者、オーナー、管理者のそれぞれに権限と機能がついています。

![店舗一覧画面](<images/スクリーンショット 2025-02-10 084311.png>)

## 利用者

### 会員登録

ログインに関係なく、店舗一覧画面より閲覧とお気に入り機能が利用できます。
<br>
バリデーションによるパスワード認証・メール認証によりログインすることができます。

![登録画面](<images/スクリーンショット 2025-02-06 114906.png>)

![サンクス画面](<images/スクリーンショット 2025-02-06 114944-1.png>)

![メール認証](<images/スクリーンショット 2025-03-14 101325.png>)

![ログイン画面](<images/スクリーンショット 2025-02-06 115538-1.png>)

### お店の閲覧・予約

店舗一覧画面では、ログイン状態により左上タイトルマークをクリックした際のモーダル画面の内容が違います。

![未ログインモーダル](<images/スクリーンショット 2025-02-06 114447.png>)

![ログインもーダル](<images/スクリーンショット 2025-02-06 115912.png>)

店舗一覧画面より、ジャンルエリアの絞り込み検索と店名検索ができます。

![検索](<images/スクリーンショット 2025-02-06 115836.png>)

「詳しくみる」ボタンをクリックすると、店舗詳細画面に移動します。
<br>
店舗詳細画面では、お店の詳細閲覧と予約ができます。
<br>
未ログインでは、予約ができません。

![お店詳細画面](<images/スクリーンショット 2025-02-06 120132.png>)

予約は、明日以降となるようにバリデーションによる機能がついています。
<br>
また、予約すると利用者として登録しているメールアドレスに、予約完了メールが届きます。
<br>
予約完了メールには、QR コードが添付されており、店舗側と照合することができます。<br>
そして、予約完了画面へと移動します。
<br>
予約完了画面の「戻る」ボタンをクリックすると、店舗一覧画面に戻ります。

![予約完了メール](<images/スクリーンショット 2025-03-14 101515.png>)

![予約完了画面](<images/スクリーンショット 2025-02-06 120155.png>)

### マイページ機能

マイページ画面より、予約状況とお気に入り店舗が管理できます。
<br>
予約日時の変更ができるようになっています。

![マイページ画面](<images/スクリーンショット 2025-02-10 084544.png>)

予約当日の朝８時に、リマインダー機能により利用者のメールアドレスにメールが届くようになっています。

```
protected function schedule(Schedule $schedule)
{
    $schedule->command('send:reservation-reminders')->cron('00 08 * * *');
}
```

![リマインダー](<images/スクリーンショット 2025-03-14 102829.png>)

また、予約日時を過ぎると評価・コメントができるようになっています。

![コメント選択中](<images/スクリーンショット 2025-02-06 120431.png>)

![コメント反映前](<images/スクリーンショット 2025-02-06 122219.png>)

「評価する」ボタンをクリックすると反映されます。

![コメント反映後](<images/スクリーンショット 2025-02-06 122239.png>)

そして、「会計する」ボタンをクリックすると、Stripe による決済機能が利用できます。

![stripe](<images/スクリーンショット 2025-02-06 122311.png>)

## 管理者

### 管理者登録

管理者登録とログインをして、管理者画面に入ります。

![管理者登録](<images/スクリーンショット 2025-02-06 122544.png>)

![管理者ログイン](<images/スクリーンショット 2025-02-06 122603.png>)

### オーナー（店舗代表者）管理

管理者画面では、オーナーの作成と一覧表示ができるようになっています。

![管理者画面](<images/スクリーンショット 2025-02-06 122639.png>)

![オーナー作成](<images/スクリーンショット 2025-02-06 130147.png>)

![オーナー一覧](<images/スクリーンショット 2025-02-06 130215.png>)

## オーナー（店舗代表者）

### ログイン

管理者画面で、作成されたオーナーだけがログイン画面からオーナー管理画面に入れます。

![オーナーログイン](<images/スクリーンショット 2025-02-06 130234.png>)

![オーナー画面](<images/スクリーンショット 2025-02-06 130342.png>)

### オーナー管理画面

オーナー管理画面では、店舗の作成ができます。

![店舗作成](<images/スクリーンショット 2025-02-10 084643.png>)

作成した店舗の修正ができます。
<br>
店舗 ID を入力すると、各項目に保存してある情報が表示します。

![店舗修正](<images/スクリーンショット 2025-02-10 084706.png>)

作成した店舗の情報は、一覧として表示できます。
<br>
オーナーは、複数の店舗の代表になれます。
<br>
ページネーションにより閲覧できるようになっています。

![オーナー店舗一覧](<images/スクリーンショット 2025-02-10 084841.png>)

利用者の予約状況の表示は、ログインしているオーナーの管理している店舗の予約状況が表示されるようになっています。

![予約](<images/スクリーンショット 2025-02-06 130449.png>)

QR コードをクリックすると、利用者と照会できるように QR コードが表示されます。
<br>
照会できるように、予約 ID を QR コードにしています。

![qrコード](<images/スクリーンショット 2025-02-10 084919.png>)

オーナーから利用者へお知らせメールを送信することができます。

![メール送信](<images/スクリーンショット 2025-02-06 130405.png>)

## 環境構築

**Makefile を使用した簡単セットアップ**

1. **リポジトリのクローン**

```bash
git clone git@github.com:taienobutaka/ReservationSystem.git
cd ReservationSystem
```

2. **DockerDesktop アプリを立ち上げる**

3. **環境構築の実行（自動化）**

```bash
make init
```

このコマンドにより以下が自動実行されます：

- Docker コンテナのビルド・起動
- PHP 依存パッケージのインストール
- Stripe ライブラリのインストール
- Simple QrCode ライブラリのインストール
- .env ファイルの作成と設定
- データベース設定の自動修正
- MailHog 用メール設定の自動修正
- Stripe 設定の追加
- 画像ストレージディレクトリの作成
- アプリケーションキーの生成
- ストレージリンクの作成
- 適切な権限設定
- マイグレーションの実行
- シーディングの実行

**利用可能な Make コマンド**

```bash
make help         # 利用可能なコマンド一覧を表示
make up           # コンテナ起動
make down         # コンテナ停止・削除
make restart      # コンテナ再起動
make fresh        # データベースリフレッシュ
make cache        # キャッシュクリア
make shell        # PHPコンテナにログイン
make logs         # ログ表示
make backup       # データベースバックアップ
make reminder     # リマインダー送信テスト
make schedule     # スケジュール実行開始
make qr-test      # QRコード生成テスト
make imagick-test # ImageMagickテスト
make clean        # 全削除（注意）
```

**Docker 構成**

```yaml
version: "3.8"

services:
  nginx:
    image: nginx:1.21.1
    ports:
      - "80:80"
    volumes:
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
      - ./src:/var/www
    depends_on:
      - php

  php:
    build: ./docker/php
    volumes:
      - ./src:/var/www

  mysql:
    image: mysql:8.0.26
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: laravel_db
      MYSQL_USER: laravel_user
      MYSQL_PASSWORD: laravel_pass
    command: mysqld --default-authentication-plugin=mysql_native_password
    volumes:
      - ./docker/mysql/data:/var/lib/mysql
      - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    environment:
      - PMA_ARBITRARY=1
      - PMA_HOST=mysql
      - PMA_USER=laravel_user
      - PMA_PASSWORD=laravel_pass
    depends_on:
      - mysql
    ports:
      - 8080:80

  mailhog:
    image: mailhog/mailhog
    ports:
      - "1025:1025"
      - "8025:8025"
```

**PHP 環境構築（Dockerfile）**

```dockerfile
FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip libmagickwand-dev libpng-dev libjpeg-dev imagemagick --no-install-recommends \
    && docker-php-ext-install pdo_mysql zip \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /var/www
```

**※ 従来の手動セットアップ方法**

<details>
<summary>手動で環境構築を行いたい場合はこちらを参照</summary>

**Laravel 環境構築**

1. `docker-compose exec php bash`
2. php コンテナ内で`composer install`
3. env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.env ファイルを作成
4. 「.env に以下の環境変数を追加

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

6. MailHog の設定

```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="メールアドレス"
MAIL_FROM_NAME="${APP_NAME}"
```

7. アプリケーションキーの作成

```bash
php artisan key:generate
```

8. マイグレーションの実行

```bash
php artisan migrate
```

9. シーディングの実行

```bash
php artisan db:seed
```

**リマインダー**

1. コマンドの作成<br>
   リマインダーを送信するためのカスタムコマンドを作成

```bash
php artisan make:command SendReservationReminders
```

2. メールクラスの作成<br>
   リマインダーのメールを送信するための Mailable クラスを作成

```bash
php artisan make:mail ReservationReminder
```

3. リマインダーの実行

```bash
php artisan schedule:work
```

**認証メール**

1. カスタムメール通知を設定

```bash
php artisan make:notification VerifyEmail
```

**予約完了メール**

1. メールクラスの作成<br>
   予約完了メールを送信するための Mailable クラスを作成

```bash
php artisan make:mail ReservationMail
```

**Simple QrCode の設定**

1. 必要なパッケージのインストール<br>
   Simple QrCode パッケージをインストール

```bash
composer require simplesoftwareio/simple-qrcode
```

**Stripe（テスト環境）の設定**

1. Stripe のインストール<br>
   Stripe の PHP ライブラリをインストール

```
composer require stripe/stripe-php
```

2. 環境設定ファイルの更新<br>
   `.env`ファイルに Stripe の API キーを追加

```
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret_key
```

</details>

## 使用技術(実行環境)

- PHP 8.1.31
- Laravel 8.83.29
- MySQL 8.0.26

## ER 図

![alt text](<images/スクリーンショット 2025-03-14 085500.png>)

## 機能一覧

![alt text](<images/スクリーンショット 2025-02-10 231957-1.png>)
![alt text](<images/スクリーンショット 2025-02-10 231927.png>)

## テーブル仕様

![alt text](<images/スクリーンショット 2025-02-12 091514.png>)

## 基本設計

![alt text](<images/スクリーンショット 2025-02-10 164341.png>)
![alt text](<images/スクリーンショット 2025-02-10 231107.png>)
![alt text](<images/スクリーンショット 2025-02-10 231044.png>)

## URL

- 開発環境：http://localhost/
- 店舗一覧画面：http://localhost/
- 管理者登録画面：http://localhost/admin-register
- 店舗代表者登録：http://localhost/owner-register
- phpMyAdmin:：http://localhost:8080/
