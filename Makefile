# ReservationSystem Makefile
# 飲食店予約管理システムの開発環境構築・管理用

.PHONY: init fresh restart up down cache stop shell logs clean backup

init:
	@echo "=== 飲食店予約管理システム 開発環境初期化 ==="
	docker-compose up -d --build

	@echo "=== MySQLの起動待ち ==="
	@until docker-compose exec mysql mysqladmin ping -hmysql -uroot -proot --silent; do \
		echo "Waiting for MySQL..."; \
		sleep 2; \
	done
	@sleep 3

	@echo "=== PHP依存パッケージインストール ==="
	docker-compose exec php composer install

	@echo "=== Stripeライブラリインストール ==="
	docker-compose exec php composer require stripe/stripe-php

	@echo "=== Simple QrCodeライブラリインストール ==="
	docker-compose exec php composer require simplesoftwareio/simple-qrcode

	@echo "=== .envファイル作成 ==="
	@if [ ! -f src/.env ]; then cp src/.env.example src/.env; fi

	@echo "=== .envファイル自動修正 ==="
	sed -i 's/^DB_DATABASE=.*/DB_DATABASE=laravel_db/' src/.env
	sed -i 's/^DB_USERNAME=.*/DB_USERNAME=laravel_user/' src/.env
	sed -i 's/^DB_PASSWORD=.*/DB_PASSWORD=laravel_pass/' src/.env
	sed -i 's/^DB_HOST=.*/DB_HOST=mysql/' src/.env

	@echo "=== MailHog用メール設定自動修正 ==="
	sed -i 's/^MAIL_MAILER=.*/MAIL_MAILER=smtp/' src/.env
	sed -i 's/^MAIL_HOST=.*/MAIL_HOST=mailhog/' src/.env
	sed -i 's/^MAIL_PORT=.*/MAIL_PORT=1025/' src/.env
	sed -i 's/^MAIL_USERNAME=.*/MAIL_USERNAME=null/' src/.env
	sed -i 's/^MAIL_PASSWORD=.*/MAIL_PASSWORD=null/' src/.env
	sed -i 's/^MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=null/' src/.env
	sed -i 's/^MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=from@example.com/' src/.env
	sed -i 's/^MAIL_FROM_NAME=.*/MAIL_FROM_NAME="\${APP_NAME}"/' src/.env

	@echo "=== Stripe設定追加（テスト環境）==="
	@if ! grep -q "STRIPE_KEY=" src/.env; then echo "STRIPE_KEY=your_stripe_key" >> src/.env; fi
	@if ! grep -q "STRIPE_SECRET=" src/.env; then echo "STRIPE_SECRET=your_stripe_secret_key" >> src/.env; fi

	@echo "=== 画像ストレージ用ディレクトリ作成 ==="
	@mkdir -p ./src/storage/app/public/img
	@mkdir -p ./src/storage/app/public/qrcodes

	@echo "=== 画像ストレージ用ディレクトリに画像移動 ==="
	@if [ -d ./src/public/img/copy_storage_img ]; then mv ./src/public/img/copy_storage_img/*.jpg ./src/storage/app/public/img || true; fi

	@echo "=== アプリケーションキー生成 ==="
	docker-compose exec php php artisan key:generate

	@echo "=== ストレージリンク作成 ==="
	docker-compose exec php php artisan storage:link

	@echo "=== 権限設定 ==="
	docker-compose exec php chmod -R 777 storage bootstrap/cache

	@echo "=== マイグレーション実行 ==="
	docker-compose exec php php artisan migrate:fresh

	@echo "=== シーディング実行 ==="
	docker-compose exec php php artisan db:seed

	@echo "=== 予約システム初期化完了 ==="
	@echo "アクセスURL: http://localhost/"
	@echo "phpMyAdmin: http://localhost:8080/"
	@echo "MailHog: http://localhost:8025/"

fresh:
	@echo "=== データベースリフレッシュ ==="
	docker-compose exec php php artisan migrate:fresh --seed

restart:
	@make down
	@make up

up:
	@echo "=== コンテナ起動 ==="
	docker-compose up -d

down:
	@echo "=== コンテナ停止・削除 ==="
	docker-compose down --remove-orphans

cache:
	@echo "=== キャッシュクリア ==="
	docker-compose exec php php artisan cache:clear
	docker-compose exec php php artisan config:cache
	docker-compose exec php php artisan route:cache
	docker-compose exec php php artisan view:cache

stop:
	@echo "=== コンテナ停止 ==="
	docker-compose stop

shell:
	@echo "=== PHPコンテナにログイン ==="
	docker-compose exec php bash

logs:
	@echo "=== ログ表示 ==="
	docker-compose logs -f

clean:
	@echo "=== 全コンテナ・イメージ・ボリューム削除 ==="
	docker-compose down --rmi all --volumes --remove-orphans

backup:
	@echo "=== データベースバックアップ ==="
	@mkdir -p ./database/backups
	docker-compose exec mysql mysqldump -uroot -proot laravel_db > ./database/backups/backup_$(shell date +%Y%m%d_%H%M%S).sql

reminder:
	@echo "=== リマインダー送信テスト ==="
	docker-compose exec php php artisan send:reservation-reminders

schedule:
	@echo "=== スケジュール実行開始 ==="
	docker-compose exec php php artisan schedule:work

qr-test:
	@echo "=== QRコード生成テスト ==="
	docker-compose exec php php test_qrcode.php

imagick-test:
	@echo "=== ImageMagickテスト ==="
	docker-compose exec php php test_imagick.php

help:
	@echo "=== 利用可能なコマンド ==="
	@echo "make init      : 初回環境構築"
	@echo "make up        : コンテナ起動"
	@echo "make down      : コンテナ停止・削除"
	@echo "make restart   : コンテナ再起動"
	@echo "make fresh     : データベースリフレッシュ"
	@echo "make cache     : キャッシュクリア"
	@echo "make shell     : PHPコンテナにログイン"
	@echo "make logs      : ログ表示"
	@echo "make clean     : 全削除（注意）"
	@echo "make backup    : データベースバックアップ"
	@echo "make reminder  : リマインダー送信テスト"
	@echo "make schedule  : スケジュール実行開始"
	@echo "make qr-test   : QRコード生成テスト"
	@echo "make imagick-test : ImageMagickテスト"
