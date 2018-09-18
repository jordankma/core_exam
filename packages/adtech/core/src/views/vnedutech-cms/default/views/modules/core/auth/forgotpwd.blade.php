<!DOCTYPE html>
<html>
<head>
    {{--<meta charset="utf-8">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('adtech-core::titles.login.forgot_password') }} {{ (!empty($SETTING['title'])) ? '| ' . $SETTING['title'] : '' }}</title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/bootstrap.min.css') }}">
    <link href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <link rel="icon" href="{{ (!empty($SETTING['favicon'])) ? asset($SETTING['favicon']) : '' }}" type="image/png" sizes="32x32">
    <!--end of global css-->
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/frontend/forgot.css') }}">
    <!--end of page level css-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="box animation flipInX">
            <img src="{{ (!empty($SETTING['logo'])) ? asset($SETTING['logo']) : '' }}" alt="logo" class="img-responsive mar"><br>
            <h3 class="text-primary">{{ trans('adtech-core::titles.login.forgot_password') }}</h3>
            <p>{{ trans('adtech-core::titles.login.forgot_password_mess') }}</p>
            <div id="notific">
            @include('includes.notifications')
            </div>
            <form action="{{ route('adtech.core.auth.forgot') }}" class="omb_loginForm" autocomplete="off" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label class="sr-only"></label>
                    <input type="email" class="form-control email" name="inputEmail" placeholder="Email"
                           value="{!! old('email') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control btn btn-primary btn-block" type="submit" value="{{ trans('adtech-core::buttons.reset_password') }}">
                </div>
            </form>

            {{ trans('adtech-core::titles.login.comeback_login') }}<a href="{{ route('adtech.core.auth.login') }}"> {{ trans('adtech-core::titles.login.click_here') }}</a>
        </div>
    </div>
</div>
<!--global js starts-->
<script type="text/javascript" src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/js/jquery.min.js') }}"></script>
<script src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/js/frontend/forgotpwd_custom.js') }}"></script>
<!--global js end-->
</body>
</html>
