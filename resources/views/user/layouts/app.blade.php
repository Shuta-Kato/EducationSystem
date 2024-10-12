<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- CSS -->
     <link rel="stylesheet" href="{{asset('/css/user/banner.css')}}">
     @stack('css')
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <div class="container">
                <a href = "{{route('user.show.curriculum.list')}}" class="bannar-button">時間割</a>
                <a href = "{{route('user.show.progress')}}" class="bannar-button">授業進捗</a>
                <a href = "{{route('user.show.profile')}}" class="bannar-button">プロフィール設定</a>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.show.login') }}">ログイン</a>
                                </li>
                            @endif

                        @else
                                 <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.show.login') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">ログアウト</a>
                                </li>
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
