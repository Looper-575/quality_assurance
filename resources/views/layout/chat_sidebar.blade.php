<!-- begin::Quick Sidebar -->
<div id="chat_sidebar" class="of-hide m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
    <div class="m-quick-sidebar__content m--hide">
        <span onclick="toggle_chat();" id="m_quick_sidebar_close" class="m-quick-sidebar__close">
            <i class="la la-close"></i>
        </span>
        <ul id="m_quick_sidebar_tabs" class="nav mb-1 nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
            <li class="nav-item m-tabs__item chat_single_tab_nav position-relative">
                <span class="chat_single_unread d-flex justify-content-center align-items-center"></span>
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#one_two_one_chat_tab" role="tab">
                    One To One Chats
                </a>
            </li>
            <li class="nav-item m-tabs__item chat_group_tab_nav position-relative">
                <span class="chat_group_unread d-flex justify-content-center align-items-center"></span>
                <a class="nav-link m-tabs__link get_groups_nav" data-toggle="tab" href="#group_chat_tab" role="tab">
                    Groups
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link position-relative">
                    <i class="fa fa-search" id="search_bar"></i>
                    <div class="togglesearch">
                        <input type="text" placeholder="Type to search" id="user_search" class="form-control"/>
                    </div>
                </a>
            </li>
        </ul>
        <div class="tab-content todo-content">
            <div class="tab-pane active remove-scroll" id="one_two_one_chat_tab" role="tabpanel">
                <div id="users_list_container" class="chat_half_box1">
                    <div class="m-widget4" style="width: 95%;" id="chat_user_list_container">
                        <?php
                        $user_id = Auth::user()->user_id;
                        $users =
                            DB::select("SELECT *,
                            (SELECT chats.msg FROM chats WHERE (chats.to_user = $user_id AND chats.from_user = users.user_id)
                            OR (chats.to_user = users.user_id AND chats.from_user =$user_id )
                            ORDER by chat_id DESC LIMIT 1) as last_msg ,
                            (SELECT chats.added_on FROM chats WHERE (chats.to_user = $user_id AND chats.from_user = users.user_id)
                            OR (chats.to_user = users.user_id AND chats.from_user =$user_id ) ORDER by chat_id DESC LIMIT 1) as last_msg_time,
                            (SELECT count(chats.msg) FROM chats WHERE (chats.to_user = $user_id AND chats.from_user = users.user_id) AND msg_read=0
                            ORDER by chat_id DESC LIMIT 1) as unread_count FROM `users`
                            WHERE status=1 AND user_id !=$user_id ORDER BY last_msg_time DESC");
                        ?>
                        @foreach($users as $user)
                            <div class="m-widget4__item chat_offline d-flex position-relative" id="user_id_{{$user->user_id}}">
                                <button class="w-100 text-left one_to_one_user" onclick="get_one_to_one_chats({{$user->user_id}},this)" data-name="{{$user->full_name}}">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{asset('user_images').'/'.($user->image ? $user->image : 'user.png')}}" alt="" class="user_img">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__title">{{$user->full_name}}</span>
                                        <br>
                                        <span class="m-widget4__sub" id="chat_user_last_msg">{{$user->last_msg}}</span>
                                        <div class="align-items-center badge-secondary d-flex justify-content-center position-absolute user_unread_count" id="unread_counter" style="width: 30px;height: 30px;right: 0px;top: 30%;border-radius: 50%;">
                                            {{$user->unread_count}}
                                        </div>
                                    </div>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="chat_container" class="chat_half_box2">
                    <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light position-relative"  style="width: 95%;">
                        <div class="active_chat_info">
                            <img src="{{asset('/user_images/user.png')}}" id="active_chat_user_img" alt="" width="50">
                            <h3 id="chat_with_name" class="d-inline-block">None</h3>
                            <button class="btn float-right minimize_btn" onclick="minimize_chat('one_two_one_chat_tab')"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                        </div>
                        <div class="m-messenger__messages" id="chat_window" style="height: 80%; overflow-y: scroll">
                        </div>
                        <div class="m-messenger__seperator" style="margin: 5px 0;"></div>
                        <div class="m-messenger__form position-relative">
                            <div id="emoji_board" style="position: absolute;top:-100px;">
                            </div>
                            <form action="javascript:(0);" id="chat_form" method="post" enctype="multipart/form-data">
                                <div class="m-messenger__form-controls position-relative">
                                    <input type="text" name="msg" id="msg" placeholder="Type here..." class="m-messenger__form-input">
                                    <a id="emojies"><i class="fa fa-chevron-up"></i></a>
                                </div>
                                <div class="m-messenger__form-tools">
                                    <input type="file" id="chat_file" name="chat_file[]" multiple class="sr-only">
                                    <label class="m-messenger__form-attachment" id="send_msg" for="chat_file">
                                        <i class="la la-paperclip"></i>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <button class="maximize_btn btn position-fixed" onclick="maximize_chat('one_two_one_chat_tab')"><i class="fa fa-comment-o" aria-hidden="true"></i></button>
            </div>
            <div class="tab-pane" id="group_chat_tab" role="tabpanel">
                <div id="users_list_container" class="chat_half_box1">
                    <div class="m-widget4" id="group_list_div" style="width: 94%;">
                        <?php
                        if(Auth::user()->department_id){
                            $myGroups = DB::select("SELECT * FROM `chat_group` where LOCATE(CONCAT(',', ".$user_id." ,','),CONCAT(',',group_members,',')) > 0 OR department_id =".Auth::user()->department_id);
                        }
                        else{
                            $myGroups = DB::select("SELECT * FROM `chat_group` where LOCATE(CONCAT(',', ".$user_id." ,','),CONCAT(',',group_members,',')) > 0");
                        }
                        ?>
                        @foreach ($myGroups as $group)
                            @if($group->added_by == $user_id || ($group->added_by != $user_id  && $group->type == 1))
                                <div class="m-widget4__item item_group" onclick="get_group_chats({{$group->group_id}},this)" id="group_id_{{$group->group_id}}" data-owner="{{$group->added_by == $user_id ? 'true' : 'false'}}" data-type="{{$group->type == 2 ? 'broadcast' : 'group'}}">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{asset('chat_files')}}/{{$group->group_image ? $group->group_image : 'group.png'}}" alt="group image">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__title">{{$group->title}}</span>
                                        <br><span class="m-widget4__sub" id="last_msg"></span>
                                    </div>
                                    <span class="m-widget4__ext position-relative">
                                        @if( $group->type == 2 )
                                            <div class="align-items-center badge-secondary d-flex justify-content-center position-absolute" style="width: 30px;height: 30px;right: 0px;top: 30%;border-radius: 50%;">
                                                <i class="fa fa-bullhorn"></i>
                                            </div>
                                        @else
                                            <div class="align-items-center badge-secondary d-flex justify-content-center position-absolute group_unread_count" id="unread_counter" style="width: 30px;height: 30px;right: 0px;top: 30%;border-radius: 50%;">0</div>
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button class="btn position-fixed btn-brand" id="btn_create_group" data-toggle="modal" data-target="#createGroupModal">
                        <i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Create New Group Chat"></i>
                    </button>
                </div>
                <div id="chat_container border-top" class="chat_half_box2">
                    <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light"  style="width: 95%;">
                        <div class="active_chat_info">
                            <h3 id="active_group_name" class="d-inline-block">None</h3>
                            <button class="btn float-right minimize_btn" onclick="minimize_chat('group_chat_tab')"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                            <div class="dropdown show float-right d-none" id="group_options">
                                <button class="btn group_edit_btn"  type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(170px, 27px, 0px);">
                                    <a class="dropdown-item edit_group_option" onclick="editGroup()" href="javascript:;">
                                        Edit Group
                                    </a>
                                    <a class="dropdown-item group_info_option" onclick="groupInfo()" href="javascript:;">
                                        Group Info
                                    </a>
                                    <a class="dropdown-item leave_group_option" onclick="leaveGroup()" href="javascript:;">
                                        Leave Group
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="m-messenger__messages" id="group_chat_window" style="height: 80%; overflow-y: scroll"></div>
                        <div class="m-messenger__seperator" style="margin: 5px 0;"></div>
                        <div class="m-messenger__form position-relative">
                            <form action="javascript:(0);" id="group_chat_form" method="post" enctype="multipart/form-data">
                                <div class="m-messenger__form-controls position-relative">
                                    <input type="text" name="group_msg" id="group_msg" placeholder="Type here..." class="m-messenger__form-input">
                                    <a id="emojies_group"><i class="fa fa-chevron-up"></i></a>
                                </div>
                                <div class="m-messenger__form-tools">
                                    <input type="file" id="group_chat_file" name="group_chat_file[]" multiple class="sr-only">
                                    <label class="m-messenger__form-attachment" for="group_chat_file">
                                        <i class="la la-paperclip"></i>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <button class="maximize_btn btn position-fixed" onclick="maximize_chat('group_chat_tab')"><i class="fa fa-comment-o" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="resp_div_img" class="d-none"></div>
<ul id="contextMenu" class="dropdown-menu" style="z-index: 9999;">
    <li><a onclick="forward_msg(this)">Forward</a></li>
    <li><a onclick="qoute_msg(this)">Reply</a></li>
</ul>
<!--begin::Modals-->
<div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGroupModalTitle">Create A New Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="chat_group_form" action="javascript:create_group();" enctype="multipart/form-data">
                    @csrf
                    <div class="card1">
                        <div class="card-body1">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-check-label" for="">Title</label>
                                        <input  class="form-control" type="text" name="group_title" id="group_title" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-check-label" for="group_image">Select an Image</label>
                                        <input  class="form-control" type="file" name="group_image" id="group_image">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-check-label" for="users_select">Users</label><br>
                                        <select class="form-control select2" name="users[]" id="users_select" multiple="multiple" required>
                                            <option value=""> Select Users </option>
                                            @foreach($users as $user)
                                                <option value="{{$user->user_id}}"> {{$user->full_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-check-label" for="type">Type</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="1" selected>Group</option>
                                            <option value="2">Broadcast</option>
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
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alert_detail_modal" tabindex="-1" role="dialog" aria-labelledby="alert_detail_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">
												&times;
											</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal_detail_msg" style="word-break: break-all;">

                </p>
                <p class="modal_detail_msg_time font-weight-bold text-right"></p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="chat_image_modal" tabindex="-1" role="dialog" aria-labelledby="chat_image_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="chat_image_modal" class="modal_img_view">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="forward_message_modal" tabindex="-1" role="dialog" aria-labelledby="forwardMessageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGroupModalTitle">Select Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="forward_message_form" action="javascript:message_forward();" enctype="multipart/form-data">
                    @csrf
                    <div class="card1">
                        <div class="card-body1">
                            <div class="row justify-content-center">
                                <input type="hidden" id="selected_msg_id">
                                @foreach($users as $user)
                                    <div class="col-10 mb-1 pt-2 pb-2 border-bottom">
                                        <div class="form-check">
                                            <img src="{{asset('user_images').'/'.($user->image ? $user->image : 'user.png')}}" alt="" width="40">
                                            <label class="form-check-label" for="flexCheck_{{$user->user_id}}">
                                                {{$user->full_name}}
                                            </label>
                                            <input class="form-check-input forward_to_users" type="checkbox" value="{{$user->user_id}}" id="flexCheck_{{$user->user_id}}" style="position: absolute;top:10px;right: 0px;transform: scale(2);">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer1 text-right">
                            <button class="btn btn-primary mr-1" type="submit">Forward</button>
                            <button class="btn btn-primary mr-1" type="submit" style="position: absolute;top: -65px;right: 50px;">Forward</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

@section('footer_srcipts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}" defer></script>
@endsection

<!-- end::Quick Sidebar -->
<script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}" defer></script>
{{--<script src="{{asset('assets/js/siofu_client.js')}}"></script>--}}
<script src="{{asset('assets/js/socket.io.min.js')}}"></script>
<script src="{{asset('assets/js/emoji_keyboard.js') }}"></script>

<script type="text/javascript">
    let msg_recieve = (function () {/*
    <div>
        <div class="m-messenger__wrapper m-messenger__wrapper_recieved">
          <div class="m-messenger__message m-messenger__message--in position-relative">
                <div class="m-messenger__message-pic">
                    <img src="user_images/user.png" alt=""/>
                </div>
                <div class="m-messenger__message-body">
                    <p class="recieve_reply_para"></p>
                    <p class="m-messenger__message-text message-text_recieved">

                    </p>
                    <p class="message_details"><span class="sender_name"></span> <span class="msg_time"></span></p>
                </div>
            </div>
        </div>
    </div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let msg_send = (function () {/*
    <div>
        <div class="m-messenger__wrapper">
            <div class="m-messenger__message m-messenger__message--out">
                <div class="m-messenger__message-body">
                    <p class="send_reply_para"></p>
                    <p class="m-messenger__message-text message-text_send">

                    </p>
                    <p class="message_details"><span class="msg_time"></span></p>
                </div>
            </div>
        </div>
    </div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let scroll_btn = (function () {/*
    <div>
    <button class="btn" id="chat_arrow_icon" onclick="scrollTOBottom()"><i class="fas fa-arrow-down"></i></button>
    </div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let img_div = (function () {/*
    <div>
    <img src="" class="chat_attachment">
    </div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let group_div = (function () {/*
    <div>
    <div class="m-widget4__item item_group">
    <div class="m-widget4__img m-widget4__img--logo">
        <img src="./chat_files/group.png" alt="" class="group_icon">
    </div>
    <div class="m-widget4__info">
    <span class="m-widget4__title">
        Group Title
    </span>
    <br>
    <span class="m-widget4__sub"></span>
    </div>
    <span class="m-widget4__ext position-relative">
    <div class="align-items-center badge-secondary d-flex justify-content-center position-absolute group_unread_count" id="unread_counter" style="width: 30px;height: 30px;right: 0px;top: 30%;border-radius: 50%;">
    0
    </div>
    </span>
    </div>
    </div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let broadcast_alert = (function () {/*
    <div>
    <div class="alert_div braodcast_alert w-100" onclick="get_detail_view(this)">
          <div class="w-100 position-relative">
          <img src="assets/img/icons/bullhorn.svg" width="30" alt="bullhorn"/>
            <div class="inner_div"><span class="broadcaster_name"></span> : <strong class="broadcast_msg"></strong></div>
          <p class="message_details"><span class="msg_time"></span></p>
          </div>
     </div>
    </div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let reply_msg_div = (function () {/*
    <div id="reply_msg_div">
         <button class="btn close_reply_msg_div float-right">X</button>
        <p>Reply to: <q class="reply_msg_text"></q></p>
    </div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let chat_sidebar_state = true;
    let socket;
    let chat_active_user_id;
    let active_group_id;
    let chat_active_user_image;
    let scrollToBottom = true;
    let group_owner;
    let interval;
    let audio = new Audio('{{asset('assets/tones/incoming.mp3')}}');
    async function play_sound(){
        await audio.play();
    }
    function toggle_chat(){
        chat_sidebar_state = !chat_sidebar_state;
        if(chat_sidebar_state){
            $('#chat_sidebar').removeClass('m-quick-sidebar--on');
            $('#chat_sidebar').find('.m-quick-sidebar__content').addClass('m--hide');
            $('.chat_half_box').height('50%')
        } else{
            $('#chat_sidebar').addClass('m-quick-sidebar--on');
            $('#chat_sidebar').find('.m-quick-sidebar__content').removeClass('m--hide');
        }
    }
    function minimize_chat(id){
        let parent = id;
        $('#'+parent+' .chat_half_box2').css('height','0px');
        $('#'+parent+' .chat_half_box2').css('bottom','-50px');
        $('#'+parent+' .chat_half_box2 .m-messenger').css('display','none');
        $('#'+parent+' .chat_half_box2 .minimize_btn').addClass('d-none');
        $('#'+parent+' .maximize_btn').fadeIn();
    }
    function maximize_chat(id){
        let parent = id;
        $('#'+parent+' .chat_half_box2').css('height','450px');
        $('#'+parent+' .chat_half_box2').css('bottom','0px');
        $('#'+parent+' .chat_half_box2 .m-messenger').css('display','block');
        $('#'+parent+' .maximize_btn').fadeOut();
        $('#'+parent+' .chat_half_box2 .minimize_btn').removeClass('d-none');
    }
    // Get One to One chat
    function get_one_to_one_chats(user_id,me){
        let data = { "from_user": {{$user_id}},"to_user": user_id};
        //get active user image
        chat_active_user_id = user_id;
        $('#chat_with_name').html($(me).data('name'));
        chat_active_user_image = $(me).find('.user_img').attr('src');
        $('#active_chat_user_img').attr('src',$(me).find('.user_img').attr('src'));
        //animate to top
        $('#user_id_'+chat_active_user_id).fadeOut().prependTo('#chat_user_list_container').fadeIn();
        // $("#chat_user_list_container").prepend($('#user_id_'+chat_active_user_id));
        socket.emit('get_one_to_one_chats', data);
        $("#chat_form input, #chat_form select").attr('disabled',false);
        maximize_chat('one_two_one_chat_tab');
    }
    // Get Group chat
    function get_group_chats(group_id,me){
        active_group_id = group_id;
        group_owner = $(me).data('owner');
        let group_type = $(me).data('type');
        if(group_type == 'broadcast' && !group_owner) {
            $('#group_chat_form').fadeOut();
        } else {
            $('#group_chat_form').fadeIn();
        }
        $('#active_group_name').html($(me).find('.m-widget4__title').html());
        if(group_owner) {
            $('.edit_group_option').removeClass('d-none');
            $('.leave_group_option').addClass('d-none');
        } else {
            $('.edit_group_option').addClass('d-none');
            $('.leave_group_option').removeClass('d-none');
        }
        $('#group_options').removeClass('d-none');
        $('#group_id_'+group_id).fadeOut().prependTo('#group_list_div').fadeIn();
        $('#group_id_'+group_id).find('#unread_counter').html('0');
        let data = {"group_id": active_group_id};
        socket.emit('get_group_chats', data);
        $("#group_chat_form input, #group_chat_form select").attr('disabled',false);
        maximize_chat('group_chat_tab');
    }
    //Chat Group Functions
    function editGroup() {
        let data = new FormData();
        data.append('user_id',{{$user_id}});
        data.append('group_id',active_group_id);
        data.append('_token', '{{csrf_token()}}');
        let a = function (){
            $('#processing .modal-dialog').removeClass('modal-sm');
            $('#processing .modal-dialog').addClass('modal-lg');
            $('.select2').select2()
        }
        let arr = [a];
        call_ajax_modal_with_functions("{{route('edit_chat_group')}}",data,'Edit Group',arr);
    }
    function updateGroup() {
        let formData = new FormData($('#chat_group_edit_form')[0]);
        let a = function () {
            $('#chat_group_edit_form')[0].reset();
            let data = { "user_id": {{$user_id}}};
            socket.emit('Get_chat_groups', data);
        }
        let arr = [a];
        call_ajax_with_functions('', '{{route('create_group')}}',formData,arr);
    }
    function leaveGroup(){
        let data = new FormData();
        data.append('user_id',{{$user_id}});
        data.append('group_id',active_group_id);
        data.append('_token', '{{csrf_token()}}');
        let a = function () {
            let data = { "user_id": {{$user_id}}};
            socket.emit('Get_chat_groups', data);
        }
        let arr = [a];
        call_ajax_modal_with_functions("{{route('leave_chat_group')}}",data,'Leave Group',arr);
    }
    function groupInfo(){
        let data = new FormData();
        data.append('user_id',{{$user_id}});
        data.append('group_id',active_group_id);
        data.append('_token', '{{csrf_token()}}');
        let a = function (){
            $('#processing .modal-dialog').removeClass('modal-sm');
            $('#processing .modal-dialog').addClass('modal-lg');
            $('.select2').select2()
        }
        let arr = [a];
        call_ajax_modal_with_functions("{{route('edit_chat_group')}}",data,'Group Info',arr);
    }
    //Alert details view modal
    function get_detail_view(me){
        $('#alert_detail_modal').find('.modal_detail_msg').html($(me).find('.broadcast_msg').html());
        $('#alert_detail_modal').find('.modal_detail_msg_time').html($(me).find('.msg_time').html());
        $('#alert_detail_modal').modal('show');
    }
    function alert_slider(){
        //Slider Notifications
        let numItems = $('.alert_div').length;
        let items = $('.alert_div');
        $(items[0]).slideDown(500,function(){
            let i = 1;
            interval = setInterval(function () {
                if(i<numItems){
                    $(items[i-1]).slideUp(500,function(){
                        $(items[i]).slideDown();
                        i++;
                    });
                }
                else {
                    $(items[i-1]).slideUp(500,function(){
                        $(items[0]).slideDown();
                        i = 1;
                    });
                }
            }, 10000);
        });
    }
    function update_unread_count(){
        let unread_single_chat = $('.user_unread_count');
        let unread_group_chat = $('.group_unread_count');
        let count = 0;
        let count_group = 0;
        $(unread_single_chat).each(function() {
            count = count + parseInt($(this).html());
        });
        $(unread_group_chat).each(function() {
            count_group = count_group + parseInt($(this).html());
        });
        if(count > 0 || count_group > 0){
            $('.chat_sidebar_unread').html((count + count_group));
            $('.chat_sidebar_unread').addClass('unread');
            if(count > 0){
                $('.chat_single_unread').html(count);
                $('.chat_single_unread').addClass('unread');
            }
            if(count_group > 0){
                $('.chat_group_unread').html(count_group);
                $('.chat_group_unread').addClass('unread');
            }
            if(count == 0){
                $('.chat_single_unread').html('');
                $('.chat_single_unread').removeClass('unread');
            }
            if(count_group == 0){
                $('.chat_group_unread').html('');
                $('.chat_group_unread').removeClass('unread');
            }
        }
        else if(count == 0){
            $('.chat_sidebar_unread,.chat_single_unread,.chat_group_unread').html('');
            $('.chat_sidebar_unread,.chat_single_unread,.chat_group_unread').removeClass('unread');
        }
    }

    function forward_msg(me){
        let msg_id = $(me).parent().parent().attr('data-forward');
        $('#forward_message_modal').find('#selected_msg_id').val(msg_id);
        $('#forward_message_modal').modal('show');
    }
    function message_forward(){
        let users = $('.forward_to_users:checkbox:checked');
        let forwarded_msg_id = $('#selected_msg_id').val();
        let arr = $.map($(users), function(c){return c.value; })
        // console.log(forwarded_msg_id,arr);
        let data = { "from_user": {{$user_id}},"to_users": arr,"forwarded_msg_id": forwarded_msg_id};
        socket.emit('forwarded_msg', data);
        $('#forward_message_modal').modal('hide');
    }
    function qoute_msg(me) {
        let msg_id = $(me).parent().parent().attr('data-forward');
        let msg = $(me).parent().parent().attr('data-reply');
        let msg_div = $(reply_msg_div);
        $(msg_div).attr('data-id',msg_id).attr('data-msg',msg);

        if(msg.indexOf('http') >= 0) {
            $(msg_div).find('.reply_msg_text').remove();
            $(msg_div).find('p').append('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+msg+'" alt="chat Img" />');
            $(msg_div).css('top','-100px').css('height','100px');
        } else {
            $(msg_div).find('.reply_msg_text').html(msg);
        }
        if($('#one_two_one_chat_tab').hasClass('active')){
            $('#one_two_one_chat_tab #reply_msg_div').remove();
            $('#one_two_one_chat_tab .m-messenger__form').prepend(msg_div);
            $('#one_two_one_chat_tab .m-messenger__form').prepend(msg_div);
            $('#msg').focus();
        } else {
            $('#group_chat_tab #reply_msg_div').remove();
            $('#group_chat_tab .m-messenger__form').prepend(msg_div);
            $('#group_msg').focus();
        }
    }

    document.addEventListener("DOMContentLoaded", function(event) {
        let ip = "http://" + window.location.hostname + ":3000";
        socket = io(ip,{query:'user_id='+{{$user_id}}});
        // setting current user online
        socket.emit('user_online', {{$user_id}});
        // getting online users
        socket.on('online_users', (online_users) => {
            console.log(online_users);
            sync_online_users(online_users.users);
        });
        // if any user gets offline
        socket.on('user_offline', (user_offline) => {
            console.log(user_offline);
            sync_offline_user(user_offline);
        });

        //Check for notifications
        let data = {"user_id": {{$user_id}}};
        socket.emit('get_alerts', data);
        //Get All notifications
        socket.on('my_alerts', (data) => {
            let item = data.alerts;
            if(item != '') {
                $.each(item, function (key, item) {
                    let broadcast_div = $(broadcast_alert);
                    broadcast_div.find('.broadcaster_name').html(item.full_name);
                    broadcast_div.find('.broadcast_msg').html(item.msg);
                    broadcast_div.find('.msg_time').html(item.dateTime);
                    broadcast_div.find('.alert_div').attr('data-id',item.group_chat_id);
                    $('#alerts-text').prepend(broadcast_div.html());
                });
                alert_slider();
            }
            else{
                console.log("No Alerts So Far.");
            }
        });
        //one to one chat history
        socket.on('chat_history', (data) => {
            let chats = data.chat;
            $('#chat_window').html('');
            $('#chat_window').append($(scroll_btn).html());
            if(chats != ''){
                $.each(chats, function (key, item) {
                    if (item.to_user == chat_active_user_id && item.from_user == {{$user_id}}) {
                        //message send
                        let msg_div = $(msg_send);
                        if(item.msg == null){
                            msg_div.find('.message-text_send').remove();
                        } else {
                            msg_div.find('.message-text_send').html(item.msg);
                            msg_div.find('.msg_time').html(item.dateTime);
                        }
                        if(item.referenced != null){
                            if(item.reply_msg != null) {
                                msg_div.find('.send_reply_para').html(item.reply_msg);
                            }
                            if(item.reply_attachment != null) {
                                msg_div.find('.send_reply_para').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+item.reply_attachment+'" alt="chat Img" />');
                            }
                        } else{
                            msg_div.find('.send_reply_para').remove();
                        }
                        if(item.attachment != null){
                            let files = item.attachment.split(',');
                            $.each(files, function (key, file) {
                                let ext = file.split('.');
                                if(ext[1] != 'png' && ext[1] != 'jpg' && ext[1] != 'jpeg' && ext[1] != 'JPG' && ext[1] != 'JPEG'&& ext[1] != 'PNG' && ext[1] != 'svg'){
                                    $(msg_div).find('.m-messenger__message-body').prepend('<a onclick="downloadFile(this)" data-file="'+file+'"><i class="fa fa-file"></i> '+ext[1]+'</a>');
                                }
                                else {
                                    $(msg_div).find('.m-messenger__message-body').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+file+'" alt="chat Img" />');
                                }
                            });
                        }
                        $('#chat_window').prepend(msg_div.html());
                    } else if ({{$user_id}} == item.to_user && item.from_user == chat_active_user_id) {
                        //message recieve
                        let msg_div = $(msg_recieve);
                        if(item.msg == null){
                            msg_div.find('.message-text_recieved').remove();
                        } else {
                            msg_div.find('.message-text_recieved').html(item.msg);
                            msg_div.find('.msg_time').html(item.dateTime);
                        }
                        if(item.referenced != null){
                            if(item.reply_msg != null) {
                                msg_div.find('.recieve_reply_para').html(item.reply_msg);
                            }
                            if(item.reply_attachment != null) {
                                msg_div.find('.recieve_reply_para').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+item.reply_attachment+'" alt="chat Img" />');
                            }
                        } else {
                            msg_div.find('.recieve_reply_para').remove();
                        }
                        msg_div.find('img').attr('src',chat_active_user_image);
                        msg_div.find('.m-messenger__wrapper_recieved').attr('data-id',item.chat_id);
                        if(item.attachment != null){
                            let files = item.attachment.split(',');
                            $.each(files, function (key, file) {
                                let ext = file.split('.');
                                if(ext[1] != 'png' && ext[1] != 'jpg' && ext[1] != 'jpeg' && ext[1] != 'JPG' && ext[1] != 'JPEG'&& ext[1] != 'PNG' && ext[1] != 'svg'){
                                    $(msg_div).find('.m-messenger__message-body').prepend('<a onclick="downloadFile(this)" data-file="'+file+'"><i class="fa fa-file"></i> '+ext[1]+'</a>');
                                } else {
                                    $(msg_div).find('.m-messenger__message-body').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+file+'" alt="chat Img" />');
                                }
                            });
                        }
                        $('#chat_window').prepend(msg_div.html());
                    }
                    if(scrollToBottom = true) {
                        $("#chat_window").animate({ scrollTop: $("#chat_window").prop('scrollHeight') }, 10);
                    }
                });
                $('#user_id_'+chat_active_user_id).find('#unread_counter').html(0);
                //Updating Unread Count
                update_unread_count();
            } else {
                let msg_div = '<p class="text-center p-3">Start chat!!!!</p>';
                $('#chat_window').html(msg_div);
            }
        });
        //One to one msg recieve
        socket.on('recieve_one_to_one_msg', (data) => {
            let item = data[0];
            if(data.chat != ''){
                if (item.to_user == chat_active_user_id && item.from_user == {{$user_id}}) {
                    //message send
                    let msg_div = $(msg_send);
                    if(item.msg == null){
                        msg_div.find('.message-text_send').remove();
                    } else {
                        msg_div.find('.message-text_send').html(item.msg);
                        msg_div.find('.msg_time').html(item.dateTime);
                    }
                    if(item.referenced != null){
                        if(item.reply_msg != null) {
                            msg_div.find('.send_reply_para').html(item.reply_msg);
                        }
                        if(item.reply_attachment != null) {
                            msg_div.find('.send_reply_para').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+item.reply_attachment+'" alt="chat Img" />');
                        }
                    } else {
                        msg_div.find('.send_reply_para').remove();
                    }
                    $('#chat_window').append(msg_div.html());
                    $('#user_id_'+item.to_user).find('#chat_user_last_msg').html(item.msg);
                } else if ({{$user_id}} == item.to_user && item.from_user == chat_active_user_id) {
                    //message recieve
                    let msg_div = $(msg_recieve);
                    if(item.msg == null){
                        msg_div.find('.message-text_recieved').remove();
                    } else {
                        msg_div.find('.message-text_recieved').html(item.msg);
                        msg_div.find('.msg_time').html(item.dateTime);
                    }
                    if(item.referenced != null){
                        if(item.reply_msg != null) {
                            msg_div.find('.recieve_reply_para').html(item.reply_msg);
                        }
                        if(item.reply_attachment != null) {
                            msg_div.find('.recieve_reply_para').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+item.reply_attachment+'" alt="chat Img" />');
                        }
                    } else {
                        msg_div.find('.recieve_reply_para').remove();
                    }
                    msg_div.find('img').attr('src',chat_active_user_image);
                    msg_div.find('.m-messenger__wrapper_recieved').attr('data-id',item.chat_id);
                    $('#user_id_'+item.from_user).find('#chat_user_last_msg').html(item.msg);
                    $('#chat_window').append(msg_div.html()).then(play_sound());
                } else if({{$user_id}} == item.to_user) {
                    let unread_count = parseInt($('#user_id_'+item.from_user).find('#unread_counter').html()) + 1;
                    $('#user_id_'+item.from_user).find('#unread_counter').html('');
                    $('#user_id_'+item.from_user).find('#unread_counter').html(unread_count);
                    $('#user_id_'+item.from_user).find('#chat_user_last_msg').html(item.msg);
                    //animate to top
                    $('#user_id_'+item.from_user).fadeOut().prependTo('#chat_user_list_container').fadeIn();
                }
                if(scrollToBottom = true) {
                    scrollTOBottom();
                }
            }
            //Updating Unread Count
            update_unread_count();
        });
        //One to one image recieve
        socket.on('receive_one_to_one_img', (data) => {
            let item = data.results[0];
            if(item != ''){
                if (item.to_user == chat_active_user_id && item.from_user == {{$user_id}}) {
                    //message send
                    let msg_div = $(msg_send);
                    if(item.msg == null){
                        msg_div.find('.message-text_send').remove();
                    } else {
                        msg_div.find('.message-text_send').html(item.msg);
                        msg_div.find('.msg_time').html(item.dateTime);
                    }
                    if(item.attachment != null){
                        let files = item.attachment.split(',');
                        $.each(files, function (key, file) {
                            let ext = file.split('.');
                            if(ext[1] != 'png' && ext[1] != 'jpg' && ext[1] != 'jpeg' && ext[1] != 'JPG' && ext[1] != 'JPEG'&& ext[1] != 'PNG' && ext[1] != 'svg'){
                                $(msg_div).find('.m-messenger__message-body').prepend('<a onclick="downloadFile(this)" data-file="'+file+'"><i class="fa fa-file"></i> '+ext[1]+'</a>');
                            } else {
                                $(msg_div).find('.m-messenger__message-body').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+file+'" alt="chat Img" />');
                            }
                        });
                    }
                    $('#chat_window').append(msg_div.html());
                } else if ({{$user_id}} == item.to_user && item.from_user == chat_active_user_id) {
                    //message recieve
                    let msg_div = $(msg_recieve);
                    msg_div.find('.message-text_recieved').html(item.msg);
                    msg_div.find('.msg_time').html(item.dateTime);
                    msg_div.find('img').attr('src',chat_active_user_image);
                    msg_div.find('.m-messenger__wrapper_recieved').attr('data-id',item.chat_id);
                    if(item.attachment != null){
                        let files = item.attachment.split(',');
                        $.each(files, function (key, file) {
                            let ext = file.split('.');
                            if(ext[1] != 'png' && ext[1] != 'jpg' && ext[1] != 'jpeg' && ext[1] != 'JPG' && ext[1] != 'JPEG'&& ext[1] != 'PNG' && ext[1] != 'svg'){
                                $(msg_div).find('.m-messenger__message-body').prepend('<a onclick="downloadFile(this)" data-file="'+file+'"><i class="fa fa-file"></i> '+ext[1]+'</a>');
                            } else {
                                $(msg_div).find('.m-messenger__message-body').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+file+'" alt="chat Img" />');
                            }
                        });
                    }
                    $('#chat_window').append(msg_div.html()).then(play_sound());
                } else if({{$user_id}} == item.to_user) {
                    let unread_count = parseInt($('#user_id_'+item.from_user).find('#unread_counter').html()) + 1;
                    $('#user_id_'+item.from_user).find('#unread_counter').html('');
                    $('#user_id_'+item.from_user).find('#unread_counter').html(unread_count);
                    $('#user_id_'+item.from_user).find('#chat_user_last_msg').html(item.msg);
                    //animate to top
                    $('#user_id_'+item.from_user).fadeOut().prependTo('#chat_user_list_container').fadeIn();
                }
                if(scrollToBottom = true){
                    scrollTOBottom();
                }
            }
            //Updating Unread Count
            update_unread_count();
        });
        //Get Group List
        socket.on('list_chat_groups',(data)=>{
            let groups = data.results;
            $('#group_list_div').html('');
            if(groups != ''){
                $.each(groups, function (key, item) {
                    if(item.department_id == null){ //If group is not departmental
                        let users = item.group_members;
                        var members = users.split(/\s*,\s*/);
                        var isContained = members.indexOf('{{$user_id}}') > -1;
                        if(isContained){
                            if(item.added_by == '{{$user_id}}' || (item.added_by != '{{$user_id}}' && item.type == 1) ){
                                let group_element = $(group_div);
                                $(group_element).find('.m-widget4__title').html(item.title);
                                $(group_element).find('.item_group').attr('id',"group_id_"+item.group_id);
                                $(group_element).find('.item_group').attr('onClick',"get_group_chats("+item.group_id+",this)");
                                if(item.group_image != null){
                                    $(group_element).find('.group_icon').attr('src','{{asset('chat_files')}}/'+item.group_image);
                                }
                                if(item.added_by == {{$user_id}}){
                                    $(group_element).find('.item_group').data('owner','true');
                                }
                                $('#group_list_div').append(group_element);
                            }
                        }
                    }else{
                        let group_element = $(group_div);
                        $(group_element).find('.m-widget4__title').html(item.title);
                        $(group_element).find('.item_group').attr('id',"group_id_"+item.group_id);
                        $(group_element).find('.item_group').attr('onClick',"get_group_chats("+item.group_id+",this)");
                        if(item.group_image != null){
                            $(group_element).find('.group_icon').attr('src','{{asset('chat_files')}}/'+item.group_image);
                        }
                        if(item.added_by == {{$user_id}}){
                            $(group_element).find('.item_group').data('owner','true');
                        }
                        $('#group_list_div').append(group_element);
                    }
                });
            }
        });
        // show chat msg attachment
        function show_attachment_in_chat_msg(files, msg_div) {
            $.each(files, function (key, file) {
                let ext = file.split('.');
                if(ext[1] != 'png' && ext[1] != 'jpg' && ext[1] != 'jpeg' && ext[1] != 'JPG' && ext[1] != 'JPEG'&& ext[1] != 'PNG' && ext[1] != 'svg'){
                    $(msg_div).find('.m-messenger__message-body').prepend('<a onclick="downloadFile(this)" data-file="'+file+'"><i class="fa fa-file"></i> '+ext[1]+'</a>');
                } else {
                    $(msg_div).find('.m-messenger__message-body').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+file+'" alt="chat Img" />');
                }
            });
            return msg_div;
        }
        //Geoup msg recieve
        socket.on('receive_group_msg', (data) => {
            let item = data[0];
            if(item != ''){
                if(item.type == 2){
                    //Broadcast msg
                    if(item.from_user != {{$user_id}}){
                        let broadcast_div = $(broadcast_alert);
                        broadcast_div.find('.broadcaster_name').html(item.full_name);
                        broadcast_div.find('.broadcast_msg').html(item.msg);
                        broadcast_div.find('.msg_time').html(item.dateTime);
                        broadcast_div.find('.alert_div').attr('data-id',item.group_chat_id);
                        $('#alerts-text').prepend(broadcast_div.html());
                        clearInterval(interval);
                        $('.alert_div').each(function(){
                            $(this).slideUp();
                        });
                        alert_slider();
                    }
                }
                if (item.group_id == active_group_id && item.from_user == {{$user_id}}) {
                    //message send
                    let msg_div = $(msg_send);
                    if(item.msg == null){
                        msg_div.find('.message-text_send').remove();
                    } else {
                        msg_div.find('.message-text_send').html(item.msg);
                        msg_div.find('.msg_time').html(item.dateTime);
                    }
                    if(item.attachment != null){
                        let files = item.attachment.split(',');
                        msg_div = show_attachment_in_chat_msg(files, msg_div);
                    }
                    $('#group_chat_window').append(msg_div.html());

                } else if (active_group_id == item.group_id) {
                    //message recieve
                    let msg_div = $(msg_recieve);
                    if(item.msg == null){
                        msg_div.find('.message-text_recieved').remove();
                    } else {
                        msg_div.find('.message-text_recieved').html(item.msg);
                        msg_div.find('.msg_time').html(item.dateTime);
                    }
                    if(item.attachment != null){
                        let files = item.attachment.split(',');
                        msg_div = show_attachment_in_chat_msg(files, msg_div);
                    }
                    msg_div.find('img').attr('src',item.user_image ? '/crm/public/user_images/'+ item.user_image : '/crm/public/user_images/user.png');
                    msg_div.find('.sender_name').html(item.full_name);
                    $('#group_chat_window').append(msg_div.html());play_sound();
                } else {
                    let unread_count = parseInt($('#group_id_'+item.group_id).find('#unread_counter').html()) + 1;
                    $('#group_id_'+item.group_id).find('#unread_counter').html('');
                    $('#group_id_'+item.group_id).find('#unread_counter').html(unread_count);
                    $('#group_id_'+item.group_id).find('#chat_user_last_msg').html(item.msg);
                    //animate to top
                    $('#group_id_'+item.group_id).fadeOut().prependTo('#group_list_div').fadeIn();
                    play_sound();
                }
                $('#group_id_'+item.group_id).find('#last_msg').html(item.msg);
                if(scrollToBottom = true){
                    scrollTOBottom();
                }
            }
            //Updating Unread Count
            update_unread_count();
        });
        //Geoup chat history
        socket.on('receive_group_chats', (data) => {
            let chats = data.chat;
            $('#group_chat_window').html(' ');
            $('#group_chat_window').append($(scroll_btn).html());
            if(chats != ''){
                $.each(chats, function (key, item) {
                    if (item.group_id == active_group_id && item.from_user == {{$user_id}}) {
                        //message send
                        let msg_div = $(msg_send);
                        if(item.msg == null){
                            msg_div.find('.message-text_send').remove();
                        } else {
                            msg_div.find('.message-text_send').html(item.msg);
                            msg_div.find('.msg_time').html(item.dateTime);
                        }
                        if(item.attachment != null){
                            let files = item.attachment.split(',');
                            $.each(files, function (key, file) {
                                let ext = file.split('.');
                                if(ext[1] != 'png' && ext[1] != 'jpg' && ext[1] != 'jpeg' && ext[1] != 'JPG' && ext[1] != 'JPEG'&& ext[1] != 'PNG' && ext[1] != 'svg'){
                                    $(msg_div).find('.m-messenger__message-body').prepend('<a onclick="downloadFile(this)" data-file="'+file+'"><i class="fa fa-file"></i> '+ext[1]+'</a>');
                                } else {
                                    $(msg_div).find('.m-messenger__message-body').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+file+'" alt="chat Img" />');
                                }
                            });
                        }
                        msg_div.find('.send_reply_para').remove();
                        $('#group_chat_window').prepend(msg_div.html());
                    } else if (item.group_id == active_group_id) {
                        //message recieve
                        let msg_div = $(msg_recieve);
                        if(item.msg == null){
                            msg_div.find('.message-text_recieved').remove();
                        } else {
                            msg_div.find('.message-text_recieved').html(item.msg);
                            msg_div.find('.sender_name').html(item.full_name);
                            msg_div.find('.msg_time').html(item.dateTime);
                        }
                        msg_div.find('img').attr('src',item.user_image ? '/crm/public/user_images/'+ item.user_image : '/crm/public/user_images/user.png');
                        if(item.attachment != null){
                            let files = item.attachment.split(',');
                            $.each(files, function (key, file) {
                                let ext = file.split('.');
                                if(ext[1] != 'png' && ext[1] != 'jpg' && ext[1] != 'jpeg' && ext[1] != 'JPG' && ext[1] != 'JPEG'&& ext[1] != 'PNG' && ext[1] != 'svg'){
                                    $(msg_div).find('.m-messenger__message-body').prepend('<a onclick="downloadFile(this)" data-file="'+file+'"><i class="fa fa-file"></i> '+ext[1]+'</a>');
                                } else {
                                    $(msg_div).find('.m-messenger__message-body').prepend('<img onclick="ShowLargeImage(this)" class="chat_attachment" src="'+'{{asset('chat_files')}}/'+file+'" alt="chat Img" />');
                                }
                            });
                        }
                        msg_div.find('.recieve_reply_para').remove();
                        $('#group_chat_window').prepend(msg_div.html());
                    }
                    if(scrollToBottom = true){
                        $("#group_chat_window").animate({ scrollTop: $("#chat_window").prop('scrollHeight') }, 10);
                    }
                });
                $('#user_id_'+chat_active_user_id).find('#unread_counter').html(0);
            } else {
                let msg_div = '<p class="text-center p-3">Start chat!!!!</p>';
                $('#group_chat_window').html(msg_div);
            }
            //Updating Unread Count
            update_unread_count();
        });

        // send file
        function send_file(files, route, form_id, call_back, resp_div, to, to_value){
            let api_token = '3154f2a10b4aecaa9ae8c10468cd8007';
            let data = new FormData($('#'+form_id)[0]);
            data.append('from_user', {{$user_id}});
            data.append(to, to_value);
            data.append('_token', '{{csrf_token()}}');
            data.append('api_token', api_token);
            call_ajax_with_functions(resp_div, route, data,call_back);
        }

        //Send Chat MSG
        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                if($('#one_two_one_chat_tab').hasClass('active')){
                    let msg = $('#msg').val();
                    let attachments =[];
                    const files = document.querySelector('#chat_file').files;
                    if(files.length > 0 || msg != ''){
                        if(files.length > 0){
                            let data_id;
                            let a = function () {
                                $('#msg').val('');
                                $('#chat_file').val('');
                                data_id = {"chat_id":$('#resp_div_img').html()};
                            }
                            let b = function () {
                                $('#resp_div_img').html(' ');
                                socket.emit('send_one_to_one_img', data_id);
                            }
                            let arr = [a,b];
                            send_file(files, '{{route('send_chat_msg')}}', 'chat_form', arr, 'resp_div_img', 'to_user', chat_active_user_id);
                        } else {
                            if($('#reply_msg_div').length){
                                let data = {"from_user": {{$user_id}},"to_user": chat_active_user_id,"msg": msg,"referenced": $('#reply_msg_div').data('id')};
                                socket.emit('send_one_to_one_msg', data);
                            } else {
                                let data = { "from_user": {{$user_id}},"to_user": chat_active_user_id,"msg": msg};
                                socket.emit('send_one_to_one_msg', data);
                            }
                            $('#msg').val('');
                            $('#chat_file').val('');
                            $('#reply_msg_div').remove();
                        }
                    }
                    else {
                        console.log('Nothing to send!!');
                    }
                } else {
                    let msg = $('#group_msg').val();
                    let attachments =[];
                    const files = document.querySelector('#group_chat_file').files;
                    if(files.length > 0 || msg != ''){
                        if(files.length > 0){
                            let api_route = '{{route('send_group_msg')}}?api_token=3154f2a10b4aecaa9ae8c10468cd8007';
                            let data_id;
                            let a = function () {
                                $('#group_msg').val('');
                                $('#group_chat_file').val('');
                                data_id = {"chat_id":$('#resp_div_img').html()};
                            }
                            let b = function () {
                                $('#resp_div_img').html(' ');
                                socket.emit('send_group_msg', data_id);
                            }
                            let arr = [a,b];
                            send_file(files, '{{route('send_group_msg')}}', 'group_chat_form', arr, 'resp_div_img', 'group_id', active_group_id);
                        } else {
                            let data = { "from_user": {{$user_id}},"group_id": active_group_id,"msg": msg};
                            socket.emit('send_group_msg', data);
                            $('#group_msg').val('');
                        }
                    } else {
                        console.log('Nothing in the group chat to send!!');
                    }
                }
            }
        });

        $('#chat_window,#group_chat_window').scroll(function(){
            if((parseFloat($('#chat_window').scrollTop())+parseFloat($('#chat_window').height()) + 65) >= $('#chat_window')[0].scrollHeight){
                $("#chat_window #chat_arrow_icon").css('display' , 'none');
                scrollToBottom = true;
            } else {
                $("#chat_window #chat_arrow_icon").css('display' , 'block');
                scrollToBottom = false;
            }
            if((parseFloat($('#group_chat_window').scrollTop())+parseFloat($('#group_chat_window').height()) + 65) >= $('#group_chat_window')[0].scrollHeight){
                $("#group_chat_window #chat_arrow_icon").css('display' , 'none');
                scrollToBottom = true;
            } else {
                $("#group_chat_window #chat_arrow_icon").css('display' , 'block');
                scrollToBottom = false;
            }
        })

        $('#users_select').select2({
            placeholder: "Select User",
            width: '100%'
        });
        $('#chat_group_form').on('submit',function(e){
            e.preventDefault();
            let formData = new FormData($('#chat_group_form')[0]);
            let a = function () {
                $('#chat_group_form')[0].reset();
                $('#createGroupModal').modal('hide');
                let data = { "user_id": {{$user_id}},"department_id": {{Auth::user()->department_id}}};
                socket.emit('Get_chat_groups', data);
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('create_group')}}',formData,arr);
        });

        $('body').on('click', '.modal-overlay', function () {
            $(".togglesearch").fadeOut();
            $('.modal-overlay, .modal-img').remove();
        });
        $('body').on('click', function () {
            $(".togglesearch").fadeOut();
        });

        $("#search_bar").click(function() {
            $(".togglesearch").toggle();
            $("input[type='text']").focus();
        });
        $("#user_search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            if($('#one_two_one_chat_tab').hasClass('active')){
                $("#chat_user_list_container .m-widget4__item *").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            }
            else{
                $("#group_list_div .m-widget4__item").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            }
        });

        $("#chat_form input, #chat_form select").attr('disabled',true);
        $("#group_chat_form input, #group_chat_form select").attr('disabled',true);

        $('[data-toggle="tooltip"]').tooltip();

        // Right Click on Message Recieved Options
        var $contextMenu = $("#contextMenu");
        $("body").on("contextmenu", "#chat_window .m-messenger__wrapper_recieved .m-messenger__message-body", function(e) {
            $('#contextMenu').removeAttr('data-reply');
            $('#contextMenu').removeAttr('data-forward');
            let msg_id = e.target.parentNode.parentElement.parentElement.dataset.id;
            $contextMenu.attr('data-forward',msg_id);
            if(e.target.attributes.src){
                $contextMenu.attr('data-reply',e.target.attributes.src.textContent);
            }else{
                $contextMenu.attr('data-reply',e.target.innerHTML);
            }
            $contextMenu.css({
                display: "block",
                left: e.pageX,
                top: e.pageY
            });
            return false;
        });
        $('html').click(function() {
            $contextMenu.hide();
        });

        var emojiKeyboard =new EmojiKeyboard;
        emojiKeyboard.default_placeholder ="Search Emoji...";
        let output;
        $("#emojies").click(function() {
            emojiKeyboard.instantiate(document.getElementById("emojies"));
            output = document.getElementById("msg");
        });
        $("#emojies_group").click(function() {
            emojiKeyboard.instantiate(document.getElementById("emojies_group"));
            output = document.getElementById("group_msg");
        });
        emojiKeyboard.callback = (emoji, closed) => {
            output.value += emoji.emoji;
        };

        // Remove reply msg div
        $(document).on('click', '.close_reply_msg_div', function(){
            $('#reply_msg_div').remove();
        });


        //Updating Unread Count
        update_unread_count();

    });
    //Dom Ready ENd



    function ShowLargeImage(me) {
        let url = $(me).attr('src');

        $('#chat_image_modal').find('.modal_img_view').attr('src',url);
        $('#chat_image_modal').modal('show');




        // $('body').append('<div class="modal-overlay" style="z-index:99;"><div class="modal-img"><img src="' + url + '" /></div></div>');
        // $('.modal-img').animate({
        //     opacity: 1
        // },1000);
    }
    function sync_online_users(data) {
        console.log(data);
        for(let i=0; i<data.length; i++){
            if(data[i]) {
                $('#user_id_'+i).removeClass('chat_offline');
                $('#user_id_'+i).addClass('chat_online');
            }
        }
    }
    function sync_offline_user(data){
        $('#user_id_'+data.offline_user).removeClass('chat_online');
        $('#user_id_'+data.offline_user).addClass('chat_offline');
    }
    function scrollTOBottom(){
        if($('#one_two_one_chat_tab').hasClass('active')){
            $("#chat_window").animate({ scrollTop: $("#chat_window").prop('scrollHeight') }, "slow");
        } else {
            $("#group_chat_window").animate({ scrollTop: $("#group_chat_window").prop('scrollHeight') }, "slow");
        }
    }
    function downloadFile(me) {
        let url = $(me).data('file');
        let name = url.split('.');
        var req = new XMLHttpRequest();
        req.open("GET", '{{asset('chat_files')}}/'+url, true);
        req.responseType = "blob";
        req.onload = function (event) {
            var blob = req.response;
            var fileName = name[0]; //if you have the fileName header available
            var link=document.createElement('a');
            link.href=window.URL.createObjectURL(blob);
            link.download=fileName;
            link.click();
        };
        req.send();
    }
</script>
<style>
    /*sdafad */
    .chat_half_box1{
        display: flex;
        position: absolute;
        width: 95%;
        height: 90%;
        overflow-y: scroll;
    }
    .chat_half_box2{
        display: flex;
        position: absolute;
        bottom: -30px;
        width: 105%;
        border-top: 2px dashed #ddd;
        background: #fff;
        transition: 0.5s ease-in-out;
        padding-bottom: 30px;
        margin-left: -30px;
    }
    #chat_window{
        padding: 0px 10px;
    }
    .m-messenger{
        display: none;
    }
    .m-widget4__img--logo{
        position: relative;
    }
    .m-widget4__sub{
        width: 150px;
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .chat_online .m-widget4__img--logo::after {
        content: '';
        width: 10px;
        height: 10px;
        background-color: green;
        position: absolute;
        border-radius: 50%;
    }
    .chat_offline .m-widget4__img--logo::after {
        content: '';
        width: 10px;
        height: 10px;
        background-color: red;
        position: absolute;
        border-radius: 50%;
    }

    .maximize_btn{
        bottom: 20px;
        right: 20px;
        background-color: #716aca;
        border:1px solid #716aca;
        color: #fff;
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    .maximize_btn:hover{
        color: #716aca;
        border:1px solid #716aca !important;
    }
    .maximize_btn i {
        font-size: 25px;
        transform: scaleX(-1);
    }
    #emojikb-maindiv{
        height: 300px;
        z-index: 99999;
        bottom: 80px;
        position: fixed;
    }
    #emojies,#emojies_group{
        position: absolute;
        background: transparent;
        border: none;
        top: 11px;
        right: 10px;
    }
</style>
