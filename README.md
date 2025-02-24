# ReservationSystem(飲食店予約管理システム)

利用者、オーナー、管理者のそれぞれに権限と機能がついています。

![店舗一覧画面](<スクリーンショット 2025-02-10 084311.png>)

## 利用者

### 会員登録

ログインに関係なく、店舗一覧画面より閲覧とお気に入り機能が利用できます。
<br>
バリデーションによるパスワード認証・メール認証によりログインすることができます。

![登録画面](<スクリーンショット 2025-02-06 114906.png>)

![サンクス画面](<スクリーンショット 2025-02-06 114944-1.png>)

![メール認証](<スクリーンショット 2025-02-06 115050.png>)

![ログイン画面](<スクリーンショット 2025-02-06 115538-1.png>)

### お店の閲覧・予約

店舗一覧画面では、ログイン状態により左上タイトルマークをクリックした際のモーダル画面の内容が違います。

![未ログインモーダル](<スクリーンショット 2025-02-06 114447.png>)

![ログインもーダル](<スクリーンショット 2025-02-06 115912.png>)

店舗一覧画面より、ジャンルエリアの絞り込み検索と店名検索ができます。

![検索](<スクリーンショット 2025-02-06 115836.png>)

「詳しくみる」ボタンをクリックすると、店舗詳細画面に移動します。
<br>
店舗詳細画面では、お店の詳細閲覧と予約ができます。
<br>
未ログインでは、予約ができません。

![お店詳細画面](<スクリーンショット 2025-02-06 120132.png>)

予約は、明日以降となるようにバリデーションによる機能がついています。
<br>
また、予約すると利用者として登録しているメールアドレスに、予約完了メールが届きます。
<br>
予約完了メールには、QRコードが添付されており、店舗側と照合することができます。<br>
そして、予約完了画面へと移動します。
<br>
予約完了画面の「戻る」ボタンをクリックすると、店舗一覧画面に戻ります。

![予約完了メール](<スクリーンショット 2025-02-06 115213.png>)

![予約完了画面](<スクリーンショット 2025-02-06 120155.png>)

### マイページ機能

マイページ画面より、予約状況とお気に入り店舗が管理できます。
<br>
予約日時の変更ができるようになっています。

![マイページ画面](<スクリーンショット 2025-02-10 084544.png>)

予約当日の朝８時に、リマインダー機能により利用者のメールアドレスにメールが届くようになっています。
```
protected function schedule(Schedule $schedule)
{
    $schedule->command('send:reservation-reminders')->cron('00 08 * * *');
}
```
![リマインダー](<スクリーンショット 2025-02-06 115403.png>)

また、予約日時を過ぎると評価・コメントができるようになっています。

![コメント選択中](<スクリーンショット 2025-02-06 120431.png>)

![コメント反映前](<スクリーンショット 2025-02-06 122219.png>)

「評価する」ボタンをクリックすると反映されます。

![コメント反映後](<スクリーンショット 2025-02-06 122239.png>)

そして、「会計する」ボタンをクリックすると、Stripeによる決済機能が利用できます。

![stripe](<スクリーンショット 2025-02-06 122311.png>)

## 管理者

### 管理者登録

管理者登録とログインをして、管理者画面に入ります。

![管理者登録](<スクリーンショット 2025-02-06 122544.png>)

![管理者ログイン](<スクリーンショット 2025-02-06 122603.png>)

### オーナー（店舗代表者）管理

管理者画面では、オーナーの作成と一覧表示ができるようになっています。

![管理者画面](<スクリーンショット 2025-02-06 122639.png>)

![オーナー作成](<スクリーンショット 2025-02-06 130147.png>)

![オーナー一覧](<スクリーンショット 2025-02-06 130215.png>)

## オーナー（店舗代表者）

### ログイン

管理者画面で、作成されたオーナーだけがログイン画面からオーナー管理画面に入れます。

![オーナーログイン](<スクリーンショット 2025-02-06 130234.png>)

![オーナー画面](<スクリーンショット 2025-02-06 130342.png>)

### オーナー管理画面

オーナー管理画面では、店舗の作成ができます。

![店舗作成](<スクリーンショット 2025-02-10 084643.png>)

作成した店舗の修正ができます。
<br>
店舗IDを入力すると、各項目に保存してある情報が表示します。

![店舗修正](<スクリーンショット 2025-02-10 084706.png>)

作成した店舗の情報は、一覧として表示できます。
<br>
オーナーは、複数の店舗の代表になれます。
<br>
ページネーションにより閲覧できるようになっています。

![オーナー店舗一覧](<スクリーンショット 2025-02-10 084841.png>)

利用者の予約状況の表示は、ログインしているオーナーの管理している店舗の予約状況が表示されるようになっています。

![予約](<スクリーンショット 2025-02-06 130449.png>)

QRコードをクリックすると、利用者と照会できるようにQRコードが表示されます。
<br>
照会できるように、予約IDをQRコードにしています。

![qrコード](<スクリーンショット 2025-02-10 084919.png>)

オーナーから利用者へお知らせメールを送信することができます。

![メール送信](<スクリーンショット 2025-02-06 130405.png>)


## 環境構築

**Dockerビルド**
1. `git clone git@github.com:taienobutaka/ReservationSystem.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

``` bash
services:
    nginx:
        image: nginx:1.21.1
        ports:
            - "80:80"
        volumes:
            - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
            - ./src:/var/www/html
        depends_on:
            - php

    php:
        build: ./docker/php
        volumes:
            - ./src:/var/www/html

    mysql:
        image: mysql:8.0.26
        environment:
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: laravel_db
            MYSQL_USER: laravel_user
            MYSQL_PASSWORD: laravel_pass
        command:
            mysqld --default-authentication-plugin=mysql_native_password
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

```

**Docker環境の設定**
1. Dockerfileを使用してPHP環境を構築
``` bash
FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip libmagickwand-dev --no-install-recommends \
    && docker-php-ext-install pdo_mysql zip \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /var/www




FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /var/www
```


**Laravel環境構築**
1. `docker-compose exec php bash`
2. phpコンテナ内でhtmlファイルを作成
3. htmlファイルに移動して、`composer install`
4. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
5. .envに以下の環境変数を追加
```
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

**メール設定**
`.env`ファイルにメール設定を追加
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email@example.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

**リマインダー**
1. コマンドの作成<br>
リマインダーを送信するためのカスタムコマンドを作成

``` bash
php artisan make:command SendReservationReminders
```

2. メールクラスの作成<br>
リマインダーのメールを送信するためのMailableクラスを作成
``` bash
php artisan make:mail ReservationReminder
```

3. リマインダーの実行
``` bash
php artisan schedule:work
```
**認証メール**
1. カスタムメール通知を設定
``` bash
php artisan make:notification VerifyEmail
```

**予約完了メール**
1. メールクラスの作成<br>
予約完了メールを送信するためのMailableクラスを作成
``` bash
php artisan make:mail ReservationMail
```

**Simple QrCodeの設定**
1. 必要なパッケージのインストール<br>
Simple QrCodeパッケージをインストール
``` bash
composer require simplesoftwareio/simple-qrcode
```
**Stripe（テスト環境）の設定**
1. Stripeのインストール<br>
StripeのPHPライブラリをインストール
```
composer require stripe/stripe-php
```

2. 環境設定ファイルの更新<br>
`.env`ファイルにStripeのAPIキーを追加
```
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret_key
```

**テストデータ**

1. 管理者
```
name test
email test@gmail.com
password 00000000
```
2. オーナー
```
name 山田太郎
email yamada@gmail.com
password 11111111
```


## 使用技術(実行環境)
- PHP 8.1.31
- Laravel 8.83.29
- MySQL 8.0.26

## ER図
![alt text](<スクリーンショット 2025-02-10 161018.png>)

## 機能一覧
![alt text](<スクリーンショット 2025-02-10 231957-1.png>)
![alt text](<スクリーンショット 2025-02-10 231927.png>)

## テーブル仕様
![alt text](<スクリーンショット 2025-02-12 091514.png>)

## 基本設計
![alt text](<スクリーンショット 2025-02-10 164341.png>)
![alt text](<スクリーンショット 2025-02-10 231107.png>)
![alt text](<スクリーンショット 2025-02-10 231044.png>)

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/

