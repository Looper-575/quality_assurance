<form id="vendor_form" action="javascript:save_vendor();" method="POST">
@csrf <!-- {{ csrf_field() }} -->
    <div class="row">
        @if(isset($user))
            <input name="user_id" type="hidden" value="{{$user->user_id}}" >
        @endif
        <div class="col-6">
            <div class="form-group">
                <label class="form-check-label"> Full Name</label>
                <input name="full_name" value="{{isset($user) ? $user->full_name : ''}}" required type="text" class="form-control">
            </div>
        </div>
        @if(isset($user))
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
    </div>
    @if(!isset($user))
        <div class="row">
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
        </div>
    @endif
    <div class="row">
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
                    <option {{isset($user) ? ($user->role_id == 'Male' ? 'selected' : '' ): ''}} value="Male">Male </option>
                    <option {{isset($user) ? ($user->role_id == 'Female' ? 'selected' : '' ): ''}} value="Female">Female </option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="form-check-label" for="">Contact Number</label>
                <input  class="form-control"  name="contact_number" value="{{isset($user) ? $user->contact_number : ''}}" type="number">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-check-label" for="">Postal Address</label>
                <input  class="form-control" name="postal_address" value="{{isset($user) ? $user->postal_address : ''}}" type="text">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary mr-1" type="submit">Submit</button>
            <button class="btn btn-danger" type="reset">Reset</button>
        </div>
    </div>
</form>