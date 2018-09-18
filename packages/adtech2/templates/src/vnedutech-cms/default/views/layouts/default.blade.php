<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | {{ (!empty($SETTING['title'])) ? $SETTING['title'] : 'VNEdutech CMS' }}
        @show
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
    <link rel="stylesheet" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/app.css?t=' . time()) }}"/>
    <link rel="stylesheet" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/global.css?t=' . time()) }}"/>
    <!-- end of global css -->

    <!--page css-->
    @yield('header_styles')
    <!--end of page css-->

<body class="skin-josh">
<header class="header">
    <a href="{{ route('adtech.core.menu.tab', ['tab' => (count($MENU_TOP) > 0) ? $MENU_TOP[0]->group : '']) }}" class="logo">
        <img src="{{ (empty($SETTING['logo_mini'])) ? '' : asset($SETTING['logo_mini']) }}" alt="logo" style="height: 35px; max-width: 200px">
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                @include('includes._locales')
                @include('includes._users')
                {{--@include('includes._notifications')--}}

            </ul>
        </div>

        @include('includes._menu_top')
    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="nav_icons">
                    <ul class="sidebar_threeicons">
                        @if ($USER_LOGGED->canAccess('adtech.core.package.manage'))
                            <li>
                                <a href="{{ route('adtech.core.package.manage') }}">
                                    <i class="livicon" data-name="table" title="Packages" data-loop="true"
                                       data-color="#418BCA" data-hc="#418BCA" data-s="25"></i>
                                </a>
                            </li>
                        @endif
                        @if ($USER_LOGGED->canAccess('adtech.core.menu.manage'))
                            <li>
                                <a href="{{ route('adtech.core.menu.manage') }}">
                                    <i class="livicon" data-name="list-ul" title="Menus" data-loop="true"
                                       data-color="#e9573f" data-hc="#e9573f" data-s="25"></i>
                                </a>
                            </li>
                        @endif
                        @if ($USER_LOGGED->canAccess('adtech.core.file.manage'))
                            <li>
                                <a href="{{ route('adtech.core.file.manage') }}">
                                    <i class="livicon" data-name="image" title="File manager" data-loop="true"
                                       data-color="#F89A14" data-hc="#F89A14" data-s="25"></i>
                                </a>
                            </li>
                        @endif
                        @if ($USER_LOGGED->canAccess('adtech.core.setting.manage'))
                            <li>
                                <a href="{{ route('adtech.core.setting.manage') }}">
                                    <i class="livicon" data-name="gear" title="Users" data-loop="true"
                                       data-color="#6CC66C" data-hc="#6CC66C" data-s="25"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                {{--<div class="clearfix"></div>--}}
                {{--@if (count($LOCALES) > 0)--}}
                {{--<select id="selectFlag" class="form-control select2">--}}
                    {{--@foreach($LOCALES as $locale)--}}
                        {{--<option value="{{ $locale->alias }}" {{ ($locale->alias == config('app.locale')) ? ' selected="selected"' : '' }} data-flag="{{ config('site.url_storage') . '/' . $locale->icon }}">{{ $locale->name }}</option>--}}
                    {{--@endforeach--}}
                {{--</select><br>--}}
                {{--@endif--}}
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                @include('includes._left_menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

        <!-- Notifications -->
        <div id="notific">
        @include('includes.notifications')
        </div>

        <!-- Content -->
        @yield('content')

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/jquery-1.11.1.min.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/jquery-ui.min.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/bootstrap.min.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/raphael-min.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/livicons-1.4.min.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/metisMenu.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/josh.js?t=').time() }}"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/holder.min.js?t=').time() }}"></script>

<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
@yield('footer_scripts_more')
<!-- end page level js -->
</body>
</html>
