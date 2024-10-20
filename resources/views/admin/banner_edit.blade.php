<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>管理 バナー管理</title>
        <link rel="stylesheet" href="{{ asset('/css/admin/banner_edit.css') }}">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    @foreach($banners as $banner)
                    <tr>
                        <td><img class="banner_image" src="{{ asset('storage/' . $banner->image) }}" id="banner-{{ $banner->id }}"></td>
                        <td><input type="file" class="file-input" name="banner_images[]" onchange="previewImage(event, 1)" multiple></td>
                        <td>
                        <button class="delete_button" type="button" onclick="deleteExistingRow({{ $banner->id }}, '{{ route('show.banner.delete', $banner->id) }}')">ー</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="addition_button" type="button" onclick="addRow()">+</button>
            <input type="submit" class="register" value="登録">
        </form>
    </body>
</html>