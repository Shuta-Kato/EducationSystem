<<<<<<< HEAD
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ユーザー 時間割</title>
        <link rel="stylesheet" href="{{ asset('/css/user/curriculum_list.css') }}">
        <script src="{{ asset('/js/user/curriculum_list.js') }}"></script>
    </head>
    <body>
        <header>
            <ul class="transition">
                <form action="#" method="GET">
                    <li><button type="submit">時間割</button></li>
                </form>
                <form action="#" method="GET">
                    <li><button type="submit">授業進捗</button></li>
                </form>
                <form action="#" method="GET">
                    <li><button type="submit">プロフィール設定</button></li>
                </form>
            </ul>
            <form id="logout" action="#" method="null">
                @csrf
                <input type="submit" class="logout" value="ログアウト">
            </form>
        </header> 
        <a href="#" class="back">
            ⇦戻る
        </a>  
        <div class="schedule">
            <button class="arrow" onclick="goToPrevMonth()">◀️</button>
            <div class="data" id="monthDisplay"></div>
            <button class="arrow" onclick="goToNextMonth()">▶️</button>
            <div class="class" id="currentGradeDisplay"></div>
        </div>
        <div class="container">
            <ul class="grade">
                <li><button type="button" onclick="selectGrade('小学校1年生')">小学校1年生</button></li>
                <li><button type="button" onclick="selectGrade('小学校2年生')">小学校2年生</button></li>
                <li><button type="button" onclick="selectGrade('小学校3年生')">小学校3年生</button></li>
                <li><button type="button" onclick="selectGrade('小学校4年生')">小学校4年生</button></li>
                <li><button type="button" onclick="selectGrade('小学校5年生')">小学校5年生</button></li>
                <li><button type="button" onclick="selectGrade('小学校6年生')">小学校6年生</button></li>
                <li><button type="button" onclick="selectGrade('中学校1年生')">中学校1年生</button></li>
                <li><button type="button" onclick="selectGrade('中学校2年生')">中学校2年生</button></li>
                <li><button type="button" onclick="selectGrade('中学校3年生')">中学校3年生</button></li>
                <li><button type="button" onclick="selectGrade('高校1年生')">高校1年生</button></li>
                <li><button type="button" onclick="selectGrade('高校2年生')">高校2年生</button></li>
                <li><button type="button" onclick="selectGrade('高校3年生')">高校3年生</button></li>
            </ul>
            <div class="thumbnail" id="scheduleContent">
            </div>
        </div>
    </body>
</html>
=======
@extends('user.layouts.app')

@section('content')
<h1>時間割ページ</h1>
@endsection
>>>>>>> origin/team_develop
