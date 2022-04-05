<!-- begin::Quick Sidebar -->
<div id="m_quick_sidebar" class="of-hide m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
    <div class="m-quick-sidebar__content m--hide">
        <span id="m_quick_sidebar_close" class="m-quick-sidebar__close">
            <i class="la la-close"></i>
        </span>
        <ul id="m_quick_sidebar_tabs" class="nav mb-1 nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_settings" role="tab">
                    To Do List
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_logs" role="tab">
                    My Notes
                </a>
            </li>
        </ul>
        <div class="tab-content todo-content">
            <div class="tab-pane active remove-scroll" id="m_quick_sidebar_tabs_settings" role="tabpanel">
                <div id="add_todo_id">
                    <form method="post" id="todo_form" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="title" id="todo_title_id" placeholder="Title" class="form-control" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" title="Add more" type="submit">
                                    <i class="la la-plus font-19"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="note_id" id="note_edit_id">
                    </form>
                </div>
                <div class="pt-4">
                    <div class="m-list-settings__heading pb-2">
                        PENDING
                    </div>
                    <div id="todo_list_id">
                    </div>
                </div>
                <hr>
                <div class="m-list-settings__heading">
                    DONE
                </div>
                <div class="tab-pane active" id="done_todo_list_id">
                </div>
            </div>
            <div class="tab-pane" id="m_quick_sidebar_tabs_logs" role="tabpanel">
                <form method="post" id="note_form" enctype="multipart/form-data">
                    @csrf
                    <button type="button" id="btn_minus" title="Hide Note Form" onclick="hide_note_form()" class="ml-2 d-none btn btn-brand btn-social mb-2 m-btn m-btn--icon m-btn--icon-only float-right">
                        <i class="la la-minus"></i>
                    </button>
                    <button type="button" onclick="show_note_form()" title="Show Note Form" id="btn_plus" class="d-none btn btn-brand btn-social mb-2 m-btn m-btn--icon m-btn--icon-only float-right">
                        <i class="la la-plus"></i>
                    </button>
                    <div id="note_div_id">
                        <input type="hidden" name="note_id" id="note_list_edit_id">
                        <input type="text" name="title" placeholder="Title" class="form-control my-2" id="note_title_id" required>
                        <textarea name="description" id="discription_id" placeholder="Description" class="form-control" rows="10" required></textarea>
                        <button type="submit" id="btn_check" title="Save Note" class="btn btn-success btn-social mb-2 m-btn m-btn--icon m-btn--icon-only float-right">
                            <i class="la la-check"></i>
                        </button>
                    </div>
                </form>
                <div id="note_list_id">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end::Quick Sidebar -->
<script type="text/javascript">
    function hide_note_form() {
        var form = document.getElementById("note_div_id");
        form.classList.add("d-none");
        form.classList.remove("d-block");
        var btn_minus = document.getElementById("btn_minus");
        btn_minus.classList.add("d-none");
        btn_minus.classList.remove("d-block");
        var btn_check = document.getElementById("btn_check");
        btn_check.classList.add("d-none");
        btn_check.classList.remove("d-block");
        var btn_plus = document.getElementById("btn_plus");
        btn_plus.classList.add("d-block");
        btn_plus.classList.remove("d-none");
    }
    function show_note_form() {
        var form = document.getElementById("note_div_id");
        form.classList.add("d-block");
        form.classList.remove("d-none");
        var btn_minus = document.getElementById("btn_minus");
        btn_minus.classList.add("d-block");
        btn_minus.classList.remove("d-none");
        var btn_check = document.getElementById("btn_check");
        btn_check.classList.add("d-block");
        btn_check.classList.remove("d-none");
        var btn_plus = document.getElementById("btn_plus");
        btn_plus.classList.add("d-none");
        btn_plus.classList.remove("d-block");
    }
    function make_done_todo(e){
        let id = e;
        $.ajax({
            type:'post',
            url:"{{ route('make_done_todo') }}",
            data:{
                _token: "{{ csrf_token()}}",
                note_id: id,
            },
            success: function( msg ) {
                get_done_todos();
                document.getElementById('todo_list_id').innerHTML = msg;
            }
        });
    }
    function edit_todo(id, title) {
        let note_id = id;
        let note_title = title;
        document.getElementById('todo_title_id').value = note_title;
        document.getElementById('note_edit_id').value = note_id;
        document.getElementById('m_quick_sidebar_tabs').scrollIntoView();
    }
    function delete_todo(e){
        let id = e;
        swal({
            title: "Are you sure?",
            text: "Do you really want to delete this record? You will not be able to recover this.",
            icon: "warning",
            buttons: [
                'No, cancel it!',
                'Yes, I am sure!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type:'post',
                    url:"{{ route('delete_todo_form') }}",
                    data:{
                        _token: "{{ csrf_token()}}",
                        note_id: id,
                    },
                    success: function( msg ) {
                        get_pendiing_todos();
                        document.getElementById('done_todo_list_id').innerHTML = msg;
                    }
                });
            }
        })
    }
    function get_done_todos() {
        $.ajax({
            type:'get',
            url:"{{ route('get_done_todos') }}",
            success: function( msg ) {
                document.getElementById('done_todo_list_id').innerHTML = msg;
            }
        });
    }
    function get_pendiing_todos() {
        $.ajax({
            type:'get',
            url:"{{ route('get_pending_todos') }}",
            success: function( msg ) {
                document.getElementById('todo_list_id').innerHTML = msg;
            }
        });
    }
    function remove_scroller() {
        $('.mCSB_container').removeAttr('id');
    }
    function get_note_data() {
        $.ajax({
            type:'get',
            url:"{{ route('get_note_data') }}",
            success: function( msg ) {
                document.getElementById('note_list_id').innerHTML = msg;
            }
        });
    }
    function get_draft_note_data() {
        $.ajax({
            type:'get',
            url:"{{ route('get_draft_note_data') }}",
            success: function( resp ) {
                if(resp.draft_notes){
                    // console.log(resp);
                    // console.log(resp.draft_notes.note_id);
                    // console.log(resp.draft_notes.title);
                    // console.log(resp.draft_notes.description);
                    $('#note_list_edit_id').val(resp.draft_notes.note_id);
                    $('#note_title_id').val(resp.draft_notes.title);
                    $('#discription_id').val(resp.draft_notes.description);
                }
            }
        });
    }
    function delete_note(e){
        let id = e;
        swal({
            title: "Are you sure?",
            text: "Do you really want to delete this record? You will not be able to recover this.",
            icon: "warning",
            buttons: [
                'No, cancel it!',
                'Yes, I am sure!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type:'post',
                    url:"{{ route('delete_note_form') }}",
                    data:{
                        _token: "{{ csrf_token()}}",
                        note_id: id,
                    },
                    success: function( msg ) {
                        document.getElementById('note_list_id').innerHTML = msg;
                    }
                });
            }
        })
    }
    function edit_note(note_id){
        var url = '{{ route("single_note_data",":id") }}';
        url = url.replace(':id',note_id);
        $.ajax({
            type:'get',
            url:url,
            success: function( resp ) {
                document.getElementById('note_list_edit_id').value = resp.data.note_id;
                document.getElementById('note_title_id').value = resp.data.title;
                document.getElementById('discription_id').value = resp.data.description;
                document.getElementById('note_form').scrollIntoView();
                show_note_form();
            }
        });
    }
    document.addEventListener("DOMContentLoaded", function(event) {
        get_pendiing_todos();
        get_done_todos();
        remove_scroller();
        get_note_data();
        get_draft_note_data();
        $('#todo_form').submit(function (e) {
            e.preventDefault();
            let type = 'todo';
            let data = new FormData(this);
            data.append('type', type);
            data.append('status', '2');
            let a = function(){
                document.getElementById('todo_title_id').value = '';
                document.getElementById('note_edit_id').value = '';
            };
            let arr = [a];
            call_ajax_with_functions('todo_list_id','{{route('save_todo_form')}}',data,arr);
        });
        $('#note_form').submit(function (e) {
            e.preventDefault();
            let type = 'note';
            let data = new FormData(this);
            data.append('type', type);
            data.append('status', '1');
            let a = function(){
                document.getElementById('note_list_edit_id').value = '';
                document.getElementById('note_title_id').value = '';
                document.getElementById('discription_id').value = '';
            };
            let arr = [a];
            call_ajax_with_functions('note_list_id','{{route('save_note_form')}}',data,arr);
        });
        $('#discription_id').keyup(function (e) {
            if($('#note_title_id').val() == ''){
                alert("Note title is required");
                return;
            }
            let data = { _token: "{{ csrf_token()}}",
                        note_id: $('#note_list_edit_id').val(),
                        type: 'note',
                        title: $('#note_title_id').val(),
                        discription: $('#discription_id').val(),
                        status: 3
                    };
            $.ajax({
                type:'post',
                url:'{{route('save_note_draft')}}',
                data : data,
                success: function( resp ) {
                    // if(resp.draft_notes){
                    //     // console.log(resp);
                    //     // console.log(resp.draft_notes.note_id);
                    //     // console.log(resp.draft_notes.title);
                    //     // console.log(resp.draft_notes.description);
                    // }
                }
            });
        });
        $('#change_pass').submit(function (e) {
            e.preventDefault();
        let data = { _token: "{{ csrf_token()}}",
                     user_id:{{Auth::user()->user_id}},
                     password:$('#password').val(),
                     password_confirmation:$('#password_confirmation').val(),
                     curr_password:$('#curr_password').val()
                   };
            $.ajax({
                type:'POST',
                url:'{{route('change_pass')}}',
                data : data,
                success: function( resp ) {
                    console.log(resp.status);
                    if(resp.status.toLowerCase()=="success") {
                        console.log(resp.result);
                        $('#change_pass_form_modal').fadeOut();
                        toastr.success(resp.result);
                        //swal("Success", resp.result, "success");
                    } else if(resp.status.toLowerCase()=="failure"){
                        console.log(resp.result);
                        $('#error').removeClass('d-none');
                        $('#error').html(resp.result);
                        toastr.error(resp.result);
                       //swal("Failure", resp.result, "error");
                    }
                }
            });
        });
    });
</script>
