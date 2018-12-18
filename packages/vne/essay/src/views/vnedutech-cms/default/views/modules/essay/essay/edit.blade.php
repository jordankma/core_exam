@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-essay::language.titles.essay.update') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css' }}" rel="stylesheet" type="text/css">
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
                <form action="{{ route('vne.essay.essay.update') }}" method="post" enctype="multipart/form-data" id="form-add-essay">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="essay_id" value="{{ $essay->essay_id }}"/>
                    <div class="row">
                        <div class="col-sm-8">
                            <label> {{ trans('vne-essay::language.label.essay.name') }} </label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <input type="text" name="name" class="form-control" value="{{ $essay->name }}" placeholder="{{ trans('vne-essay::language.placeholder.essay.name_here') }}">
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('vne-essay::language.label.essay.upload_icon') }}</label>  
                                <input type="file" value="" name="image" id="imageUpload">
                                <img src="{{ $essay->image }}">
                            </div>
                            <div class="form-group">
                                <textarea name="note" class="form-control" rows="7">{{ $essay->note }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('vne-essay::language.label.essay.upload_essay') }}</label>    
                                <input type="file" value="" name="fileToUpload" id="fileToUpload">
                            </div>
                        </div>
                        <!-- /.col-sm-8 -->
                        <div class="col-sm-4">
                            <div class="form-group col-xs-12">
                                <label for="blog_category" class="">Actions</label>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">{{ trans('vne-essay::language.buttons.update') }}</button>
                                    <a href="{{ route('vne.essay.essay.manage') }}" class="btn btn-danger">{{ trans('vne-essay::language.buttons.discard') }}</a>
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
    <script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js' }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js' }}" type="text/javascript"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        })
        $(document).ready(function () {
            $('#form-add-essay').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập tên tên'
                            },
                            stringLength: {
                                max: 150,
                                message: 'Tên không được quá dài'
                            }
                        }
                    },
                    // image: {
                    //     validators: {
                    //         file: {
                    //             extension: 'png,jpg',
                    //             message: 'Chọn sai định dạng ảnh'
                    //         }
                    //     }
                    // },
                    // fileToUpload: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Bạn chưa chọn bài thi để tải lên'
                    //         },
                    //         file: {
                    //             extension: 'pdf,pptx,txt,docx',
                    //             message: 'Chọn sai định dạng file'
                    //         }
                    //     }
                    // },
                }
            }); 
        });
    </script>
@stop
