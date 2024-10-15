<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>管理 トップ</title>
        <link rel="stylesheet" href="{{ asset('/css/admin/top.css') }}">
    </head>
	<body>
        @extends('admin.layouts.app')

        @section('title', '管理 トップ')

        @section('content')
            <ul class="user_data">
                <li>ユーザーネーム : {{ $adminUser->name ?? '未ログイン' }}</li>
                <li>メールアドレス : {{ $adminUser->email ?? '未ログイン' }}</li>
            </ul>
        @endsection
    </body>
</html>
    
    