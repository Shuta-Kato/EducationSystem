<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <form id="logout" action="{{ route('user.logout') }}" method="POST">
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
                <li><button type="button" data-grade-id="1" onclick="selectGrade(1)">小学校1年生</button></li>
                <li><button type="button" data-grade-id="2" onclick="selectGrade(2)">小学校2年生</button></li>
                <li><button type="button" data-grade-id="3" onclick="selectGrade(3)">小学校3年生</button></li>
                <li><button type="button" data-grade-id="4" onclick="selectGrade(4)">小学校4年生</button></li>
                <li><button type="button" data-grade-id="5" onclick="selectGrade(5)">小学校5年生</button></li>
                <li><button type="button" data-grade-id="6" onclick="selectGrade(6)">小学校6年生</button></li>
                <li><button type="button" data-grade-id="7" onclick="selectGrade(7)">中学校1年生</button></li>
                <li><button type="button" data-grade-id="8" onclick="selectGrade(8)">中学校2年生</button></li>
                <li><button type="button" data-grade-id="9" onclick="selectGrade(9)">中学校3年生</button></li>
                <li><button type="button" data-grade-id="10" onclick="selectGrade(10)">高校1年生</button></li>
                <li><button type="button" data-grade-id="11" onclick="selectGrade(11)">高校2年生</button></li>
                <li><button type="button" data-grade-id="12" onclick="selectGrade(12)">高校3年生</button></li>
            </ul>
            <div class="thumbnail" id="scheduleContent">
            </div>
        </div>
    </body>
</html>
