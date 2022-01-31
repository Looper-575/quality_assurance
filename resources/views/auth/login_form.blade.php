<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>Atlantis BPO CRM - Login</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="{{asset('assets/webfont.js')}}"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="{{asset('assets/css/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <style>
        #login_container{
            display: block;
            margin:0;
            float: left;
            width: fit-content;
            margin-left: 100px;
            height: fit-content;
            vertical-align: center;
            margin-top: 8vh;
        }
        #m_login_signin_submit:hover{
            background: #1c1c1c;
            border-color: #1c1c1c;
            color:#fff !important;
        }
        .m-input{
            background-color: #DDD !important;
            color: #000 !important;
        }
        .m-input::placeholder {
            color: #000 !important;
        }
        .m-login__container{
            box-shadow: 0px 0px 11px 2px rgba(100, 100, 100, 0.75);
            -webkit-box-shadow: 0px 0px 11px 2px rgba(100, 100, 100, 0.75);
            -moz-box-shadow: 0px 0px 11px 2px rgba(100, 100, 100, 0.75);
            padding: 25px;
            border-radius: 10px;
        }
        #m_login_signin_submit{
            color:#000;
            border-color: #000;
            box-shadow: 0 5px 10px 2px rgba(100, 100, 100,.19) !important;

        }
    </style>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url({{asset('assets/img/bg/login_bg.png')}});">
        <div id="login_container" class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="#">
                        <img width="280px" src="{{asset('assets/img/logo-full.png')}}">
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title text-dark">Sign In</h3>
                    </div>
                    <form class="m-login__form m-form"  id="login_form" action="javascript:login();">
                        @csrf
                        <div class="form-group m-form__group">
                            <input class="form-control m-input"   type="text" placeholder="Email" name="email" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
<!--begin::Base Scripts -->
<script src="{{asset('assets/js/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}" type="text/javascript"></script>
<!--end::Base Scripts -->
<script>
    function login() {
        let data = new FormData($('#login_form')[0]);
        let a = function () { window.location.reload(); };
        let arr = [a];
        call_ajax_with_functions('', '{{route('do_login')}}', data, arr);
    }
</script>
<script src="{{asset('assets/js/ajax.js')}}"></script>
</body>
<!-- end::Body -->
</html>
