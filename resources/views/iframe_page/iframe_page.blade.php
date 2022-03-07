@extends('layout.template')
@section('content')
    <h2 class="text-center">{{$page_title}}</h2>
    <iframe src="{{$iframe_url}}"
            frameborder="0" width="100%" height="100%" style="min-height: 90vh" ></iframe>
@endsection
