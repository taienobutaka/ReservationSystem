<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopOwnerController;
use App\Http\Middleware\ClearModalSession;

// 会員登録関連のルート
Route::get('/register', [RegisterController::class, 'create'])->name('register'); // 会員登録画面表示
Route::post('/register', [RegisterController::class, 'store']); // 会員登録処理

// ログイン関連のルート
Route::post('/login', [AuthController::class, 'store'])->name('login.store'); // ログイン処理

// サンクス画面表示
Route::get('/thanks', [RegisterController::class, 'getThanks'])->name('thanks'); // サンクス画面表示

// メール認証関連のルート
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice'); // メール認証通知画面表示

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/thanks');
})->middleware(['auth', 'signed'])->name('verification.verify'); // メール認証処理

Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証リンクを再送信しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend'); // 認証リンク再送信

// モーダル関連のルート
Route::get('/show-modal', [ModalController::class, 'show'])->name('showModal'); // モーダル表示
Route::get('/hide-modal', [ModalController::class, 'hide'])->name('hideModal'); // モーダル非表示

// ログアウト処理
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout'); // ログアウト処理

// お気に入り関連のルート
Route::post('/favorite/toggle', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle'); // お気に入り登録/解除

// 予約関連のルート
Route::post('/reserve', [ReservationController::class, 'create'])->name('reservation.create'); // 予約登録処理
Route::post('/reserve/delete', [ReservationController::class, 'delete'])->name('reservation.delete'); // 予約取り消し処理
Route::put('/reserve/{reservation}', [UserController::class, 'updateReservation'])->name('reservation.update'); // 予約変更処理
Route::post('/reserve/{reservation}/review', [UserController::class, 'reviewReservation'])->name('reservation.review'); // 来店レビュー処理
Route::post('/reserve/review', [UserController::class, 'saveReview'])->name('reservation.saveReview'); // 来店レビュー保存処理

// 予約完了ページ表示
Route::get('/done', [ReservationController::class, 'done'])->name('reservation.done'); // 予約完了ページ表示

// お店関連のルート
Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create'); // お店情報入力フォーム表示
Route::post('/shops', [ShopController::class, 'store'])->name('shops.store'); // お店情報保存処理
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('shop.detail'); // 店舗詳細ページ表示
Route::post('/detail/{shop_id}/update-summary', [ShopController::class, 'updateSummary'])->name('shop.updateSummary'); // 予約ページの日付・時間・人数表示

Route::middleware([ClearModalSession::class])->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('shop.index'); // 飲食店一覧画面表示
    Route::get('/login', [AuthController::class, 'create'])->name('login'); // ログイン画面表示
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage'); // マイページ表示
    // 他のルートもここに移動
});

// 管理者関連のルート
Route::get('/admin-register', [AuthController::class, 'createAdminRegister'])->name('admin.register'); // 管理者登録画面表示
Route::post('/admin-register', [AuthController::class, 'storeAdminRegister'])->name('admin.register.store'); // 管理者登録処理
Route::get('/admin-login', [AuthController::class, 'createAdminLogin'])->name('admin.login'); // 管理者ログイン画面表示
Route::post('/admin-login', [AuthController::class, 'storeAdminLogin'])->name('admin.login.store'); // 管理者ログイン処理

// 管理者専用ルート（認証が必要）
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); // 管理者ダッシュボード表示
    Route::post('/admin/create-shop-owner', [AuthController::class, 'createShopOwner'])->name('admin.createShopOwner'); // 店舗代表者作成処理
    Route::get('/admin-shop', [AdminController::class, 'adminShop'])->name('admin.shop'); // 管理者オーナー一覧画面表示
    Route::delete('/admin-shop/delete/{id}', [AdminController::class, 'deleteOwner'])->name('admin.shop.delete'); // オーナー削除処理
});

// 店舗代表者関連のルート
Route::get('/owner-register', [AuthController::class, 'createShopOwnerRegister'])->name('shopOwner.register'); // 店舗代表者登録画面表示
Route::post('/owner-register', [AuthController::class, 'storeShopOwnerRegister'])->name('shopOwner.register.store'); // 店舗代表者登録処理

// 店舗代表者専用ルート（認証が必要）
Route::middleware(['auth:shop_owner'])->group(function () {
    Route::get('/shop-owner/dashboard', [ShopOwnerController::class, 'dashboard'])->name('shopOwner.dashboard'); // 店舗代表者ダッシュボード表示
    
    Route::get('/shop-owner/shops', [ShopOwnerController::class, 'ownerShop'])->name('shopOwner.ownerShop'); // 店舗一覧表示
    
    Route::get('/shop-owner/create', [ShopOwnerController::class, 'createShop'])->name('shopOwner.createShop'); // 店舗作成画面表示
    
    Route::post('/shop-owner/store', [ShopOwnerController::class, 'storeShop'])->name('shopOwner.storeShop'); // 店舗作成処理
    
    Route::post('/shop-owner/load', [ShopOwnerController::class, 'loadShop'])->name('shopOwner.loadShop'); // 店舗情報読み込み処理
    
    Route::delete('/shop-owner/delete/{id}', [ShopOwnerController::class, 'deleteShop'])->name('shopOwner.deleteShop'); // 店舗削除処理
    
    Route::get('/shop-owner/reservations', [ShopOwnerController::class, 'ownerReservation'])->name('shopOwner.ownerReservation'); // 予約状況表示
    Route::get('/shop-owner/reservations/{id}/qr-code', [ShopOwnerController::class, 'showQRCode'])->name('shopOwner.showQRCode'); // QRコード表示
    
    Route::put('/shop-owner/reservations/{id}', [ShopOwnerController::class, 'updateReservation'])->name('shopOwner.updateReservation'); // 予約更新処理
    
    Route::get('/owner-mail', [ShopOwnerController::class, 'showMailForm'])->name('shopOwner.showMailForm'); // メール送信画面表示
    
    Route::post('/owner-mail', [ShopOwnerController::class, 'sendMail'])->name('shopOwner.sendMail'); // メール送信処理
});

// 店舗代表者ログイン関連のルート
Route::get('/owner-login', [AuthController::class, 'createShopOwnerLogin'])->name('shopOwner.login'); // 店舗代表者ログイン画面表示
Route::post('/owner-login', [AuthController::class, 'storeShopOwnerLogin'])->name('shopOwner.login.store'); // 店舗代表者ログイン処理

// リマインダーメール送信テスト
Route::get('/test-send-reminder-email/{reservationId}', [ReservationController::class, 'testSendReminderEmail']); // リマインダーメール送信テスト

// Stripe決済関連のルート
Route::post('/create-checkout-session', [UserController::class, 'createCheckoutSession'])->name('createCheckoutSession');