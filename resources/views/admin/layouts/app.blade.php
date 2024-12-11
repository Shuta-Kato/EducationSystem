<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '管理 トップ')</title>
    <link rel="stylesheet" href="{{ asset('/css/admin/auth/curriculum.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin/top.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin/auth/delivery_time.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin/auth/curriculum_edit.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <header>
        <ul class="transition">
            <form action="#" method="GET">
                <li><button type="submit">授業管理</button></li>
            </form>
            <form action="#" method="GET">
                <li><button type="submit">お知らせ管理</button></li>
            </form>
            <form action="{{ route('show.banner.edit') }}" method="GET">
                <li><button type="submit">バナー管理</button></li>
            </form>
        </ul>
        <form id="logout" action="{{ route('show.logout') }}" method="POST">
            @csrf
            <input type="submit" class="logout" value="ログアウト">
        </form>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>