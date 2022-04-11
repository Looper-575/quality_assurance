@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <style>
       #change_profile_pic label {
            color: white;
            padding: 0.5rem;
            font-family: sans-serif;
            border-radius: 0.3rem;
            cursor: pointer;
            margin-top: 1rem;
       }
    </style>
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="e-profile">
                                    <div class="tab-content pt-3">
                                        <div class="tab-pane active">
                                            <form id="edit_user_profile_form" action="javascript:save_profile_changes();">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{Auth::user()->user_id}}">
                                                <div class="row">
                                                    <div class="col-12 col-sm-auto mb-3">
                                                        <div class="mx-auto" style="width: 140px;">
                                                            <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px;">
                                                                <div class="m-card-user__pic">
                                                                    <img class="mb-5 rounded-circle" src="{{ isset(Auth::user()->image)? asset('user_images/'.Auth::user()->image):asset('assets/img/users/user4.jpg')}}" id="profile_image" style="border: 1px solid #6F6F6F"  width="100px" height="100px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                            <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{Auth::user()->full_name}}</h4>
                                                            <div class="mt-2" id="change_profile_pic">
                                                                <input name="user_image" type="file" id="profile_image_select"  hidden/>
                                                                <label class="bg-primary" for="profile_image_select">Change Picture</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2"><b>User Information</b></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                                                </div>
                                                                <input type="text"  class="form-control"  name="full_name" value="{{Auth::user()->full_name}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 ">
                                                        <div class="form-group">
                                                            <label for="contact">Contact Number</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i class="fas fa-address-card"></i></div>
                                                                </div>
                                                                <input type="number" name="contact_number"  class="form-control" placeholder="contact number" value="{{Auth::user()->contact_number}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="user_address">Address</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i class="fa fa-location-arrow"></i></div>
                                                                </div>
                                                                <input type="text" id="postal_address" class="form-control"  name="postal_address" value="{{Auth::user()->postal_address}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <div class="mb-2"><b>Change Password</b></div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>New Password</label>
                                                                    <input id="password" name="password" class="form-control" type="password">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                                                                    <input id="password_confirmation" name="password_confirmation" class="form-control" type="password"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-12 mb-3"><b>Please Enter Your Password below to confirm and save changes</b></div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Current Password</label>
                                                            <input name="current_password" class="form-control" type="password" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary m-t-15 waves-effect float-right">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script>
        document.getElementById('profile_image_select').addEventListener('change',function (event) {
            var image = document.getElementById('profile_image');
            image.src = URL.createObjectURL(event.target.files[0]);
        });
        $('#password').keyup(function(){
            if($(this).val()!=''){
                $('#password_confirmation').attr('required',true);
            }
            else{
                $('#password_confirmation').attr('required',false);
            }
        });
        $('#password_confirmation').keyup(function(){
            if($(this).val()!=''){
                $('#password').attr('required',true);
            }else{
                $('#password').attr('required',false);
            }
        });
        function save_profile_changes(){
            let user_form =document.getElementById('edit_user_profile_form');
            let data = new FormData(user_form);
            let a = function () {
                window.location.reload();
            };
            let arr = [a];
            call_ajax_with_functions('','{{route('save_profile_changes')}}', data,arr);
        }
    </script>
@endsection