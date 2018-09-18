<!DOCTYPE html>
<html>
<head>
    <title>Admin Login | Josh Admin Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <!-- end of global level css -->
    <!-- page level css -->
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/login2.css') }}" rel="stylesheet"/>
    <!-- styles of the page ends-->
</head>

<body>
    <div class="container">
        <div class="row vertical-offset-100">
            <div class=" col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3  col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{ trans('adtech-core::labels.setting_new_password') }}</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" class="form-horizontal">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <!-- New Password -->
                            <div class="form-group{{ $errors->first('password', ' has-error') }} col-sm-12">
                                <label for="password">{{ trans('adtech-core::labels.new_password') }}</label>
                                <input type="password" name="inputPassword" id="password" value="{{ old('password') }}"
                                       class="form-control"/>
                                {{ $errors->first('password', '<span class="help-block">:message</span>') }}
                            </div>

                            <!-- Password Confirm -->
                            <div class="form-group{{ $errors->first('password_confirm', ' has-error') }} col-sm-12">
                                <label class="control-label" for="password_confirm">{{ trans('adtech-core::labels.confirm_new_password') }}</label>
                                <input type="password" name="inputConfirmPassword" id="password_confirm"
                                       value="{{ old('password_confirm') }}" class="form-control"/>
                                {{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
                            </div>

                            <!-- Form actions -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a class="btn" href="{{ route('backend.homepage') }}">{{ trans('adtech-core::buttons.discard') }}</a>

                                    <button type="submit" class="btn btn-info">{{ trans('adtech-core::buttons.confirm') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/jquery-1.11.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/bootstrap.min.js') }}"></script>
    <!-- end of global js -->
    <!-- begining of page level js-->
    <script src="{{ asset('assets/js/TweenLite.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(document).mousemove(function(event) {
            TweenLite.to($('body'),
                .5, {
                    css: {
                        backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px"
                    }
                });
        });
    });
    </script>
