<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('adtech-core::titles.login.login') }} {{ (!empty($SETTING['title'])) ? '| ' . $SETTING['title'] : '' }}</title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/bootstrap.min.css') }}">
    <link rel="icon" href="{{ (!empty($SETTING['favicon'])) ? config('site.url_static') . ($SETTING['favicon']) : '' }}" type="image/png" sizes="32x32">
    <!--end of global css-->
    <!--page level css starts-->
    <link rel="stylesheet" href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/app.css?t=' . time()) }}"/>

    <link href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/frontend/login.css') }}">
    <link rel="stylesheet" href=" {{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/font-awesome.min.css') }}">
    <!--end of page level css-->

</head>
<body>
<div class="container">
    <!--Content Section Start -->
    <div class="row">
        <div class="box animation flipInX">
            <div class="box1">
                <img src="{{ (!empty($SETTING['logo'])) ? config('site.url_storage') . ($SETTING['logo']) : '' }}" alt="logo" class="img-responsive mar">
                <br>
                <div id="notific">
                    @include('includes.notifications')
                </div>
                <form action="{{ route('adtech.core.auth.login') }}" class="omb_loginForm"  autocomplete="off" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group {{ $errors->first('email', 'has-error') }}">
                        <label class="sr-only">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email"
                               value="{!! old('email') !!}">
                    </div>
                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    <div class="form-group {{ $errors->first('password', 'has-error') }}">
                        <label class="sr-only">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>

                    @if (session()->has('count_login'))
                        @if (session()->get('count_login') > 4)
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LeQL28UAAAAAIUGcNTy1HzD7g9dseSVmXvmQTT2" data-callback="YourOnSubmitFn"></div>
                        </div>
                        @endif
                    @endif

                    <input type="submit" class="btn btn-block btn-primary" value="{{ trans('adtech-core::buttons.login') }}">
                </form>

            </div>
            <div class="bg-light animation flipInX">
                <a href="{{ route('adtech.core.auth.forgot') }}" id="forgot_pwd_title">{{ trans('adtech-core::buttons.forgot_password') }}</a>
            </div>
        </div>
    </div>
    <!-- //Content Section End -->
</div>
<!--global js starts-->
<script type="text/javascript" src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/js/frontend/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/js/frontend/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"></script>
<script type="text/javascript" src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/js/frontend/login_custom.js') }}"></script>
<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
<!--global js end-->
</body>
</html>
