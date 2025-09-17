<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: system-ui, "Noto Sans JP", sans-serif;
            margin: 24px
        }

        form {
            max-width: 360px;
            margin: auto;
            display: grid;
            gap: 12px
        }

        input,
        button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px
        }

        button {
            cursor: pointer
        }
    </style>
</head>

<body>
    <h1>ログイン</h1>
    @if ($errors->any()) <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul> @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input name="email" type="email" placeholder="Email" required value="test@example.com">
        <input name="password" type="password" placeholder="Password" required value="password">
        <button type="submit">ログイン</button>
    </form>
    <p><a href="/">← トップへ</a></p>
</body>

</html>