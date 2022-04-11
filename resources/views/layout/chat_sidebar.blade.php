<!-- begin::Quick Sidebar -->
<div id="chat_sidebar" class="of-hide m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
    <div class="m-quick-sidebar__content m--hide">
        <span onclick="toggle_chat();" id="m_quick_sidebar_close" class="m-quick-sidebar__close">
            <i class="la la-close"></i>
        </span>
        <ul id="m_quick_sidebar_tabs" class="nav mb-1 nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#one_two_one_chat_tab" role="tab">
                    one to one chats
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#group_chat_tab" role="tab">
                    group chats
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
                            (SELECT count(chats.msg) FROM chats WHERE (chats.to_user = $user_id AND chats.from_user = users.user_id) AND msg_read=0
                            ORDER by chat_id DESC LIMIT 1) as unread_count FROM `users`
                            WHERE status=1 AND user_id !=$user_id ORDER BY last_msg DESC");
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
                                        <div class="align-items-center badge-secondary d-flex justify-content-center position-absolute" id="unread_counter" style="width: 30px;height: 30px;right: 0px;top: 30%;border-radius: 50%;">
                                            {{$user->unread_count}}
                                        </div>
                                    </div>
                                </button>
                            </div>
                        @endforeach;
                    </div>
                </div>
                <div id="chat_container" class="chat_half_box2">
                    <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light position-relative"  style="width: 95%;">
                        <div class="active_chat_info">
                            chat with:
                            <h3 id="chat_with_name" class="d-inline-block">None</h3>
                        </div>
                        <div class="m-messenger__messages" id="chat_window" style="height: 80%; overflow-y: scroll">
                            {{--                            <div class="m-messenger__wrapper">--}}
                            {{--                                <div class="m-messenger__message m-messenger__message--in">--}}
                            {{--                                    <div class="m-messenger__message-pic">--}}
                            {{--                                        <img src="assets/app/media/img//users/user3.jpg" alt=""/>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="m-messenger__message-body">--}}
                            {{--                                        <p class="m-messenger__message-text message-text_recieved">--}}
                            {{--                                            Hi Bob. What time will be the meeting ?--}}
                            {{--                                        </p>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="m-messenger__wrapper">--}}
                            {{--                                <div class="m-messenger__message m-messenger__message--out">--}}
                            {{--                                    <div class="m-messenger__message-body">--}}
                            {{--                                        <p class="m-messenger__message-text message-text_send">--}}
                            {{--                                            Hi Megan. It's at 2.30PM--}}
                            {{--                                        </p>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="m-messenger__datetime">--}}
                            {{--                                2:30PM--}}
                            {{--                            </div>--}}
                        </div>
                        <div class="m-messenger__seperator" style="margin: 5px 0;"></div>
                        <div class="m-messenger__form">
                            <div class="m-messenger__form-controls">
                                <input type="text" name="msg" id="msg" placeholder="Type here..." class="m-messenger__form-input">
                            </div>
                            <div class="m-messenger__form-tools">
                                <input type="file" id="chat_file" name="chat_fil" multiple class="sr-only">
                                <label class="m-messenger__form-attachment" id="send_msg" for="chat_file">
                                    <i class="la la-paperclip"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="group_chat_tab" role="tabpanel">
                <div id="users_list_container" class="chat_half_box1">
                    <div class="m-widget4" style="width: 94%;">
                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--logo">
                                <img src="assets/app/media/img/client-logos/logo5.png" alt="">
                            </div>
                            <div class="m-widget4__info">
													<span class="m-widget4__title">
														Trump Themes
													</span>
                                <br>
                                <span class="m-widget4__sub">
														Make Metronic Great Again
													</span>
                            </div>
                            <span class="m-widget4__ext">
													<span class="m-widget4__number m--font-brand">
														+$2500
													</span>
												</span>
                        </div>
                    </div>
                </div>
                <div id="chat_container border-top" class="chat_half_box2">
                    <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light"  style="width: 95%;">
                        <div class="m-messenger__messages" style="height: 80%; overflow-y: scroll">
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="assets/app/media/img//users/user3.jpg" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Hi Bob. What time will be the meeting ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Hi Megan. It's at 2.30PM
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="assets/app/media/img//users/user3.jpg" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Will the development team be joining ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__datetime">
                                2:30PM
                            </div>
                        </div>
                        <div class="m-messenger__seperator" style="margin: 20px 0;"></div>
                        <div class="m-messenger__form">
                            <div class="m-messenger__form-controls">
                                <input type="text" name="" placeholder="Type here..." class="m-messenger__form-input">

                            </div>
                            <div class="m-messenger__form-tools">
                                <button class="m-messenger__form-attachment">
                                    <i class="la la-paperclip"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end::Quick Sidebar -->
{{--<script src="{{asset('assets/js/siofu_client.js')}}"></script>--}}
<script src="{{asset('assets/js/socket.io.min.js')}}"></script>
<script type="text/javascript">
    let chat_sidebar_state = true;
    let socket;
    let chat_active_user_id;
    let chat_active_user_image;
    let scrollToBottom = false;
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
    // Get One to One chat
    function get_one_to_one_chats(user_id,me){
        let data = { "from_user": {{Auth::user()->user_id}},"to_user": user_id};
        //get active user image
        chat_active_user_id = user_id;
        $('#chat_with_name').html($(me).data('name'));
        chat_active_user_image = $(me).find('.user_img').attr('src');
        //animate to top
        $('#user_id_'+chat_active_user_id).fadeOut().prependTo('#chat_user_list_container').fadeIn();
        // $("#chat_user_list_container").prepend($('#user_id_'+chat_active_user_id));
        socket.emit('get_one_to_one_chats', data);
    }
    document.addEventListener("DOMContentLoaded", function(event) {
        let ip = "http://" + window.location.hostname + ":3000";
        socket = io(ip,{query:'user_id='+{{Auth::user()->user_id}}});
        // setting current user online
        socket.emit('user_online', {{Auth::user()->user_id}});
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


        socket.on('chat_history', (data) => {
            let chats = data.chat;
            $('#chat_window').html('');
            $('#chat_window').append($(scroll_btn).html());
            if(chats != ''){
                $.each(chats, function (key, item) {
                    if (item.to_user == chat_active_user_id && item.from_user == {{Auth::user()->user_id}}) {
                        //message send
                        let msg_div = $(msg_send);
                        msg_div.find('.message-text_send').html(item.msg);
                        $('#chat_window').append(msg_div.html());

                    } else if ({{Auth::user()->user_id}} == item.to_user && item.from_user == chat_active_user_id) {
                        //message recieve
                        let msg_div = $(msg_recieve);
                        msg_div.find('.message-text_recieved').html(item.msg);
                        msg_div.find('img').attr('src',chat_active_user_image);
                        $('#chat_window').append(msg_div.html());
                    }

                    if(scrollToBottom = true){
                        $("#chat_window").animate({ scrollTop: $("#chat_window").prop('scrollHeight') }, 10);
                    }
                });
                $('#user_id_'+chat_active_user_id).find('#unread_counter').html(0);
            }else{
                let msg_div = '<p class="text-center p-3">Start chat!!!!</p>';
                $('#chat_window').html(msg_div);
            }
        });

        socket.on('recieve_one_to_one_msg', (data) => {
            console.log(data);
            return 0;
            let item = data[0];
            if(data.chat != ''){
                if (item.to_user == chat_active_user_id && item.from_user == {{Auth::user()->user_id}}) {
                    //message send
                    let msg_div = $(msg_send);
                    msg_div.find('.message-text_send').html(item.msg);
                    $('#chat_window').append(msg_div.html());

                } else if ({{Auth::user()->user_id}} == item.to_user && item.from_user == chat_active_user_id) {
                    //message recieve
                    let msg_div = $(msg_recieve);
                    msg_div.find('.message-text_recieved').html(item.msg);
                    msg_div.find('img').attr('src',chat_active_user_image);
                    $('#chat_window').append(msg_div.html());
                }
                else if({{Auth::user()->user_id}} == item.to_user) {
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
        });
        socket.on('test', (data) => {
            console.log(data);
        });

        {{--$('#send_msg').click(function(){--}}
        {{--    let msg = $('#msg').val();--}}
        {{--    let data = { "from_user": {{Auth::user()->user_id}},"to_user": chat_active_user_id,"msg": msg};--}}
        {{--    socket.emit('send_one_to_one_msg', data);--}}
        {{--    $('#msg').val('');--}}
        {{--})--}}

        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                let msg = $('#msg').val();
                let attachments =[];
                const files = document.querySelector('#chat_file').files;
                if(msg != '' || files.length > 0){

                    if(files.length > 0){
                        $.each(files, async function (key, file) {
                            let att = {
                                file_name : '',
                                file_content : ''
                            };
                            att.file_content = await toBase64(file);
                            att.file_name = file.name;
                            attachments.push(att);
                        });
                    }
                    let data = { "from_user": {{Auth::user()->user_id}},"to_user": chat_active_user_id,"msg": msg,"att":attachments};
                    console.log(data);
                    socket.emit('send_one_to_one_msg', data);
                    $('#msg').val('');
                    $('#chat_file').val('');
                }
                else
                    console.log('Nothing to send!!');
            }
        });

        $('#chat_window').scroll(function(){
            if((parseFloat($('#chat_window').scrollTop())+parseFloat($('#chat_window').height()) + 65) >= $('#chat_window')[0].scrollHeight){
                $("#chat_arrow_icon").css('display' , 'none');
                scrollToBottom = true;
            } else {
                $("#chat_arrow_icon").css('display' , 'block');
                scrollToBottom = false;
            }
        })


    });
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
        $("#chat_window").animate({ scrollTop: $("#chat_window").prop('scrollHeight') }, "slow");
    }
    const toBase64 = file => new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result.replace('data:', '').replace(/^.+,/, ''));
        reader.onerror = error => reject(error);
    });

    let msg_recieve = (function () {/*
    <div>
<div class="m-messenger__wrapper">
  <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="assets/app/media/img//users/user3.jpg" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <p class="m-messenger__message-text message-text_recieved">
                                            Hi Bob. What time will be the meeting ?
                                        </p>
                                    </div>
                                </div>
                            </div>
                            </div>
 */}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let msg_send = (function () {/*
    <div>
    <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <p class="m-messenger__message-text message-text_send">
                                            Hi Megan. It's at 2.30PM
                                        </p>
                                    </div>
                                </div>
                            </div>
    </div>
 */}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
    let scroll_btn = (function () {/*
    <div>
    <button class="btn" id="chat_arrow_icon" onclick="scrollTOBottom()"><i class="fas fa-arrow-down"></i></button>
    </div>
 */}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];

</script>
<style>
    /*sdafad */
    .chat_half_box1{
        display: flex;
        position: absolute;
        width: 93%;
        height: 40%;
        overflow-y: scroll;
    }
    .chat_half_box2{
        display: flex;
        position: absolute;
        top: 50%;
        width: 93%;
        height: 48%;
        border-top: 2px dashed #ddd;
    }
    .m-widget4__img--logo{
        position: relative;
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
</style>
