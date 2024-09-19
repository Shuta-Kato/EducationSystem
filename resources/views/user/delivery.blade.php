@extends('user.layouts.app')

@push('css')
    <link href="{{asset('/css/user/delivery.css')}}" rel="stylesheet">
@endpush

@section('content')
<a link href="{{route('user.show.top')}}" id="backbtn">←戻る</a>
<div class="video-content">
   @if($display_flg == 1)
   <video controls src="{{$curriculum -> video_url}}" class = "video"></video>
   @else
   <div class="video-nondisplay">配信期間外です</div>
   @endif

   @if($clear_flg == 0 && $display_flg == 1)

   <form  action="{{ route('user.update.clearFlg', $curriculum -> id) }}" method="POST">
   @csrf
   <div class = "flg-btn-space">
     <button class="flg-btn" type = "submit" >受講しました</button>
   </div>
   </form>

   @else
   @endif
</div>

<div class="video-information">
   <h1 class="grade-label">小学校{{$curriculum -> grade_id}}年生</h1>
   <h1>{{$curriculum -> title}}</h1>
   <p>講座内容</p>
   <p>{{$curriculum -> description}}</p>
</div>

@endsection