
@extends('layout.template')
@section('header_scripts')
    <style>
        .note-editor.note-frame .note-editing-area .note-editable{
            height: 200px;
            padding: 30px !important;
        }
        .select2-container{
            width: 100% !important;
        }

        .select2-selection{
            height: 40px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__arrow:before, .select2-container--default .select2-selection--single .select2-selection__arrow:before {
            content: unset;
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

    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="{{asset('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />





@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Task Detail</h3>
                </div>
            </div>

        </div>
        <div class="m-portlet__body">

            <div class="p-2">
                <h2 class="mt-3">Project</h2>
                <p> {{$task->project->title}}</p>
                <h4 class="mt-3">Title </h4>
                <p>{{$task->title}}</p>
                <h4 class="mt-3">Department</h4>
                <p>{{$task->department->title}}</p>
                <h4 class="mt-3">Assigned To</h4>
                <p> {{$task->users->full_name ?? 'Not Assigned Yet'}}</p>
            </div>
            <div class="p-2">
                <h4 class="">Description</h4>
                <p class="" style="font-size: 16px;">{!! $task->description !!}</p>
            </div>

            @if($task->attachments)
                <div class="">
                    <h4 class="mt-3">Attachments</h4>
                    @foreach(explode(',',$task->attachments) as $file)
                        <iframe class="ml-3 w-100" style="height: 400px;" class='preview_files' src='{{asset('task_attachments/'.$file)}}'></iframe>
                    @endforeach
                </div>
            @endif
           <div class="p-2">
               <h4 class="mt-3">Start Date</h4>
               <p>{{ parse_datetime_get($task->start_date)}}</p>
               <h4 class="mt-3" >End Date</h4>
               <p> {{ parse_datetime_get($task->end_date)}}</p>
           </div>
            @if(isset($task->comments))
                <?php
                $average = 0;
                $i = 0;

                ?>
                <hr class="my-5">
                <div class="mb-5">
                    <h3 class="h3_txt mb-3">Logs:</h3>
                    @forelse($task->comments as $comment)
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



        @if(isset($manager) && $manager)

            @if($task->status !=1 && $task->department_id != 1)
                <div class="col-12  mt-4 mb-5 pl-0">
                    <h3 class="h3_txt mb-3">Manager Appproval:</h3>

                    <form id="manager_approval_form">
                        @csrf
                        <label for="comments" class="form-check-label">Comments</label>
                        <div class="summernote" id="comments">

                        </div>
                        <div class="rating-css">
                            <div class="text-dark">Rating</div>
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
                            <input name="task_id" type="hidden" value="{{$task->task_id}}">
                        </div>
                        <div class="form-group mt-3">
                            <input  name="approve" type="submit" class="btn  btn-success float-right" value="Approve">
                            <input  name="reopen" type="submit" class="btn mr-2 btn-danger float-right" value="Reopen">
                        </div>
                    </form>
                </div>
            @endif
        @endif
            <div class="p-2" style="clear: both">
                @if($task->status == 1)
                    <h5>Status : <span class="text-success">Completed</span> </h5>
                @else
                    <h5>Status : <span class="text-warning">{{$task->status == 0 ?'Pending':'Document Submitted'}}</span> </h5>
                @endif

            </div>
            <hr>


            @if($task->assigned_to == Auth::user()->user_id && $task->status !=1 && $task->department_id == 1)
                <a class="btn btn-info" href="{{route('module_form')}}">Submit Document</a>
            @endif
            @if((Auth::user()->role_id == 1 || $task->assigned_to == Auth::user()->user_id || (isset($manager) && $manager)) && ($task->status == 1 || $task->status == 2) && $task->department_id == 1)
            <a href="{{route('view_document',$task->task_id)}}" class="btn btn-primary">View Document</a>
            @endif

        </div>
    </div>
@endsection
@section('footer_scripts')

    <script>

        let form = $('#manager_approval_form')[0];
        form.addEventListener("submit", ev => {
            ev.preventDefault()
            let data = new FormData($('#manager_approval_form')[0]);
            data.append('comments', $('#comments').siblings('.note-editor').find('.note-editable').html());
            data.append('task_id', {{$task->task_id}});




            console.log([...data]);

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
                        window.location.href = '{{route('tasks_list')}}';
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('approve_module')}}', data, arr);
                }
            });
        })

    </script>

@endsection
