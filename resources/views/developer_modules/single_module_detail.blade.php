@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, 'modules_list');
    ?>
    <style>
        .h3_txt{
            color: #941616;
            text-decoration: underline;
            font-weight: 600;
            width: fit-content;
        }
        .p_color{
            color: #33302f;
            font-size: 18px;
        }
        .rating-css {
            height: 250px;
            width: 100%;
            padding: 30px;
        }
        .rating-css div {
            color: #ffe400;
            font-size: 30px;
            font-family: sans-serif;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            padding: 20px 0px;
        }
        .rating-css input {
            display: none;
        }
        .rating-css input + label {
            font-size: 60px;
            text-shadow: 1px 1px 0 #ffe400;
            cursor: pointer;
        }
        .rating-css input:checked + label ~ label {
            color: #838383;
        }
        .rating-css label:active {
            transform: scale(0.8);
            transition: 0.3s ease;
        }

    </style>
    <div class="row my-5 px-5">
        <div class="col-12 d-flex justify-content-end">
            <button onclick="print_div('module_detail')" class="btn btn-success px-5">Print</button>
        </div>
        <div class="col-12">
            <div id="module_detail">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Project Name:</h3>
                        <p class="p_color">{{$module->projects->title}}</p>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Module Name:</h3>
                        <p class="p_color">{{$module->task->title}}</p>
                    </div>
                <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Added By:</h3>
                        <p class="p_color">{{$module->users->full_name}}</p>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Added On:</h3>
                        <p class="p_color">{{parse_datetime_get($module->added_on)}}</p>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Description:</h3>
                        <p class="p_color">
                            {!!  $module->description!!}

                        </p>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Models:</h3>

                            @if($module->models != NULL && $module->models != '' )
                                {!!$module->models!!}

                            @endif
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Views:</h3>

                            @if($module->views != NULL && $module->views != '' )
                            {!!$module->views!!}
                            @endif
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Controllers:</h3>
                        <ul style="list-style-type:disc" class="p_color">
                            @if($module->controllers != NULL && $module->controllers != '' )
                                {!!$module->controllers!!}
                            @endif
                        </ul>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Dependencies:</h3>
                        <ul style="list-style-type:disc" class="p_color">
                            @if($module->dependencies != NULL && $module->dependencies != '' )
                                {!!$module->dependencies!!}
                            @endif
                        </ul>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Usage:</h3>
                        {!! $module->module_usage !!}
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Test Cases:</h3>
                        <ul style="list-style-type:disc" class="p_color">
                            @if($module->test_cases != NULL && $module->controllers != '' )
                                {!!$module->test_cases!!}
                            @endif
                        </ul>
                    </div>

                @if(isset($module->comments))
                    <?php
                    $average = 0;
                    $i = 0;

                    ?>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Logs:</h3>
                        @forelse($module->comments as $comment)
                            <?php
                            $average = $average + $comment->rating;
                            $i++;
                            ?>
                            <h3>Comments ({{parse_datetime_get($comment->added_on)}})</h3>
                            <p>{!! $comment->comments !!}</p>
                            <h3>Rating</h3>
                            <p>{{ $comment->rating }} / 5</p>
                            <h3>Status</h3>
                            <p class="{{$comment->status == 1?'text-success':'text-warning'}}">{{$comment->status == 1?'Approved':'Re-Opened'}}</p>
                            <hr class="mt-2" style="width: 80%;">
                        @empty
                            <p>No Comments </p>
                        @endforelse
                    </div>
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Average Rating:</h3>
                        @if($average != 0 && $i != 0 )
                            <?php $average = round($average) ?>
                            <p id="average_rating">{{round($average / $i,2)}}</p>
                         @else
                            <p id="average_rating">0</p>
                        @endif
                    </div>
                @endif
            </div>
            @if(((isset($manager) && $manager) || Auth::user()->role_id == 1) && $module->approved != 1)
                <hr>
                <div class="col-12  mt-4 mb-5 pl-0">
                    <h3 class="h3_txt mb-3">Manager Appproval:</h3>

                    <form id="manager_approval_form">
                        @csrf
                        <label for="comments" class="form-check-label">Comments</label>
                        <div class="summernote" id="comments">

                        </div>
                        <div class="rating-css">
                            <div class="text-dark">Developer Rating</div>
                            <div class="star-icon">
                                <input type="radio" name="rating" id="rating1" value="1">
                                <label for="rating1" class="fa fa-star"></label>
                                <input type="radio" name="rating" id="rating2" value="2">
                                <label for="rating2" class="fa fa-star"></label>
                                <input type="radio" name="rating" id="rating3" value="3">
                                <label for="rating3" class="fa fa-star"></label>
                                <input type="radio" name="rating" id="rating4" value="4">
                                <label for="rating4" class="fa fa-star"></label>
                                <input type="radio" name="rating" id="rating5" value="5">
                                <label for="rating5" class="fa fa-star"></label>
                            </div>
                            <input name="module_id" type="hidden" value="{{$module->id}}">
                            <input name="task_id" type="hidden" value="{{$module->task_id}}">
                        </div>
                        <div class="form-group mt-3">
                            <input  name="approve" type="submit" class="btn  btn-success float-right" value="Approve">
                            <input  name="reopen" type="submit" class="btn mr-2 btn-danger float-right" value="Reopen">
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer_scripts')
    <link href="summernote-bs5.css" rel="stylesheet">
    <script src="summernote-bs5.js"></script>
    <!--end::Base Scripts -->
    <!--begin::Page Resources -->
    <script>
        let form = $('#manager_approval_form')[0];
        $(document).ready(function() {
            $('.summernote').summernote();
        });
        form.addEventListener("submit", ev => {
            ev.preventDefault()
            let data = new FormData($('#manager_approval_form')[0]);
            data.append('comments', $('#comments').siblings('.note-editor').find('.note-editable').html());
            data.append('task_id', {{$module->task_id}});

            let average_rating = {{$average}} + parseInt(data.get('rating'));

            if(average_rating == 0){
                data.append('average_rating',0);
            }
            else{
                average_rating = average_rating / {{$i+1}};
                average_rating = average_rating.toFixed(2);
                data.append('average_rating',average_rating);
            }

            let msg = "";
            if(ev.submitter.name == 'approve'){
                msg = 'Do you really want to approve this Module?';
            }else{
                msg = 'Do you really want to Re-Open this Module?';
            }

            swal({
                title: "Are you sure?",
                text: msg,
                buttons: [
                    'No',
                    'Yes'
                ],
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    data.append('action',ev.submitter.name);
                      let a = function () {
                         window.location.href = '{{route('modules_list')}}';
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('approve_module')}}', data, arr);
                }
            });
        })


    </script>
@endsection