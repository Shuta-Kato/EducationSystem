<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>管理 新規ユーザー管理</title>
        <link rel="stylesheet" href="{{ asset('/css/admin/auth/register.css') }}">
    </head>
	<body>
        <a href="{{route('show.login')}}" class="login">
            ログインはこちら
        </a> 
        <h1>新規管理ユーザー登録</h1>
        <form action="{{route('show.register.create')}}" method="POST" >
            @csrf
            <ul>
                <li>
                    <label for="text1">ユーザーネーム</label>
                    <input type="text" name="name">
                </li>
                <li>
                    <label for="text2">カナ</label>
                    <input type="text" name="kana">
                </li>
                <li>
                    <label for="text3">メールアドレス</label>
                    <input type="email" name="email">
                </li>
                <li>
                    <label for="text4">パスワード</label>
                    <input type="password" name="password">
                </li>
                <li>
                    <label for="text5">パスワード確認</label>
                    <input type="password" name="password_confirmation">
                </li>
            </ul>
            <div class="register">
                <button type="submit">登録</button>
            </div>
        </form>
        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </body>
</html>