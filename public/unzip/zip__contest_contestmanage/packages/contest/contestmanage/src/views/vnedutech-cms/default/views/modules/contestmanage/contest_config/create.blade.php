@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_config.create') }}@stop

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
        .float-right{
            float: right;
        }
        .fa-remove{
            cursor: pointer !important;
            color:red;
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
                {!! Form::open(array('url' => route('contest.contestmanage.contest_config.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'configForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Chọn loại cấu hình</label>
                            <div class="form-group {{ $errors->first('type', 'has-error') }}">
                                {!! Form::select('type', $type, null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Tùy chọn cấu hình</label>
                            <div class="form-group {{ $errors->first('option', 'has-error') }}">
                                {!! Form::select('option', $option, null, array('class' => 'form-control option')) !!}
                                <span class="help-block">{{ $errors->first('option', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Chọn môi trường</label>
                            <div class="form-group {{ $errors->first('environment', 'has-error') }}">
                                {!! Form::select('environment', $environment, null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('environment', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="special">

                            </div>
                            <label>Tên cấu hình</label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {!! Form::text('name',null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <div>
                                <label>Trạng thái</label>
                                <div class="form-group">
                                    <input type="checkbox" name="status" class="allow_permission" data-size="mini" checked>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Mô tả</label>
                            <div class="form-group {{ $errors->first('description', 'has-error') }}">
                                {!! Form::textarea('description', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_config.description'))) !!}
                                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <p class="text-on-pannel text-primary"><strong> Cấu hình chung </strong></p>
                                <div id="config_list">

                                </div>
                                <div class="form-group">
                                    <div id="btn_container">
                                        <a href="javascript:void(0)" class="btn btn-default" id="add_group_config"><span class="glyphicon glyphicon-plus-sign"></span> Thêm nhóm cấu hình</a>
                                    </div>
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">
                        <div class="form-group col-xs-12">

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('contest.contestmanage.contest_config.create') !!}"
                                   class="btn btn-danger">{{ trans('contest-contestmanage::language.buttons.discard') }}</a>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/clockface/js/clockface.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/pages/datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/ckeditor/js/ckeditor.js') }}"></script>

    <script>
    (function( $ ) {

        $.fn.filemanager = function (type, options) {
            type = type || 'file';

            //                this.on('click', function(e) {
            $('body').on('click', '.lfm', function (e) {

                var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';

                localStorage.setItem('target_input', $(this).data('input'));
                localStorage.setItem('target_preview', $(this).data('preview'));
                localStorage.setItem('target_id', $(this).attr('c-data'));

                window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
                window.SetUrl = function (url, file_path) {
                    //set the value of the desired input to image url
                    var target_input = $('#' + localStorage.getItem('target_id')).find('.' + localStorage.getItem('target_input'));
                    console.log(target_input);
                    target_input.val(file_path).trigger('change');

                    //set or change the preview image src
                    var target_preview = $('#' + localStorage.getItem('target_id')).find('.' + localStorage.getItem('target_preview'));
                    target_preview.attr('src', url).trigger('change');
                };
                return false;
            });
        }
    })(jQuery);

    var domain = "/admin/laravel-filemanager";
    $('.lfm').filemanager('file', {prefix: domain});
    $("#start_date").datetimepicker({
        format: 'DD-MM-YYYY HH:mm'
    });
    $("#end_date").datetimepicker({
        format: 'DD-MM-YYYY HH:mm'
    });
    $("[name='permission_locked']").bootstrapSwitch();
        $('input[type="checkbox"].allow_permission').bootstrapSwitch({
            onSwitchChange:function(event, state) {
            }
        });
        function genGroup(group_name, group_varible) {
            return '<div class="panel panel-default" id="' + group_varible + '">' +
                '<div class="panel-heading border-light">' +
                '<h4 class="panel-title">' + group_name + '</h4>' +
            '<span class="float-right">' +
                '<a class="group_remove" c-data="' + group_varible + '"><i class="fa fa-remove"></i></a>' +
                '</span>' +
                '</div>' +
                '<div class="panel-body">' +
                '<div class="config_container"></div>' +
                '<div class="group_btn_container">' +
                '<a href="javascript:void(0)" class="btn btn-default add_config" c-data="' + group_varible + '"> <span class="glyphicon glyphicon-cog"></span> Thêm cấu hình</a>' +
                '</div>' +
            '</div></div>';
        }
        function genConfig(config_idx, group_varible) {
            return '<div class="form-group" c-data="' + config_idx + '">' +
                '<div class="col-md-2"><label>Tên biến</label>' +
                '<input type="text" class="form-control" name="config[' + group_varible + '][varible][]">' +
                '</div>' +
                '<div class="col-md-2"><label>Chọn loại config</label>' +
                '<select class="form-control config_type" c-data="' + group_varible + '" name="config[' + group_varible + '][type][]">' +
                '<option value="text">Text</option>' +
                '<option value="file">File</option>' +
                '</select></div>' +
                '<div class="col-md-7 value"><label>Giá trị</label><input type="text" class="form-control" name="config[' + group_varible + '][value][]"></div> ' +
                '<a href="javascript:void(0)" class="config_remove"><i class="fa fa-remove"></i></a>' +
                '</div>';
        }
        function genBtnAddGroup() {
            return '<div class="form-group">' +
                '<div class="col-md-4"><input type="text" class="form-control" name="group_name" placeholder="' + '{{ trans('contest-contestmanage::language.placeholder.contest_config.group_name') }}' +'"></div>' +
                '<div class="col-md-4"><input type="text" class="form-control" name="group_varible" placeholder="' + '{{ trans('contest-contestmanage::language.placeholder.contest_config.group_varible') }}' +'"></div>' +
                '<div class="col-md-4"><button type="button" class="btn btn-primary" id="create_group">Thêm</div>' +
                '</div>';
        }
        var c_idx = 1;
        $('body').on('click','#add_group_config',function () {
            $('#btn_container').html('');
            $('#btn_container').html(genBtnAddGroup());

        });
        $('body').on('click','#create_group',function () {
           var group_name = $('input[name="group_name"]').val();
           var group_varible= $('input[name="group_varible"]').val();
           var html = genGroup(group_name, group_varible);
           $('#config_list').append(html);
            $('#btn_container').html('');
            $('#btn_container').html('<a href="javascript:void(0)" class="btn btn-default" id="add_group_config"><span class="glyphicon glyphicon-plus-sign"></span> Thêm nhóm cấu hình</a>');
        });
        $('body').on('click','.group_remove',function () {
           var id = $(this).attr('c-data');
           $('#' + id).remove();
        });
        $('body').on('click','.add_config',function () {
            $(this).parent().parent().find('.config_container').append(genConfig(c_idx++,$(this).attr('c-data')));
        });
        $('body').on('change','.config_type',function () {
            var group = $(this).attr('c-data');
            var html = '';
           if($('option:selected',this).val() == 'text'){
               html =  '<label>Giá trị</label><input type="text" class="form-control" name="' + group + '[value][]"></div>';
           }
           else{
               html = '<div class="col-md-2">' +
                   '<img class="holder" style="margin-top:15px;max-height:30px;"></div>' +
                   '<div class="col-md-10">' +
                   '<label>Chọn file</label><div class="input-group">' +
                   '<span class="input-group-btn"> ' +
                   '<a data-input="thumbnail" data-preview="holder" c-data="' + group + '" class="btn btn-primary lfm"> ' +
                   '<i class="fa fa-picture-o"></i> Choose ' +
                   '</a> ' +
                   '</span> ' +
                   '<input class="form-control thumbnail" type="text" name="config[' + group + '][value][]">' +
                   '</div>' +
                   '</div>';
           }
            $(this).parent().parent().find('.value').html();
            $(this).parent().parent().find('.value').html(html);
        });
        $('body').on('change','.option',function () {
            var option = $('option:selected', this).val();
            if(option == 'special'){
                var html = '<label>Ngày bắt đầu áp dụng:</label>' +
                    '<div class="input-group"> ' +
                        '<span class="input-group-addon"> ' +
                        '<span class="glyphicon glyphicon-calendar"></span> ' +
                        '</span> <input type="text" name="start_date" class="form-control" id="start_date"/> ' +
                    '</div>' +
                    '<label>Ngày kết thúc:</label>' +
                    '<div class="input-group"> ' +
                        '<span class="input-group-addon"> ' +
                        '<span class="glyphicon glyphicon-calendar"></span> ' +
                        '</span> <input type="text" name="end_date" class="form-control" id="end_date"/> ' +
                    '</div>';
                $('#special').html('');
                $('#special').html(html);
            }
            else{
                $('#special').html('');
            }

        });
        $('body').on('change',function () {
            $("#start_date").datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });
            $("#end_date").datetimepicker({
                format: 'DD-MM-YYYY HH:mm'
            });
        });
        $( document ).ajaxComplete(function( event, xhr, settings ) {
            $('.lfm').filemanager('image', {prefix: domain});
        });
    </script>
@stop
