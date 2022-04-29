<!--begin::Modal-->
<div class="modal fade" id="welcome_modal" tabindex="-1" role="dialog" aria-labelledby=welcome_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div id="welcome_modal_content" class="modal-content">
            <div class="modal-body text-center" style="padding: 50px 25px;">
                <div class="row justify-content-center">
                    <div class="col-10">
                    @if(Auth::user())
                        <div id="profile_user_img_div" class="rounded-circle mb-2" >
                            <img id="cap" class="d-none" src="{{asset('assets/img/icons/birthday_cap.png')}}" width="40px" height="40px">
                            <img src="{{(isset(Auth::user()->image) && !empty(Auth::user()->image))?asset('user_images/'.Auth::user()->image):asset('user_images/user.png')}}"
                                id="profile_user_img" class="rounded-circle" alt="{{Auth::user()->full_name}}">
                            <img id="cake" class="d-none" src="{{asset('assets/img/icons/cake.png')}}" width="40px" height="40px">
                        </div>
                        <div id="welcome_note">
                            <p id="emp_name">
                                <span id="welcome_message">Welcome Back</span>
                                {{Auth::user()->full_name}} ! </p>
                            <p class="d-none text-small" id="birthday_message"></p>
                            <div id="notifications">
                                <div class="text-center" >
                                    <img src="{{asset('assets/img/icons/alert.png')}}" width="30px" height="30px">
                                </div>
                                <p> You have <b> <span id="notifications_count"></span> new </b> notifications</p>
                            </div>
                            <div id="unread_messages">
                                <div class="text-center" >
                                    <img src="{{asset('assets/img/icons/message.png')}}" width="30px" height="30px">
                                </div>
                                <p> You have <b> <span id="unread_messages_count"></span> unread </b> messages</p>
                            </div>
                            <div id="other_birthday" class="d-none">
                                <div class="text-center" >
                                    <img src="{{asset('assets/img/icons/cake.png')}}" width="30px" height="30px">
                                </div>
                                <p> It's <b> <span id="other_birthday_names"></span> </b>Birthday Today</p>
                            </div>
                        </div>
                    @endif
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"> OK </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<style>
    #profile_user_img_div{
        width: 125px;
        height: 125px;
        position: relative;
        margin: auto;
        box-shadow: 0px -25px 30px 0px rgba(0,0,0,0.4);
        -webkit-box-shadow: 0px -25px 30px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px -25px 30px 0px rgba(0,0,0,0.4);
    }
    #profile_user_img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    #birthday {
        background-color: #7d38da;
    }
    #cap {
        position: absolute;
        width: 50px;
        height: 50px;
        left: -14px;
        top: -23px;
        transform: rotate(346deg);
    }
    #cake{
        margin-left: 105px;
        margin-top: -26px;
        width: 40px;
        height: 40px;
    }
    #emp_name{
        font-size: 21px;
        color: #7d38da;
        font-weight: 900;
    }
    .notification_icon{
        position: absolute;
        top: 5px;
        right: 5px;
    }
    .notification_icon.new{
        position: absolute;
        width: 20px;
        height: 20px;
        background: #e10505;
        border-radius: 50%;
        color: white;
        font-size: 10px;
    }
</style>
