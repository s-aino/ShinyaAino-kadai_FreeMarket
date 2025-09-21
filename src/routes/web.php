<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<h1>Top</h1><p><a href="/login">ログイン</a> / <a href="/register">新規登録</a></p>';
});
Route::view('/', 'top');
Route::redirect('/home', '/');
// 公開
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

// 要ログイン
Route::middleware('auth')->group(function () {
    // 出品
    Route::get('/sell',  [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');

    // 購入フロー（単品）
    Route::get('/purchase/{item}',  [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');

    // 住所フォームを分離
    Route::get('/purchase/{item}/address',  [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
    Route::post('/purchase/{item}/address', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    // コメント
    Route::post('/item/{item}/comments', [CommentController::class, 'store'])->name('comments.store');

    // マイページ
    Route::get('/mypage',            [MyPageController::class, 'show'])->name('mypage.show');
    Route::get('/mypage/purchases',  [MyPageController::class, 'purchases'])->name('mypage.purchases');
    Route::get('/mypage/sales',      [MyPageController::class, 'sales'])->name('mypage.sales');
});
