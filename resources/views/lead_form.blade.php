@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <form method="post" id="qa_form" action="">
        @csrf
        <div class="card">
            <div class="card-header" style="justify-content: space-between;">
                <h4>Quality Assurance Form</h4>
            </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </form>
