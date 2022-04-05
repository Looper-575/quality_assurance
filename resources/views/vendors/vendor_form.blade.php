<link rel="stylesheet" href="{{asset('assets/bundles/select2/dist/css/select2.min.css')}}">
<div class="row">
    <div class="col-12">
        <form method="post" id="vendor_form" action="javascript:save_vendor();" enctype="multipart/form-data">
            @csrf
            <div class="card1">
                <div class="card-body1" id="add_more_cats_data">
                    <div class="row">
                        @if($user)
                            <input type="hidden" value="{{$user->user_id}}" name="user_id">
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label"> Full Name</label>
                                <input name="full_name" value="{{$user ? $user->full_name : ''}}" required type="text" class="form-control">
                            </div>
                        </div>
                            <div class="col-6 mb-4">
                                <label for="agent_id">User Type</label>
                                <select class="form-control" name="user_type" id="user_type" required>
                                    <option class="form-control" {{$user ? ($user->user_type == 'System User' ? 'selected' : '' ): ''}} value="System User">System User</option>
                                </select>
                            </div>
                        <div class="col-6">
                            <label  for="agent_id">Role</label>
                            <select class="form-control" name="role_id" id="" required>
                                @foreach($user_roles as $user_role)
                                    <option selected {{$user ? ($user->role_id == $user_role->role_id ? 'selected' : '' ): ''}}
                                            value="{{$user_role->role_id}}">{{$user_role->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(!$user)
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label">Email</label>
                                    <input name="email" required type="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label">Password</label>
                                    <input name="password" id="pass" required type="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <label class="form-check-label">Confirm Password</label>
                                    <input required id="c_pass" type="password" class="form-control">
                                </div>
                                <div id="pass_response" class="badge-danger p-1 mb-3" style="display: none">Password not matched</div>
                            </div>
                        @endif
                            @if($user)
                                @php $vendor_did_ids = explode(',',$user->vendor_did_id); @endphp
                            @else
                                @php $vendor_did_ids = [0]; @endphp
                            @endif
                            <div class="col-6">
                                <label class="form-check-label" for="agent">Vendor DID ID</label><br>
                                <select class="form-control select2" required name="vendor_did_id[]" id="vendor_did_id" multiple="multiple">
                                        <option value="">All</option>
                                        @foreach($dids as $did)
                                            <option {{(in_array($did->did_id, $vendor_did_ids) ? 'selected' : '') }} value="{{$did->did_id}}">{{$did->title}}</option>
                                        @endforeach
                                </select>
                            </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label">Image</label>
                                <input name="image" type="file" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label">Gender</label>
                                <select name="gender" required class="form-control">
                                    <option {{$user ? ($user->role_id == 'Male' ? 'selected' : '' ): ''}} value="Male">Male </option>
                                    <option {{$user ? ($user->role_id == 'Female' ? 'selected' : '' ): ''}} value="Female">Female </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label" for="">Contact Number</label>
                                <input  class="form-control" value="{{$user ? $user->contact_number : ''}}" type="number" name="contact_number" id="">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-check-label" for="">Postal Address</label>
                                <input  class="form-control" value="{{$user ? $user->postal_address : ''}}" type="text" name="postal_address" id="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <button class="btn btn-danger" type="reset">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js')}}"></script>
