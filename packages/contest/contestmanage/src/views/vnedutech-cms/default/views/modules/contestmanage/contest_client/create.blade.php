@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_client.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .text-on-pannel {
            background: #fff none repeat scroll 0 0;
            height: auto;
            margin-left: 20px;
            padding: 3px 5px;
            position: absolute;
            margin-top: -47px;
            /*border: 1px solid #337ab7;*/
            /*border-radius: 8px;*/
        }

        .panel {
            /* for text on pannel */
            margin-top: 27px !important;
        }

        .panel-body {
            padding-top: 30px !important;
        }
        .form-group{
            overflow: hidden;
        }
    </style>
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
            <div class="panel panel-primary" id="hidepanel1">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{$title}}
                    </h3>

                </div>
                <div class="panel-body ">
                <!-- errors -->
                {!! Form::open(array('url' => route('contest.contestmanage.contest_client.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'examForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tên client</label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.name_here'))) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <label>Môi trường</label>
                            <div class="form-group {{ $errors->first('environment', 'has-error') }}">
                                {!! Form::text('environment', null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('environment', ':message') }}</span>
                            </div>
                            <label>Mô tả</label>
                            <div class="form-group {{ $errors->first('description', 'has-error') }}">
                                {!! Form::textarea('description', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.description'))) !!}
                                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                            </div>
                            <label>Kích thước iframe</label>
                            <div class="form-group">
                                <div class="col-md-6 {{ $errors->first('width', 'has-error') }}">
                                    {!! Form::number('width', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.width'))) !!}
                                    <span class="help-block">{{ $errors->first('width', ':message') }}</span>
                                </div>
                                <div class="col-md-6 {{ $errors->first('height', 'has-error') }}">
                                    {!! Form::number('height', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.height'))) !!}
                                    <span class="help-block">{{ $errors->first('height', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Resource (*.zip)</label>
                            <div class="form-group">
                                {!! Form::file('resource') !!}
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <p class="text-on-pannel text-primary"><strong> Cài đặt biến </strong></p>
                                    <div id="config_list">

                                    </div>
                                    <a href="javascript:void(0)" class="btn btn-default" id="more_config"><span class="glyphicon glyphicon-plus-sign"></span> Thêm biến</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                            <a href="{!! route('contest.contestmanage.contest_client.create') !!}"
                               class="btn btn-danger">{{ trans('contest-contestmanage::language.buttons.discard') }}</a>
                        </div>
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="modal fade in" id="config_list" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title mr-auto">Chọn cấu hình</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                    </div>
                </div>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <!--end of page js-->
    <script>

        $("[name='permission_locked']").bootstrapSwitch();
        $('input[type="checkbox"].allow_permission').bootstrapSwitch({
            onSwitchChange:function(event, state) {
            }
        });
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
        $(document).on('click', '.remove_config' ,function() {
            $(this).parent().remove();
        });
        $(document).on('click', '#more_config' ,function() {
            var idx = $('#config_list').find('.form-group').length;
            idx++;
            var html =
                '<div class="form-group" id="config-' + idx + '"> ' +
                '<div class="col-md-4">' +
                '{!! Form::text('config[name][]',null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.config_name'))) !!}' +
                '</div>' +
                '<div class="col-md-3">' +
                '{!! Form::text('config[id][]', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.config_id'))) !!}' +
                '</div>' +
                '<div class="col-md-4">' +
                '{!! Form::text('config[value][]', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.config_value'))) !!}' +
                '</div>' +
                '<a href="javascript:void(0)" class="remove_config"><span class="glyphicon glyphicon-remove" style="color: red"></span></a>'+
                '</div>';
            $('#config_list').append(html);
        });
    </script>
@stop
