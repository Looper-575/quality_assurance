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
                    <div class="m-widget4" style="width: 95%;">
                        <?php
                        $users = \App\Models\User::where('status',1)->get();
                        ?>
                        @foreach($users as $user)
                            <div class="m-widget4__item chat_offline" id="user_id_{{$user->user_id}}">
                                <div class="m-widget4__img m-widget4__img--logo">
                                    <img src="{{asset('user_images').'/'.($user->image ? $user->image : 'user.png')}}" alt="">
                                </div>
                                <div class="m-widget4__info">
                                    <span class="m-widget4__title">{{$user->full_name}}</span>
                                    <br>
                                    <span class="m-widget4__sub">{{$user->user_type}}</span>
                                </div>
                            </div>
                        @endforeach;
                    </div>
                </div>
                <div id="chat_container" class="chat_half_box2">
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
                                        <img src="assets/app/media/img/users/user3.jpg" alt=""/>
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
                                <a href="" class="m-messenger__form-attachment">
                                    <i class="la la-paperclip"></i>
                                </a>
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
                                <a href="" class="m-messenger__form-attachment">
                                    <i class="la la-paperclip"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end::Quick Sidebar -->
<script src="{{asset('assets/js/socket.io.min.js')}}"></script>
<script type="text/javascript">
    let chat_sidebar_state = true;
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
    document.addEventListener("DOMContentLoaded", function(event) {
        let ip = "http://"+window.location.hostname+":3000";
        let socket = io(ip);
        // setting current user online
        socket.emit('user_online', {{Auth::user()->user_id}});
        // getting online users
        socket.on('online_users', (online_users)=> {
            console.log(online_users);
            sync_online_users(online_users.users);
        });
        // if any user gets offline
        socket.on('user_offline', (user_offline)=> {
            console.log(user_offline);
            sync_offline_user(user_offline);
        });


        socket.on('test', (data)=>{
            console.log(data);
        });

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
