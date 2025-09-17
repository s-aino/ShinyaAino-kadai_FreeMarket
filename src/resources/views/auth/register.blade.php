<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>新規登録</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family:system-ui,'Noto Sans JP',sans-serif;margin:24px">
    <h1>新規登録</h1>
    @if ($errors->any()) <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul> @endif
    <form method="POST" action="{{ route('register') }}" style="max-width:420px;margin:auto;display:grid;gap:12px">
        @csrf
        <input name="name" type="text" placeholder="お名前" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="パスワード" required>
        <input name="password_confirmation" type="password" placeholder="パスワード（確認）" required>
        <button type="submit">登録</button>
    </form>
    <p><a href="/login">ログインへ</a> / <a href="/">トップへ</a></p>
</body>

</html>