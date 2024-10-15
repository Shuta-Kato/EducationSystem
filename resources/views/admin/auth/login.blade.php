<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>管理 ログイン</title>
        <link rel="stylesheet" href="{{ asset('/css/admin/auth/login.css') }}">
    </head>
	<body>
        <a href="{{route('show.register')}}" class="register">
            新規会員登録はこちら
        </a> 
        <h1>管理画面ログイン</h1>
        <form action="{{route('show.login.send')}}" method="POST">
            @csrf
            <ul>
                <li>
                    <label for="text1">メールアドレス</label>
                    <input type="email" name="email">
                </li>
                <li>
                    <label for="text2">パスワード</label>
                    <input type="password" name="password">
                </li>
            </ul>
            <div class="login">
                <button type="submit">ログイン</button>
            </div>
        </form>
        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </body>
</html>