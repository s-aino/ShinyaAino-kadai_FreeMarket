{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('title', '会員登録')

@section('content')
<h1>会員登録</h1>

{{-- まとめてのエラー表示（ページ上部） --}}
@if ($errors->any())
<ul>
    @foreach ($errors->all() as $e)
    <li>{{ $e }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="{{ url('/register') }}" novalidate>
    @csrf

    <div>
        <label for="name">ユーザー名</label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name') }}"
            maxlength="20"
            autocomplete="name"
            autocapitalize="off"
            autocorrect="off"
            inputmode="text"
            required>
        @error('name') <p>{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email">メールアドレス</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            autocomplete="email"
            required>
        @error('email') <p>{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="password">パスワード</label>
        <input
            id="password"
            type="password"
            name="password"
            autocomplete="new-password"
            required>
        @error('password') <p>{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="password_confirmation">確認用パスワード</label>
        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            autocomplete="new-password"
            required>
    </div>

    <button type="submit">登録する</button>
</form>

<p><a href="{{ url('/login') }}">ログインはこちら</a></p>
@endsection
