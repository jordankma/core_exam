<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @yield('title')
        {{-- @section('title')
            | {{ (!empty($SETTING['title'])) ? $SETTING['title'] : 'VNEdutech CMS' }}
        @show --}}
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="icon" href="{{ (!empty($SETTING['favicon'])) ? asset($SETTING['favicon']) : '' }}" type="image/png" sizes="32x32">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/js/html5shiv.js?t=').time() }}"></script>
    <script src="{{ asset('/js/respond.min.js?t=').time() }}"></script>
    <![endif]-->

    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- global css -->
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/css/main.min.css?t=' . time()) }}"/>
    <!-- end of global css -->

    <!--page css-->
    @yield('header_styles')
    <!--end of page css-->

<body class="home">
    <noscript>
        <![if !(lte IE 9)]>
        <div class="noscript-message">
            <div class="noscript-message__content">
                <p>Trinh duyệt của bạn không hỗ trợ hoặc đã tắt JavaScript, bạn vui lòng cập nhận trình đuyệt web hoặc mở
                    JavaScript trong
                    phần cài đặt.</p>
            </div>
        </div>
        <![endif]>
    </noscript>
    @include('includes.frontend.header')
    <div id="notific">
        @include('includes.notifications')
    </div>
    @yield('content')
    @include('includes.frontend.footer')
    @include('includes.frontend.modal')
</body>
<!-- global js -->
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/js/vendor/jquery-3.3.1.min.js?t=').time() }}"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> --}}
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/js/vendor/slick.min.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/js/main.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/js/login.js?t=').time() }}"></script>
<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
@yield('footer_scripts_more')
<!-- end page level js -->
</body>
</html>
