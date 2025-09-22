<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{

    public function create(array $input): User
    {
        // ルール
        $rules = [
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' =>
            [
                'required',
                'string',
                'confirmed', // confirmed => password_confirmation と一致
                Password::min(8),
            ],       // 既定: 8文字以上 など

        ];

        // 日本語メッセージ（評価対象と明記されている文言）
        $messages = [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email'    => 'メールアドレスはメール形式で入力してください',
            'password.required'  => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードと一致しません',
            'password.min'       => 'パスワードは8文字以上で入力してください',
        ];

        Validator::make($input, $rules, $messages)->validate();

        return User::create([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
