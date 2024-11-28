@extends('admin.layouts.app')

@section('content')

<div class="container">
    <button type="button" onclick="history.back()" class="btn btn-secondary"> &larr; 戻る</button>

    <!-- 配信日時設定 -->
    <div class="col-12">
        <h2>配信日時設定</h2>
        <p>{{ $title }}</p>

        <form action="{{ route('admin.delivery_time.store') }}" method="POST">
            @csrf
            <input type="hidden" value="{{ $curriculum_id }}" name="curriculum_id">
            <div id="schedule-list">
                @if(count($delivery_times) > 0)
                @foreach($delivery_times as $index => $delivery_time)
                <!-- スケジュール入力行 -->
                <input type="hidden" value="{{ $delivery_time['id'] }}" name="data[{{ $index }}][delivery_time_id]">
                <div class="form-row mb-3 schedule-item">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="data[{{ $index }}][start_date]" placeholder="年/月/日" value="{{ $delivery_time['start_date'] }}" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[{{ $index }}][start_time]" placeholder="時:分" value="{{ $delivery_time['start_time'] }}" required>
                    </div>
                    <div class="col-md-1 text-center">
                        ～
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="data[{{ $index }}][end_date]" placeholder="年/月/日" value="{{ $delivery_time['end_date'] }}" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[{{ $index }}][end_time]" placeholder="時:分" value="{{ $delivery_time['end_time'] }}" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-remove-delivery_time" data-id="{{ $delivery_time['id'] }}">－</button>
                    </div>
                </div>
                @endforeach
                @else
                <!-- データがない場合に表示する空のスケジュール入力行 -->
                <div class="form-row mb-3 schedule-item">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="data[0][start_date]" placeholder="年/月/日" value="" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[0][start_time]" placeholder="時:分" value="" required>
                    </div>
                    <div class="col-md-1 text-center">
                        ～
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="data[0][end_date]" placeholder="年/月/日" value="" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[0][end_time]" placeholder="時:分" value="" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-remove-delivery_time">－</button>
                    </div>
                </div>
                @endif
            </div>

            <!-- 行追加ボタン -->
            <div class="form-group_1">
                <button type="button" class="btn btn-success" id="add-delivery_time">＋</button>
            </div>

            <!-- 登録ボタン -->
            <div class="form-group_2">
                <button type="submit" class="btn btn-primary">登録</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 行追加ボタン
        document.getElementById('add-delivery_time').addEventListener('click', function() {
            let scheduleList = document.getElementById('schedule-list');
            let currentIndex = scheduleList.querySelectorAll('.schedule-item').length;

            // 新しい行のテンプレート
            let newItem = `
                <div class="form-row mb-3 schedule-item">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="data[${currentIndex}][start_date]" placeholder="年/月/日" value="" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[${currentIndex}][start_time]" placeholder="時:分" value="" required>
                    </div>
                    <div class="col-md-1 text-center">～</div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="data[${currentIndex}][end_date]" placeholder="年/月/日" value="" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[${currentIndex}][end_time]" placeholder="時:分" value="" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-remove-delivery_time">－</button>
                    </div>
                </div>
            `;

            // HTMLを追加
            scheduleList.insertAdjacentHTML('beforeend', newItem);
        });

        // 行削除ボタン
        document.getElementById('schedule-list').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove-delivery_time')) {
                let row = event.target.closest('.schedule-item');
                row.remove();
            }
        });
    });
</script>

@endsection