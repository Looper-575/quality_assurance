<?php
$user_sel = explode(',',$group->group_members);
?>
@if(Auth::user()->user_id == $group->added_by)
<form method="post" action="javascript:updateGroup();" id="chat_group_edit_form" enctype="multipart/form-data">
        @csrf
        <div class="card1">
            <div class="card-body1">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="">Title</label>
                            <input  class="form-control" type="text" name="group_title" id="group_title" required value="{{$group->title}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="">Admin</label>
                            <select class="form-control select2" name="group_owner" id="group_owner" required value="{{$group->added_by}}">
                                <option value=""> Select Users </option>
                                @foreach($users as $user)
                                    <option value="{{$user->user_id}}" {{ $user->user_id == $group->added_by? 'selected' : ''}}> {{$user->full_name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        <input  class="form-control" type="hidden" name="group_id" id="group_id" required value="{{$group->group_id}}">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="group_image">Select an Image</label>
                            <input  class="form-control" type="file" name="group_image" id="group_image" value="{{$group->group_image}}">
                            <input  class="form-control" type="hidden" name="hidden_image" id="" value="{{$group->group_image}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <img src="{{asset('chat_files')}}/{{$group->group_image}}" alt="" style="height:200px;max-width:100%;">
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-check-label" for="users_select">Users</label><br>
                            <select class="form-control select2" name="users[]" id="users_select" multiple="multiple" required value="{{$group->group_members}}">
                                <option value=""> Select Users </option>
                                @foreach($users as $user)
                                    <option value="{{$user->user_id}}" {{in_array($user->user_id,$user_sel) ? 'selected' : ''}}> {{$user->full_name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer1 text-right">
                <button class="btn btn-primary mr-1" type="submit">Submit</button>
            </div>
        </div>
    </form>
@else
    <div class="card1">
        <div class="card-body1">
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    <img src="{{asset('chat_files')}}/{{$group->group_image}}" alt="" style="height:200px;max-width:100%;">
                </div>
                <div class="col-5">
                    Title: <strong>{{$group->title}}</strong>
                </div>
                <div class="col-5">
                    Admin: <strong>
                                @foreach($users as $user)
                                    @if($user->user_id == $group->added_by)
                                        {{$user->full_name}}
                                    @endif
                                @endforeach
                        </strong>
                </div>
                <div class="col-12">
                    @foreach($users as $user)
                            @if(in_array($user->user_id,$user_sel))
                                <div class="col-10 mb-1 pt-2 pb-2 border-bottom">
                                    <div class="form-check">
                                        <img src="{{asset('user_images').'/'.($user->image ? $user->image : 'user.png')}}" alt="" width="40">
                                        <label class="form-check-label" for="flexCheck_{{$user->user_id}}">
                                            {{$user->full_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
