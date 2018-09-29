@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_round.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
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
                {!! Form::open(array('url' => route('contest.contestmanage.contest_round.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'examForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tên vòng thi</label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_round.name_here'))) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <label>Thứ tự vòng thi</label>
                            <div class="form-group {{ $errors->first('order', 'has-error') }}">
                                {!! Form::number('order', null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('order', ':message') }}</span>
                            </div>
                            <label>Cấu hình</label>
                            <div class="form-group" id="config_container">
                                <div class="form-group" id="config-1">
                                    <div class="col-md-4">
                                        {!! Form::select('environment[]', $environment,null, array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-md-7">
                                        {!! Form::text('config_name[]', null, array('class' => 'form-control config', 'readOnly' => 'readOnly', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_season.config'))) !!}
                                    </div>
                                    {!! Form::hidden('config_id[]', null, array('class' => 'config_id')) !!}
                                    <a href="javascript:void(0)" class="remove_config"><span class="glyphicon glyphicon-remove" style="color: red"></span></a>

                                </div>
                            </div>
                            <p>
                                <button class="btn btn-default" type="button" id="more_config"><span class="glyphicon glyphicon-plus"></span> Thêm cấu hình</button>
                            </p>
                            <label>Mô tả</label>
                            <div class="form-group {{ $errors->first('description', 'has-error') }}">
                                {!! Form::textarea('description', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_round.description'))) !!}
                                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Loại vòng thi</label>
                            <div class="form-group {{ $errors->first('type', 'has-error') }}">
                                {!! Form::select('type', $type,null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                            </div>
                            <label>Ngày bắt đầu:</label>
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true"></i>
                            </span>
                                <input type="text" name="start_date" class="form-control" id="start_date"/>
                            </div>
                            <label>Ngày kết thúc:</label>
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true"></i>
                            </span>
                                <input type="text" name="end_date" class="form-control" id="end_date"/>
                            </div>
                            <label>Thông báo sau ngày kết thúc</label>
                            <div class="form-group {{ $errors->first('end_notify', 'has-error') }}">
                                {!! Form::textarea('end_notify', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_round.after_end_notify'))) !!}
                                <span class="help-block">{{ $errors->first('end_notify', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label>Thể lệ</label>
                        <div class="form-group {{ $errors->first('rules', 'has-error') }}">
                            {!! Form::textarea('rules', null, array('class' => 'form-control', 'id' => 'ckeditor_full','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_round.rules'))) !!}
                            <span class="help-block">{{ $errors->first('rules', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                            <a href="{!! route('contest.contestmanage.contest_round.create') !!}"
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
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/clockface/js/clockface.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/ckeditor/js/ckeditor.js') }}"></script>
    <!--end of page js-->
    <script>
        CKEDITOR.replace( 'ckeditor_full' );
        $("#start_date").datetimepicker({
            format: 'DD-MM-YYYY HH:mm'
        });
        $("#end_date").datetimepicker({
            format: 'DD-MM-YYYY HH:mm'
        });
        $('body').on('click','.config', function () {
            var id = $(this).parent().parent().attr('id');
            var href = '{!! route('contest.contestmanage.contest_config.list_data') !!}';
            $.post(href, {type: 'round'}, function (res) {
                if(res) {
                    $('#config_list .modal-body').html();
                    $('#config_list .modal-body').html(res);
                    $('#config_list').attr('c-data',id);
                    $('#config_list').modal();
                }
            });
        });
        $(document).on('click', '.choose' ,function() {
            var id = '#' +   $('#config_list').attr('c-data');
            var config_id = $(this).attr('c-data');
            var config_name = $(this).attr('d-data');
            $(id).find('.config_id').val(config_id);
            $(id).find('.config').val(config_name);
            $('#config_list').modal('hide');
        });
        $(document).on('click', '.remove_config' ,function() {
            $(this).parent().remove();
        });
        $(document).on('click', '#more_config' ,function() {
            var idx = $('#config_container').find('.form-group').length;
            idx++;
            var html =
                '<div class="form-group" id="config-' + idx + '"> ' +
                '<div class="col-md-4">' +
                '{!! Form::select('environment[]', $environment,null, array('class' => 'form-control')) !!}' +
                '</div>' +
                '<div class="col-md-7">' +
                '{!! Form::text('config_name[]', null, array('class' => 'form-control config', 'readOnly' => 'readOnly', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_season.config'))) !!}' +
                '</div>' +
                ' {!! Form::hidden('config_id[]', null, array('class' => 'config_id')) !!}' +
                '<a href="javascript:void(0)" class="remove_config"><span class="glyphicon glyphicon-remove" style="color: red"></span></a>'+
                '</div>';
            $('#config_container').append(html);
        });
        $("[name='permission_locked']").bootstrapSwitch();
        $('input[type="checkbox"].allow_permission').bootstrapSwitch({
            onSwitchChange:function(event, state) {
            }
        });
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
    </script>
@stop
