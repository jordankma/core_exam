@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('adtech-core::titles.json.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
@stop
<!--end of page css-->


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                <!-- errors -->
                {!! Form::open(array('url' => route('adtech.core.json.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'jsonForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-8">
                        <label>Json Name</label>
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('adtech-core::common.json.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>

                        <label>Json path</label>
                        <div class="form-group {{ $errors->first('path', 'has-error') }}">
                            {!! Form::text('path', null, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.json.path_here'))) !!}
                            <span class="help-block">{{ $errors->first('path', ':message') }}</span>
                        </div>

                        <div class="form-group">
                            {!! Form::hidden('domain_id', $domain_id) !!}
                        </div>
                    </div>

                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <div class="form-group col-xs-12">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('adtech.core.json.create') !!}"
                                   class="btn btn-danger">{{ trans('adtech-core::buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') . ('/vendor/laravel-filemanager/js/lfm.js?t=' . time()) }}" ></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
            $('#lfm').filemanager('image');
        })
    </script>
@stop
