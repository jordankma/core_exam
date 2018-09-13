@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-news::language.titles.page.edit') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/ckeditor/js/ckeditor.js') }}" type="text/javascript"></script>
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
                <form role="form" action="{{route("vne.news.page.update")}}" method="post" enctype="multipart/form-data" id="form-add-news">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="news_id" value="{{ $news->news_id }}"/>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>{{trans('vne-news::language.form.text.title')}} <span style="color: red">(*)</span></label>
                            <input type="text" id="title" name="title" value="{{ $news->title }}" class="form-control" placeholder="{{trans('vne-news::language.form.title_placeholder')}}">
                            <p id="alias" style="color: red"></p>
                        </div>
                        <label>{{trans('vne-news::language.form.text.content')}} </label><br>
                        <div class="form-group">
                            <div class='box-body pad form-group'>
                                <textarea name="content" id="ckeditor" placeholder="{{trans('vne-news::language.form.content_placeholder')}}">{{ $news->content }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <div class="form-group col-xs-12">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('vne-news::language.buttons.update') }}</button>
                                <a href="{!! route('vne.art.demo.create') !!}"
                                   class="btn btn-danger">{{ trans('vne-news::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                </form>
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <!--end of page js-->
    <script>
        $(document).ready(function() {
            var options = {
                filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token=',
            };
            CKEDITOR.replace('ckeditor',options);
        });
    </script>
@stop
