<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'fleamarket')</title>
</head>

<body>
    <header>
        <nav>
            <a href="{{ url('/') }}">TOP</a>

            @auth
            <form action="{{ url('/logout') }}" method="POST" style="display:inline; margin-left:.5rem;">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
            @endauth

            @guest
            <a href="{{ url('/login') }}" style="margin-left:.5rem;">ログイン</a>
            @endguest
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>