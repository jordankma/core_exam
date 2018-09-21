@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-member::language.titles.member.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}">
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
            <form role="form" action="{{route("vne.member.member.add")}}" method="post" enctype="multipart/form-data" id="form-add-member">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="the-box no-border">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class=" nav-item active">
                            <a href="#info-required" data-toggle="tab" class="nav-link">Thông tin chính</a>
                        </li>
                        <li class="nav-item">
                            <a href="#info" data-toggle="tab" class="nav-link">Thông tin thêm</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="slim1" style="margin-top: 20px">
                        <div class="tab-pane active" id="info-required">
                            <div class="row">
                                <!-- /.col-sm-8 -->
                                <div class="col-sm-6">  
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.name') }} <span style="color: red">(*)</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.doan') }} <span style="color: red">(*)</span></label><br>
                                        <select id="group" class="form-control" name="group_id[]" multiple="multiple" placeholder="{{trans('vne-member::language.placeholder.member.doan_select')}}">
                                            @if(!empty($list_group))
                                                @foreach($list_group as $group)
                                                    <option value="{{$group->group_id}}" >{{$group->name}}</option>     
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <label>{{trans('vne-member::language.form.title.avatar') }}</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text"  name="avatar">
                                        <img src="" id="holder" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>{{trans('vne-member::language.form.title.position_current') }}</label>
                                    <div class="form-group">
                                        <input type="text" name="position_current" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.position_current')}}">
                                    </div>
                                    <label>{{trans('vne-member::language.form.title.position') }}</label>
                                    <div class="form-group">
                                        <select class="form-control select2" id="position_select" name="position_id" placeholder="{{trans('vne-member::language.placeholder.member.position_select')}}">
                                            <option value="0">Chọn chức vụ</option> 
                                            @if(!empty($list_position))
                                                @foreach($list_position as $position)
                                                    <option value="{{$position->position_id}}">{{$position->name}}</option>     
                                                @endforeach
                                            @endif                
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label> {{trans('vne-member::language.form.title.email') }} </label>
                                        <input type="text" name="email" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.email')}}">
                                    </div>
                                    <div class="form-group">
                                        <label> {{trans('vne-member::language.form.title.phone') }} </label>
                                        <input type="text" name="phone" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.phone')}}">
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="info">
                            <div class="row">
                                <!-- /.col-sm-8 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.address') }}</label>
                                        <textarea class="form-control" name="address" placeholder="{{trans('vne-member::language.placeholder.member.address')}}"></textarea>
                                    </div>
                                    <label>{{trans('vne-member::language.form.title.gender') }}</label>
                                    <div class="form-group">
                                        <label class="radio-inline" for="female">
                                        <input type="radio" id="female" name="gender" value="female" checked="checked">
                                        Female</label>
                                        <label class="radio-inline" for="male"> 
                                        <input type="radio" id="male" name="gender" value="male" >
                                        Male</label>
                                    </div>
                                    <label>{{trans('vne-member::language.form.title.trinh_do_ly_luan') }}</label>
                                    <div class="form-group input-group">
                                        <input type="text" name="trinh_do_ly_luan" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.trinh_do_ly_luan_text')}}" id="trinh_do_ly_luan_text" style="display: none" disabled>
                                        <select class="form-control select2" id="trinh_do_ly_luan_select" name="trinh_do_ly_luan" placeholder="{{trans('vne-member::language.placeholder.member.trinh_do_ly_luan_select')}}">
                                            @if(!empty($list_trinh_do_ly_luan))
                                                @foreach($list_trinh_do_ly_luan as $trinh_do_ly_luan)
                                                    <option value="{{$trinh_do_ly_luan->trinh_do_ly_luan}}">{{$trinh_do_ly_luan->trinh_do_ly_luan}}</option>     
                                                @endforeach
                                            @endif                 
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" id="change-type-trinh-do-ly-luan">
                                                <i class="fa fa-random"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <label>{{trans('vne-member::language.form.title.trinh_do_chuyen_mon') }}</label>
                                    <div class="form-group input-group">
                                        <input type="text" name="trinh_do_chuyen_mon" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.trinh_do_chuyen_mon_text')}}" id="trinh_do_chuyen_mon_text" style="display: none" disabled>
                                        <select class="form-control select2" id="trinh_do_chuyen_mon_select" name="trinh_do_chuyen_mon" placeholder="{{trans('vne-member::language.placeholder.member.trinh_do_chuyen_mon_select')}}">
                                            @if(!empty($list_trinh_do_chuyen_mon))
                                                @foreach($list_trinh_do_chuyen_mon as $trinh_do_chuyen_mon)
                                                    <option value="{{$trinh_do_chuyen_mon->trinh_do_chuyen_mon}}">{{$trinh_do_chuyen_mon->trinh_do_chuyen_mon}}</option>     
                                                @endforeach
                                            @endif                 
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" id="change-type-trinh-do-chuyen-mon">
                                                <i class="fa fa-random"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.dan_toc') }}</label>
                                        <input type="text" name="dan_toc" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.dan_toc')}}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.ton_giao') }}</label>
                                        <input type="text" name="ton_giao" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.ton_giao')}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.don_vi') }}</label>
                                        <textarea class="form-control" name="don_vi" placeholder="{{trans('vne-member::language.placeholder.member.don_vi')}}"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.ngay_vao_doan') }}</label>
                                        <input type="text" name="ngay_vao_doan" class="form-control" id="ngay_vao_doan" placeholder="{{trans('vne-member::language.placeholder.member.ngay_vao_doan')}}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.ngay_vao_dang') }}</label>
                                        <input type="text" name="ngay_vao_dang" class="form-control" id="ngay_vao_dang" placeholder="{{trans('vne-member::language.placeholder.member.ngay_vao_dang')}}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.birthday') }}</label>
                                        <input type="text" name="birthday" class="form-control" id="birthday" placeholder="{{trans('vne-member::language.placeholder.member.birthday')}}">
                                    </div>
                                </div>
                                <!-- /.col-sm-8 -->
                            </div>    
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- errors -->
                <div class="form-group">
                    <label for="blog_category" class="">Actions</label>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">{{ trans('vne-member::language.buttons.create') }}</button>
                        <a href="{!! route('vne.member.member.manage') !!}"
                           class="btn btn-danger">{{ trans('vne-member::language.buttons.discard') }}</a>
                    </div>
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
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script>
        $(function () {
            $('#group').multiselect({
                buttonWidth: '100%',
                nonSelectedText: 'Chọn đoàn',
                enableFiltering: true,
                numberDisplayed:100
            });
            var check_lyluan = 0;
            $('body').on('click','#change-type-trinh-do-ly-luan',function(e){
                if (check_lyluan % 2 == 0) {
                    $("#trinh_do_ly_luan_text").css('display', 'block');
                    $('#trinh_do_ly_luan_text').prop('disabled', false);
                    $('#trinh_do_ly_luan_select').prop('disabled', true);
                    $("#trinh_do_ly_luan_select").css('display', 'none');
                } else {
                    $("#trinh_do_ly_luan_text").css('display', 'none');
                    $('#trinh_do_ly_luan_text').prop('disabled', true);
                    $('#trinh_do_ly_luan_select').prop('disabled', false);
                    $("#trinh_do_ly_luan_select").css('display', 'block');
                }
                check_lyluan++;
            });
            var check_chuyenmon = 0;
            $('body').on('click','#change-type-trinh-do-chuyen-mon',function(e){
                if (check_chuyenmon % 2 == 0) {
                    $("#trinh_do_chuyen_mon_text").css('display', 'block');
                    $('#trinh_do_chuyen_mon_text').prop('disabled', false);
                    $('#trinh_do_chuyen_mon_select').prop('disabled', true);
                    $("#trinh_do_chuyen_mon_select").css('display', 'none');
                } else {
                    $("#trinh_do_chuyen_mon_text").css('display', 'none');
                    $('#trinh_do_chuyen_mon_text').prop('disabled', true);
                    $('#trinh_do_chuyen_mon_select').prop('disabled', false);
                    $("#trinh_do_chuyen_mon_select").css('display', 'block');
                }
                check_chuyenmon++;
            });    

            // var domain = "/admin/laravel-filemanager/";
            $('#lfm').filemanager('image');
            $('#form-add-member').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            stringLength: {
                                min: 3,
                                max: 100,
                                message: 'Tên phải từ 3 đến 100 kí tự'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            regexp: {
                                regexp: "(09|01[2|6|8|9])+([0-9]{8})",
                                message: 'Số điện thoại không đúng định dạng'
                            },
                            remote: {
                                // headers: {
                                //     'X-CSRF-TOKEN': $('input[name=_token]').val()//$('meta[name="csrf-token"]').attr('content')
                                // },
                                data: {
                                    '_token': $('meta[name=csrf-token]').prop('content')
                                },
                                type: 'post',
                                message: 'Số điện thoại đã tồn tại',
                                url: '{{route('vne.member.member.check-phone-exist')}}',
                            }
                        }
                    },
                    email: {
                        validators: {
                            emailAddress: {
                                message: 'Email không đúng định dạng'
                            },
                            remote: {
                                // headers: {
                                //     'X-CSRF-TOKEN': $('input[name=_token]').val()//$('meta[name="csrf-token"]').attr('content')
                                // },
                                data: {
                                    '_token': $('meta[name=csrf-token]').prop('content')
                                },
                                type: 'post',
                                message: 'Email đã tồn tại',
                                url: '{{route('vne.member.member.check-email-exist')}}',
                            }
                        }
                    },
                    avatar: {
                        trigger: 'change keyup',
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            }
                        }
                    }
                }
            });   
        })
    </script>
@stop
