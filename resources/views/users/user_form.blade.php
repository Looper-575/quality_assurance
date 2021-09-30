@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" id="" action="{{ route('user_save') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>User Form</h4>
                    </div>
                    <div class="card-body" id="add_more_cats_data">
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label"> Full Name</label>
                                    <input name="full_name"   type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label">Email</label>
                                    <input name="email"  type="email" class="form-control">
                                </div>
                            </div>
                       
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label">Password</label>
                                    <input name="password"  type="password" class="form-control">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label">Image</label>
                                    <input name="image"  type="file" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label">Gender</label><br>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="male">Male </label>
                                        <input class="form-check-input" name="gender" id="male" type="radio"  value="1" checked >
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="female"> Female </label>
                                        <input class="form-check-input" name="gender" id="female" type="radio"  value="0">
                                    </div>
                                </div>
                           </div>

                           <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label" for="">Postal Address</label>
                                <input  class="form-control type="text" name="postal_address" id="">
                            </div>
                           </div>

                           <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label" for="">Contact Number</label>
                                <input  class="form-control type="number" name="contact_number" id="">
                            </div>
                           </div>

                           <div class="col-6">
                            <label  for="agent_id"><strong> Role  </strong> </label>
                            <select class="form-control" name="role_id" id="" required>
                            <option class="form-control" value="" selected>Plese Select</option>
                            @foreach($user_roles as $user_role)
                            <option value="{{$user_role->role_id}}">{{$user_role->title}}</option>
                            @endforeach
                            </select>
                           </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-danger" id="cancel_action" type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    {{-- <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            if (jQuery().select2) {
                $(".select2").select2();
            }
            //form submission;
            $('#product_form').submit(function (e) {
                e.preventDefault();
                let data = new FormData(this);
                let a = function(){ /*window.location.href = '{{ route('') }}';*/ };
                let arr = [a];
                call_ajax_with_functions('','{{ isset($product) ? route('qa.update', $product->product_id) : route('qa.store') }}',data,arr);
            });
            // Cancel action
            $('#cancel_action').click(function (){
                window.location.href="{{route('qa.index')}}";
            });
        });
    </script> --}}
@endsection
