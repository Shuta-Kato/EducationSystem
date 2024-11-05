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
                        <input type="text" class="form-control" name="data[{{ $index }}][start_date]" placeholder="年/月/日" value="{{ $delivery_time['start_date'] }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[{{ $index }}][start_time]" placeholder="時:分" value="{{ $delivery_time['start_time'] }}">
                    </div>
                    <div class="col-md-1 text-center">
                        ～
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="data[{{ $index }}][end_date]" placeholder="年/月/日" value="{{ $delivery_time['end_date'] }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[{{ $index }}][end_time]" placeholder="時:分" value="{{ $delivery_time['end_time'] }}">
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
                        <input type="text" class="form-control" name="data[0][start_date]" placeholder="年/月/日" value="">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[0][start_time]" placeholder="時:分" value="">
                    </div>
                    <div class="col-md-1 text-center">
                        ～
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="data[0][end_date]" placeholder="年/月/日" value="">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="data[0][end_time]" placeholder="時:分" value="">
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
            let newItem = document.querySelector('.schedule-item').cloneNode(true);

            // 空のフィールドに設定
            newItem.querySelectorAll('input').forEach(input => input.value = '');
            newItem.querySelector('.btn-remove-delivery_time').removeAttribute('data-id'); // 新規項目にはIDを設定しない

            scheduleList.appendChild(newItem);
        });

        // 行削除ボタン
        document.getElementById('schedule-list').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove-delivery_time')) {
                let id = event.target.getAttribute('data-id');
                if (id) {

                    // データベースから削除リクエストを送信
                    fetch(`/admin/delivery_time/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                // 行を削除
                                event.target.closest('.schedule-item').remove();
                            } else {
                                alert('削除に失敗しました');
                            }
                        })
                        .catch(error => alert('エラーが発生しました'));
                } else {
                    // 新規追加した行を削除
                    event.target.closest('.schedule-item').remove();
                }
            }
        });
    });
</script>

@endsection