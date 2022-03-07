@extends('layout.template')
@section('content')
    <h2 class="text-center">CIUSA Chat</h2>
    <iframe src="https://cableinternetusa.com/login_from_crm?username={{\Illuminate\Support\Facades\Auth::user()->email}}&password=AtlantisCRMChat@123$"
            frameborder="0" width="100%" height="100%" style="min-height: 90vh" ></iframe>
@endsection
