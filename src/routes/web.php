<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileSetupController;

// ===== Fortify（ログイン/ログアウト） =====
Route::view('/', 'welcome');
/* POST /login, POST /logout は Fortify が担当 */

// ===== 出品（sell） =====
Route::middleware('auth')->group(function () {
    Route::get('/sell',  [ItemController::class, 'create'])->name('items.create'); // 画面
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');   // 登録
    Route::get('/setup',  [ProfileSetupController::class, 'edit'])->name('setup.edit');
    Route::put('/setup',  [ProfileSetupController::class, 'update'])->name('setup.update');
});

// ===== 購入フロー =====
Route::middleware('auth')->group(function () {
    // 1) 確認画面
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])
        ->name('purchase.create');

    // 2) 注文作成
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])
        ->name('purchase.store');

    // 3) 住所フォーム（分離版）
    Route::get('/purchase/{item}/address',  [PurchaseController::class, 'editAddress'])
        ->name('purchase.editAddress');
    Route::post('/purchase/{item}/address', [PurchaseController::class, 'updateAddress'])
        ->name('purchase.updateAddress');
});

// ===== コメント =====
Route::middleware('auth')->post('/item/{item}/comments', [CommentController::class, 'store'])
    ->name('comments.store');

// ===== マイページ =====
Route::middleware('auth')->group(function () {
    Route::get('/mypage',            [MyPageController::class, 'show'])->name('mypage.show');
    Route::get('/mypage/purchases',  [MyPageController::class, 'purchases'])->name('mypage.purchases');
    Route::get('/mypage/sales',      [MyPageController::class, 'sales'])->name('mypage.sales');
});
