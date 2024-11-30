@extends('admin.layouts.app')

@section('content')

<div class="container">
    <!-- ヘッダーと戻るボタン -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="#" class="btn btn-secondary custom-back-button">&larr; 戻る</a>
            <h2 class="section-title">授業一覧</h2>
            <div class="mb-3">
                <a href="{{ route('admin.curriculum.create') }}" class="btn btn-primary">新規登録</a>
            </div>
            <div id="current-grade-container" class="current-grade-container">
                <p id="current-grade" class="current-grade">{{ $currentGrade }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- サイドバー (学年選択ボタン) -->
        <div class="col-md-2">
            <ul class="list-group grade-list list-unstyled align-items-center">
                @foreach($formateGrades as $grade)
                <li class="mb-2">
                    <button type="button" class="btn grade-button" data-grade-id="{{ $grade->id }}">{{ $grade->name }}</button>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- 授業リスト -->
        <div class="col-md-10">
            <div class="row row-cols-1 row-cols-md-3 g-4" id="curriculum-list">
                @foreach($curriculums as $curriculum)
                <div class="col">
                    <div class="card curriculum-card">
                        @if ($curriculum->thumbnail)
                        <div class="img-container">
                            <img src="{{ asset($curriculum->thumbnail) }}" style="height: 200px;" alt="授業画像" class="card-img-top">
                        </div>
                        @else
                        <p class="text-center">画像はありません</p>
                        @endif
                        <div class="card-body-custom">
                            <h5 class="card-title">{{ $curriculum->title }}</h5>
                            <ul class="list-group list-group-flush">
                                @foreach($curriculum->deliveryTimes as $deliveryTime)
                                <li class="list-group-item">
                                    {{ $deliveryTime->start_date }} {{ $deliveryTime->start_time }} ~ {{ $deliveryTime->end_time }}
                                </li>
                                @endforeach
                            </ul>
                            <div class="mt-3 d-flex justify-content-center">
                                <a href="{{ route('admin.curriculum.edit', ['id' => $curriculum->id]) }}" class="btn btn-info custom-btn">授業内容編集</a>
                                @if($curriculum->alway_delivery_flg)
                                <button class="btn btn-secondary custom-btn" disabled>配信日時編集</button>
                                @else
                                <a href="{{ route('admin.delivery_time.show', ['id' => $curriculum->id]) }}" class="btn btn-secondary custom-btn">配信日時編集</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- 非同期通信のためのスクリプト -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.grade-button').on('click', function() {
            const gradeId = $(this).data('grade-id');

            $.ajax({
                url: `/admin/curriculum/grade/${gradeId}`,
                method: 'GET',
                success: function(response) {
                    // 学年名をIDを使って更新
                    $('#current-grade').text(response.currentGrade);

                    // カリキュラムリストを更新
                    $('#curriculum-list').empty();
                    response.curriculums.forEach(function(curriculum) {
                        const deliveryTimesHtml = curriculum.delivery_times.map(time => {
                            return `<li class="list-group-item">
                                        ${time.start_date} ${time.start_time} ~ ${time.end_time}
                                    </li>`;
                        }).join('');

                        const cardHtml = `
                            <div class="col">
                                <div class="card curriculum-card">
                                    ${
                                        curriculum.thumbnail
                                            ? `<img src="${curriculum.thumbnail}" alt="授業画像" style="height: 200px;" class="card-img-top">`
                                            : '<p class="text-center">画像はありません</p>'
                                    }
                                    <div class="card-body">
                                        <h5 class="card-title">${curriculum.title}</h5>
                                        <ul class="list-group list-group-flush">
                                            ${deliveryTimesHtml}
                                        </ul>
                                        <div class="mt-3 d-flex justify-content-center">
                                            <a href="/admin/curriculum_edit/${curriculum.id}" class="btn btn-info custom-btn">授業内容編集</a>
                                            ${
                                                curriculum.alway_delivery_flg
                                                    ? '<button class="btn btn-secondary custom-btn" disabled>配信日時編集</button>'
                                                    : `<a href="/admin/delivery_time/show/${curriculum.id}" class="btn btn-secondary custom-btn">配信日時編集</a>`
                                            }
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#curriculum-list').append(cardHtml);
                    });
                },
                error: function() {
                    alert('データの取得に失敗しました');
                }
            });
        });
    });
</script>

@endsection