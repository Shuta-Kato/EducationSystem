@extends('admin.layouts.app')

@section('content')

<div class="container">
    <button type="button" onclick="history.back()" class="btn btn-secondary"> &larr; 戻る</button>

    <h2>授業設定</h2>

    <form action="{{ route('admin.curriculum.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- サムネイルとファイル選択 -->
        <div class="form-group d-flex align-items-center">
            <div class="thumbnail-container">
                <img id="thumbnail-preview" src="" alt="サムネイル画像" class="img-thumbnail" style="height: 120px; display: 'none';" />
            </div>
            <div class="ml-3">
                <label for="thumbnail">サムネイル</label>
                <input type="file" name="thumbnail" class="form-control-file" id="thumbnail" accept="image/*" onchange="previewThumbnail()">
            </div>
        </div>

        <!-- 学年 -->
        <div class="form-group row">
            <label for="grade_id" class="col-md-3 col-form-label">学年</label>
            <div class="col-md-9">
                <select name="grade_id" class="form-control">
                    @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $grade->id  ? 'selected' : '' }}>{{ $grade->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- 授業名 -->
        <div class="form-group row">
            <label for="title" class="col-md-3 col-form-label">授業名</label>
            <div class="col-md-9">
                <input type="text" name="title" class="form-control" maxlength="255" required>
            </div>
        </div>

        <!-- 動画URL -->
        <div class="form-group row">
            <label for="video_url" class="col-md-3 col-form-label">動画URL</label>
            <div class="col-md-9">
                <input type="text" name="video_url" class="form-control" maxlength="255" required>
            </div>
        </div>

        <!-- 授業概要 -->
        <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label">授業概要</label>
            <div class="col-md-9">
                <textarea name="description" class="form-control" maxlength="255" required></textarea>
            </div>
        </div>

        <!-- 常時公開 -->
        <div class="form-group row">
            <label for="alway_delivery_flg" class="col-md-3 col-form-label">常時公開</label>
            <div class="col-md-9 d-flex align-items-center">
                <input type="checkbox" name="alway_delivery_flg" value="1"
                    {{ old('alway_delivery_flg', $curriculum->alway_delivery_flg ?? 1) ? 'checked' : '' }}>
            </div>
        </div>


        <!-- 登録ボタン -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">登録</button>
        </div>
    </form>
</div>

<!-- サムネイル画像プレビュー用のJavaScript -->
<script>
    function previewThumbnail() {
        var file = document.getElementById("thumbnail").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            var preview = document.getElementById('thumbnail-preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            document.getElementById('thumbnail-preview').style.display = 'none';
        }
    }
</script>

@endsection