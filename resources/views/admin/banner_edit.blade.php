<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>管理 バナー管理</title>
        <link rel="stylesheet" href="{{ asset('/css/admin/banner_edit.css') }}">
        <script src="{{ asset('/js/admin/banner_edit.js') }}"></script>
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
            <form id="logout" action="{{route('show.logout') }}" method="POST">
                @csrf
                <input type="submit" class="logout" value="ログアウト">
            </form>
        </header>
        <a href="{{route('show.top')}}" class="back">
            ⇦戻る
        </a>  
        <h1>バナー管理</h1>
        <form action="{{ route('show.banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <table id="bannerTable">
                <tbody>
                    <tr>
                        <td><img class="banner_image" id="preview1"></td>
                        <td><input type="file" class="file-input" name="banner_images[]" onchange="previewImage(event, 1)"></td>
                        <td>
                            <button class="delete_button" onclick="deleteRow(this)">ー</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="addition_button" type="button" onclick="addRow()">+</button>
            <input type="submit" class="register" value="登録">
        </form>
    </body>
</html>