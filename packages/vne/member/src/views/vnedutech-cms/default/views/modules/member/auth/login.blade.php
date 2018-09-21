<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('adtech-core::titles.login.login') }} {{ (!empty($SETTING['title'])) ? '| ' . $SETTING['title'] : '' }}</title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/bootstrap.min.css') }}">
    <link rel="icon" href="{{ (!empty($SETTING['favicon'])) ? asset($SETTING['favicon']) : '' }}" type="image/png" sizes="32x32">
    <!--end of global css-->
    <!--page level css starts-->
    <link rel="stylesheet" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/app.css?t=' . time()) }}"/>

    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/frontend/login.css') }}">
    <link rel="stylesheet" href=" {{ asset('/vendor/' . $group_name . '/' . $skin . '/css/font-awesome.min.css') }}">
    <!--end of page level css-->
    <style type="text/css">
        body{
            background: url('../images/background_fr.jpg') center center fixed !important;
        }
    </style>
</head>
<body>
<div class="container">
    <!--Content Section Start -->
    <div class="row">
        <div class="box animation flipInX">
            <div class="box1">
                <img src="{{ (!empty($SETTING['logo'])) ? asset($SETTING['logo']) : '' }}" alt="logo" class="img-responsive mar">
                <br>
                <div id="notific">
                @include('includes.notifications')
                </div>
                <form action="{{ route('dhcd.member.auth.login') }}" class="omb_loginForm"  autocomplete="off" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group {{ $errors->first('u_name', 'has-error') }}">
                        <label class="sr-only">Username</label>
                        <input type="text" class="form-control" name="u_name" placeholder="Username"
                               value="{!! old('u_name') !!}">
                    </div>
                    <span class="help-block">{{ $errors->first('u_name', ':message') }}</span>
                    <div class="form-group {{ $errors->first('password', 'has-error') }}">
                        <label class="sr-only">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                    <input type="submit" class="btn btn-block btn-primary" value="{{ trans('adtech-core::buttons.login') }}">
                </form>

            </div>
        </div>
    </div>
    <!-- //Content Section End -->
</div>
<!--global js starts-->
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/frontend/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/frontend/bootstrap.min.js') }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/frontend/login_custom1.js') }}"></script>
<!--global js end-->
</body>
</html>
