<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

// CreateNewUser を使っている場合
use App\Actions\Fortify\CreateNewUser;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Fortify が入っているときだけ実行
        if (!class_exists(Fortify::class)) {
            return;
        }

        // 画面の割当て（あなたの blade に合わせて OK）
        Fortify::registerView(fn () => view('auth.register'));
        Fortify::loginView(fn () => view('auth.login'));

        // 新規ユーザー作成のアクションを紐付け（存在するなら）
        if (class_exists(CreateNewUser::class)) {
            Fortify::createUsersUsing(CreateNewUser::class);
        }
    }
}
