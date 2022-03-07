@extends('layout.template')
@section('content')
    <h2 class="text-center">Atlantis BPO Chat</h2>
    <iframe src="https://atlantisbpo.com/login_from_crm?username={{\Illuminate\Support\Facades\Auth::user()->email}}&password=AtlantisCRMChat@123$&redirect_uri=crm_chats"
            frameborder="0" width="100%" height="100%" style="min-height: 90vh" ></iframe>
@endsection
