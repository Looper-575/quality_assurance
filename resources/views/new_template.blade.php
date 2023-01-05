@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')
    <h3>Welcome {{\Illuminate\Support\Facades\Auth::user()->full_name}}</h3>
@endsection
@section('footer_scripts')
@endsection
