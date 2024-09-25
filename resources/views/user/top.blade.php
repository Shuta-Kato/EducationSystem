@extends('user.layouts.app')

@push('css')
    <link href="{{asset('/css/user/top.css')}}" rel="stylesheet">
@endpush

@section('content')
<div id="banner">
@foreach($banners as $index => $banner)
  <div id="banner-{{ $index }}">
    <img src="{{asset('storage/images/banner/'. $banner -> image)}}">
  </div>
 @endforeach
</div>

<div id = "space-icon">
  <div id = "icon-0"></div>
  <div id = "icon-1"></div>
  <div id = "icon-2"></div>
  <div id = "icon-3"></div>
</div>


<div class="information">
   <h2>お知らせ</h2>
   <div class="information-content">
    @foreach($articles as $article)
      <p>
        <span class="info-date">
            {{\Carbon\Carbon::parse($article -> posted_date)->format("Y年m月d日")}}
        </span> 
        <a href = "{{route('user.show.article', $article -> id)}}">
         {{$article -> title}}
        </a>
      </p>
    @endforeach
   </div>
</div>

<script src="{{asset('/js/user/top.js')}}"></script>

@endsection