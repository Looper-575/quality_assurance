
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
                    <h3 class="m-portlet__head-text">Task Form</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form action="javascript:save_task();" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data" method="post" id="task_form" >
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-check-label" for="project">Project</label>
                            <select class="form-control select2" name="project" id="project" required>
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option {{isset($task) ? ($task->project->id == $project->id ? 'selected' : '' ): ''}}
                                            value="{{$project->id}}">{{$project->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-check-label" for="project">Title</label>
                            <input required  type="text"  class="form-control" name="title" id="title" value="{{isset($task)?$task->title:''}}">

                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-check-label" for="department">Department</label>
                            <select class="form-control select2" name="department" id="department" required>
                                    <option value="">Select Department</option>
                                @foreach($departments as $department)
                                        <option {{isset($task) ?($task->department_id  == $department->department_id  ? 'selected' : '' ): ''}}
                                                value="{{$department->department_id}}">{{$department->title}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-check-label" for="assigned_to">Assign To</label>
                            <select class="form-control select2" name="assigned_to" id="user">
                                <option value="">Select User</option>
                                @if(isset($users))
                                    @foreach($users as $user)
                                        <option  {{isset($task) && isset($task->users)?($task->users->user_id  == $user->user_id  ? 'selected' : '' ): ''}}
                                                 value="{{$user->user_id}}">{{$user->full_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-4">
                        <label for="description" class="form-check-label">Task Description  </label>
                        <div class="summernote" id="description">
                            {!!isset($task)?$task->description:''!!}
                        </div>
                    </div>
                    <div class="col-6 col-md-4 mt-4">
                        <label for="attachments" class="form-check-label">Attachements</label>
                        <input   type="file" class="form-control" name="attachments[]" multiple id="attachments">
                    </div>
                    <div class="col-6 col-md-4 mt-4">
                        <label for="controller" class="form-check-label">Start Date</label>
                        <input required  type="datetime-local" class="form-control" name="start_date" id="start_date" value="{{isset($task)?date("Y-m-d\TH:i:s", strtotime($task->start_date)):''}}">
                    </div>
                    <div class="col-6 col-md-4 mt-4">
                        <label for="controller" class="form-check-label">End Date</label>
                        <input required  type="datetime-local" class="form-control" name="end_date" id="end_date" value="{{isset($task)?date("Y-m-d\TH:i:s", strtotime($task->end_date)):''}}" >
                    </div>
                    @if(isset($task))
                        <input name="task_id" type="hidden" value="{{$task->task_id}}">
                    @endif
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary float-right"> Submit </button>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('footer_scripts')

    <script>

        $(document).ready(function(){
            $(".select2").select2();
        })


       async function save_task(){
            let data =  new FormData($('#task_form')[0]);
            data.append('description', $('#description').siblings('.note-editor').find('.note-editable').html());

            if(!data.has('assigned_to') || data.get('assigned_to') == ''){
                await  swal("No User Assigned for Task", {
                    buttons: {
                        cancel: "Cancel",
                        Assign: {
                            text: "Auto Assign",
                            value: "auto_assign",
                        },
                        proceed: {
                            text: "Proceed",
                            value: "do_nothing",
                        },
                    },
                }).then((value) => {
                    switch (value) {
                        case "do_nothing":
                            data.append('action', 'nothing');
                            break;
                        case "auto_assign":
                            data.append('action', 'auto_assign');
                            break;
                        default:
                           return;
                    }
                });
            }



            let a  = function(){
               window.location.href = '{{route('tasks_list')}}';
            }
            let arr = [a];
            call_ajax_with_functions('','{{route('save_task')}}',data,arr);

        }

        $('#department').change(function(){

            let data = new FormData();
            data.append('department_id',$(this).val());
            data.append('_token', "{{csrf_token()}}");
            $('#user').html('');
            call_ajax('user',"{{route('get_users')}}",data);

        });

    </script>

@endsection
