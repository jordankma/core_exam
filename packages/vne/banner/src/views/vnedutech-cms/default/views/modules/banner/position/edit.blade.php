@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-banner::language.titles.position.update') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
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
                <form role="form" action="{{route('vne.banner.position.update')}}" method="post" id="form-add-position">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="banner_position_id" value="{{ $position->banner_position_id }}"/>
                <div class="row">
                    <div class="col-sm-4">
                        <label>{{trans('vne-banner::language.label.name') }} <span style="color: red">(*)</span></label>
                        <div class="form-group">
                            <input type="text" name="name" value="{{$position->name}}" class="form-control" placeholder="{{trans('vne-banner::language.placeholder.position.name') }}">
                        </div>
                        <label>{{trans('vne-banner::language.label.width') }} x {{trans('vne-banner::language.label.height') }} <span style="color: red">(*)</span></label>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <input type="nember" min="0" name="width" value="{{$position->width}}"  class="form-control" placeholder="{{trans('vne-banner::language.placeholder.position.width') }}">
                            </div>
                            <div class="col-md-1">
                                x
                            </div>
                            <div class="col-md-5">
                                <input type="number" min="0" name="height" value="{{$position->height}}"  class="form-control" placeholder="{{trans('vne-banner::language.placeholder.position.height') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('vne-banner::language.buttons.update') }}</button>
                                <a href="{!! route('vne.banner.position.manage') !!}"
                                   class="btn btn-danger">{{ trans('vne-banner::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
            var domain = "/admin/laravel-filemanager/";
            $('#lfm').filemanager('image', {prefix: domain});
            $('#close_at').datetimepicker({
                format: 'YYYY-M-D',
            });
            $('#form-add-position').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập tên vị trí'
                            },
                            stringLength: {
                                min: 3,
                                max: 200,
                                message: 'Tên đăng nhập phải ít nhất 3 đến 200 kí tự'
                            }
                        }
                    },
                    width: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập chiều rộng'
                            },
                            integer: {
                                message : 'Trường này phải là số',
                            }
                        }
                    },
                    height: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập chiều cao'
                            }
                        }
                    }
                }
            }); 
        })
    </script>
@stop
