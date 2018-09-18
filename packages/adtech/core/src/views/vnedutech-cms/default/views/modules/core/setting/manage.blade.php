@extends('layouts.default')

{{-- Page title --}}
@section('title')
    {{ $title_page = trans('adtech-core::titles.setting.manage') }}
    @parent
@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <!--end of page css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        {{--<h1>{{ $title_page }}</h1>--}}
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                                         data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title_page }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">

            <div class="the-box no-border">
                {!! Form::open(array('url' => route('adtech.core.setting.update'), 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
                <div class="row">
                    <div class="col-sm-8">

                        <label>App Version</label>
                        <div class="form-group">
                            {!! Form::text('app_version', $app_version, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.app_version_here'))) !!}
                        </div>

                        <label>{{ trans('adtech-core::labels.setting.title_page') }}</label>
                        <div class="form-group">
                            {!! Form::text('title', $title, array('class' => 'form-control', 'autofocus'=>'autofocus', 'placeholder'=> trans('adtech-core::common.setting.title_here'))) !!}
                        </div>

                        <label>Slogan</label>
                        <div class="form-group">
                            {!! Form::text('slogan', $slogan, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.slogan_here'))) !!}
                        </div>

                        <label>Logo</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="logo" value="{{ $logo }}">
                        </div>
                        <img id="holder" src="{{ config('site.url_storage') . $logo }}" style="margin-top:15px;max-height:100px;">
                        <br><br>

                        <label>Logo mini</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail2" class="form-control" type="text" name="logo_mini" value="{{ $logo_mini }}">
                        </div>
                        <img id="holder2" src="{{ config('site.url_storage') . $logo_mini }}" style="margin-top:15px;max-height:100px;">
                        <br><br>

                        <label>Favicon</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail1" class="form-control" type="text" name="favicon" value="{{ $favicon }}">
                        </div>
                        <img id="holder1" src="{{ config('site.url_storage') . $favicon }}" style="margin-top:15px;max-height:100px;">
                        <br><br>

                        {{--<label>Logo link</label>--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::text('logo_link', $logo_link, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.logo_link_here'))) !!}--}}
                        {{--</div>--}}

                        {{--<label>Company Name</label>--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::text('company_name', $company_name, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.company_name_here'))) !!}--}}
                        {{--</div>--}}

                        {{--<label>Address</label>--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::text('address', $address, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.address_here'))) !!}--}}
                        {{--</div>--}}

                        {{--<label>Email</label>--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::text('email', $email, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.email_here'))) !!}--}}
                        {{--</div>--}}

                        {{--<label>Phone number</label>--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::text('phone', $phone, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.phone_here'))) !!}--}}
                        {{--</div>--}}

                        {{--<label>Hotline</label>--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::text('hotline', $hotline, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.hotline_here'))) !!}--}}
                        {{--</div>--}}

                        {{--<label>GA Code</label>--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::textarea('ga_code', $ga_code, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.ga_code_here'))) !!}--}}
                        {{--</div>--}}

                        {{--<label>Chat Code</label>--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::textarea('chat_code', $chat_code, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.chat_code_here'))) !!}--}}
                        {{--</div>--}}


                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <label for="blog_category" class="">Actions</label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('adtech.core.setting.manage') !!}"
                               class="btn btn-danger">{{ trans('adtech-core::buttons.discard') }}</a>
                        </div>
                    </div>
                    <!-- /.col-sm-4 --> </div>
                <!-- /.row -->
                {!! Form::close() !!}
            </div>
            @if ( $errors->any() )
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ config('site.url_static') . ('/vendor/laravel-filemanager/js/lfm.js?t=' . time()) }}" ></script>
    <script>
        $(function () {
            // var domain = "http://dhcd-release.vnedutech.vn/administrator/laravel-filemanager";
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $('#lfm2').filemanager('image');
        })
    </script>
@stop
