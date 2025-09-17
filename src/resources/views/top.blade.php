<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Top</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family:system-ui,'Noto Sans JP',sans-serif;margin:24px">
    <h1>Top</h1>

    @auth
    <p>ログイン中：{{ auth()->user()->name }}（{{ auth()->user()->email }}）</p>
    <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
    @else
    <p>
        <a href="/login">ログイン</a>
        ／
        <a href="/register">新規登録</a>
    </p>
    @endauth

</body>

</html>