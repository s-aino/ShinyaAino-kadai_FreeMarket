<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<h1>Top</h1><p><a href="/login">ログイン</a> / <a href="/register">新規登録</a></p>';
});
Route::view('/', 'top'); 
Route::redirect('/home', '/');