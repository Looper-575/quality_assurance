<div class="row">
    <div class="col-12">
        <form method="post" id="user_form" action="javascript:save_user();" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body" id="add_more_cats_data">
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
                        <div class="col-6">
                            <label  for="agent_id">Role</label>
                            <select class="form-control" name="role_id" id="" required>
                                <option class="form-control" value="" selected disabled>Plese Select</option>
                                @foreach($user_roles as $user_role)
                                    <option {{$user ? ($user->role_id == $user_role->role_id ? 'selected' : '' ): ''}}
                                            value="{{$user_role->role_id}}">{{$user_role->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label  for="agent_id">Reports To</label>
                            <select class="form-control" name="manager_id">
                                <option class="form-control" value="0" selected disabled>Plese Select</option>
                                @foreach($managers as $manager)
                                    <option {{$user ? ($user->manager_id == $manager->user_id ? 'selected' : '' ): ''}}
                                            value="{{$manager->user_id}}">{{$manager->full_name}}</option>
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
