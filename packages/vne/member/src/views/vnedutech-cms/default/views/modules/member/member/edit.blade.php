@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-member::language.titles.member.update') }}@stop

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
            <form role="form" action="{{route("vne.member.member.update")}}" method="post" enctype="multipart/form-data" id="form-add-member">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="hidden" name="member_id" value="{{ $member->member_id }}"/>
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
                                        <input type="text" name="name" value="{{ $member->name }}" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.name')}}">
                                    </div>
                                    <label>{{trans('vne-member::language.form.title.gender') }}</label>
                                    <div class="form-group">
                                        <label class="radio-inline" for="female">
                                        <input type="radio" id="female" name="gender" value="female" @if($member->gender=="female") checked="checked" @endif>
                                        Female</label>
                                        <label class="radio-inline" for="male"> 
                                        <input type="radio" id="male" name="gender" value="male" @if($member->gender=="male") checked="checked" @endif>
                                        Male</label>
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.u_name') }} <span style="color: red">(*)</span></label>
                                        <input type="text" name="u_name" value="{{ $member->u_name }}" class="form-control" placeholder="{{trans('vne-member::language.placeholder.member.u_name')}}" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="change_pass" value="0" id="change-pass">
                                        <label for="change-pass"> Tích vào đây để đổi mật khẩu </label>
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.password') }} <span style="color: red">(*)</span></label>
                                        <input type="password" name="password" value="{{ $member->password }}" class="form-control password" placeholder="{{trans('vne-member::language.placeholder.member.password')}}" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.conf_password') }} <span style="color: red">(*)</span></label>
                                        <input type="password" name="conf_password" value="{{ $member->password }}" class="form-control password" placeholder="{{trans('vne-member::language.placeholder.member.conf_password')}}" disabled="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.birthday') }}</label>
                                        <select class="date" name="day">
                                            <option value="0"></option>
                                            @for($i = 1; $i < 32; $i++)
                                                <option value="{{$i}}" @if($birthday[0]==$i) selected="" @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                        <span>/</span>
                                        <select class="date" name="month">
                                            <option value="0"></option>
                                            @for($i = 1; $i < 13; $i++)
                                                <option value="{{$i}}" @if($birthday[1]==$i) selected="" @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                        <span>/</span>
                                        <select class="date year" name="year">
                                            <option value="0"></option>
                                            @for($i = 1950; $i < 2018; $i++)
                                                <option value="{{$i}}" @if($birthday[2]==$i) selected="" @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <label>{{trans('vne-member::language.form.title.avatar') }} <span style="color: red">(*)</span> </label>
                                    <div class="form-group input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" value="{{ $member->avatar }}" type="text" name="avatar">
                                    </div>
                                    <img src="{{ $member->avatar }}" id="holder" style="margin-top:15px;max-height:100px;">
                                    <div class="form-group">
                                        <label> {{trans('vne-member::language.form.title.email') }} </label>
                                        <input type="text" name="email" class="form-control" value="{{ $member->email }}" placeholder="{{trans('vne-member::language.placeholder.member.email')}}" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label> {{trans('vne-member::language.form.title.phone') }} </label>
                                        <input type="text" name="phone" class="form-control" value="{{ $member->phone }}" placeholder="{{trans('vne-member::language.placeholder.member.phone')}}" disabled="">
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="info">
                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.object') }} </label><br>
                                        <select id="object" class="form-control" name="object_id" placeholder="{{trans('vne-member::language.placeholder.member.object')}}">
                                            @if(!empty($list_object))
                                                @foreach($list_object as $object)
                                                    <option value="{{$object->object_id}}" @if($object->object_id == $member->object_id) selected="" @endif >{{$object->name}}</option>     
                                                @endforeach
                                            @endif
                                        </select>
                                    </div> 
                                </div> --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.table') }} </label><br>
                                        <select id="table" class="form-control" name="table_id">
                                            <option value="0" >Chọn bảng</option>
                                            @if(!empty($list_table))
                                                @foreach($list_table as $table)
                                                    <option value="{{$table->table_id}}" @if($table->table_id == $member->table_id) selected="" @endif>{{$table->name}}</option>     
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>    
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.city') }} </label><br>
                                        <select id="city" class="form-control" name="city_id" >
                                            <option value="0" >Chọn thành phố</option>
                                            @if(!empty($list_city))
                                                @foreach($list_city as $city)
                                                    <option value="{{$city->city_id}}" @if($city->city_id == $member->city_id) selected="" @endif>{{$city->name}}</option>     
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.district') }} </label><br>
                                        <select id="district" class="form-control" name="district_id">
                                            <option value="0" >Chọn quận huyện</option>
                                            @if(!empty($list_district))
                                                @foreach($list_district as $district)
                                                    <option value="{{$district->district_id}}" @if($district->district_id == $member->district_id) selected="" @endif>{{$district->name}}</option>     
                                                @endforeach
                                            @endif   
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 banga">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.school') }} </label><br>
                                        <select id="school" class="form-control" name="school_id">
                                            <option value="0" >Chọn trường</option>
                                            @if(!empty($list_school))
                                                @foreach($list_school as $school)
                                                    <option value="{{$school->school_id}}" @if($school->school_id == $member->school_id) selected="" @endif>{{$school->name}}</option>     
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 banga">
                                    <div class="form-group">
                                        <label>{{trans('vne-member::language.form.title.class') }} </label><br>
                                        <input type="text" name="class_id" value="{{ $member->class_id }}" class="form-control" id="classes" placeholder="Lớp">
                                    </div>
                                </div>
                                <div class="col-sm-3 bangb">
                                    <div class="form-group">
                                        <label>Đơn vị</label>
                                        <div class="input">
                                            <input class="form-control" name="don_vi" id="don_vi" value="{{ $member->don_vi }}" type="name">
                                        </div>
                                    </div>
                                </div>
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
                        <button type="submit" class="btn btn-success">{{ trans('vne-member::language.buttons.update') }}</button>
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
            $("body").on('click', '#change-pass', function () {
                var change_pass = $('input[name=change_pass]').val();
                console.log(change_pass);
                if(change_pass==1){
                    $('.password').attr('disabled',"");
                    $('input[name=change_pass]').val(0);    
                } else {
                    $('.password').removeAttr('disabled');
                    $('input[name=change_pass]').val(1);
                }
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
                    u_name: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            regexp: {
                                regexp: '^[a-zA-Z0-9_]+$',
                                message: 'Username chỉ gồm số hoặc chữ'
                            },
                            stringLength: {
                                min: 3,
                                max: 100,
                                message: 'Tên đăng nhập phải từ 3 đến 100 kí tự'
                            },
                            remote: {
                                // headers: {
                                //     'X-CSRF-TOKEN': $('input[name=_token]').val()//$('meta[name="csrf-token"]').attr('content')
                                // },
                                data: {
                                    '_token': $('meta[name=csrf-token]').prop('content')
                                },
                                type: 'post',
                                message: 'Tên đăng nhập đã tồn tại',
                                url: '{{route('vne.member.member.check-username-exist')}}',
                            }
                        }
                    },
                    phone: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        },
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
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
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
                    // avatar: {
                    //     trigger: 'change keyup',
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Trường này không được bỏ trống'
                    //         }
                    //     }
                    // },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            regexp: {
                                regexp: "^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[#$^+=!*()@%&]).{8,}$",
                                message: 'Mật khẩu phải chứa 8 ký tự : chứa ít nhất 1 số, 1 chữ viết hoa, 1 chữ viết thường, 1 ký tự đặc biệt'
                            }
                        }
                    },
                    conf_password: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            },
                            identical: {
                                field: 'password',
                                message: 'Mật khẩu không khớp nhau'
                            }
                        }
                    }
                }
            });  
            
            $('#birthday').datetimepicker({
                format: 'YYYY-MM-DD'
            }); 

            $('#table').select2({ 
                placeholder: "Chọn bảng",
                width: '100%',
                dropdownAutoWidth: true,
                theme: "bootstrap"
            });
            $('#city').select2({ 
                placeholder: "Chọn thành phố",
                width: '100%',
                dropdownAutoWidth: true,
                theme: "bootstrap"
            });
            $('#object').select2({ 
                placeholder: "Select a state",
                width: '100%',
                dropdownAutoWidth: true,
                theme: "bootstrap"
            });

            $("body").on('change', '#city', function () {
                var city_id = $(this).val();
                $.ajax({
                    url: "{{ route('vne.member.member.get.district') }}",
                    type: 'GET',
                    cache: false,
                    data: {
                        'city_id': city_id
                    },
                    success: function (data, status) {
                        var data = JSON.parse(data);
                        var str = '<option value="0" >Chọn quận huyện</option>';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i].district_id + '" >' + data[i].name + '</option>';
                        }   
                        $('#district').html('');
                        $('#district').append(str);
                        $('#district').select2({
                            width: '100%',
                            dropdownAutoWidth: true,
                            theme: "bootstrap"
                        }); 
                    }
                }, 'json');
            });

            $("body").on('change', '#district', function () {
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('vne.member.member.get.school') }}",
                    type: 'GET',
                    cache: false,
                    data: {
                        'district_id': district_id
                    },
                    success: function (data, status) {
                        var data = JSON.parse(data);
                        var str = '<option value="0" >Chọn trường</option>';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i].school_id + '" >' + data[i].name + '</option>';
                        }   
                        $('#school').html('');
                        $('#school').append(str);
                        $('#school').select2({
                            width: '100%',
                            dropdownAutoWidth: true,
                            theme: "bootstrap"
                        }); 
                    }
                }, 'json');
            });

            $("body").on('change', '#school', function () {
                var school_id = $(this).val();
                $.ajax({
                    url: "{{ route('vne.member.member.get.class') }}",
                    type: 'GET',
                    cache: false,
                    data: {
                        'school_id': school_id
                    },
                    success: function (data, status) {
                        var data = JSON.parse(data);
                        var str = '<option value="0" >Chọn lớp</option>';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i].class_id + '" >' + data[i].name + '</option>';
                        }   
                        $('#class').html('');
                        $('#class').append(str);
                        $('#class').select2({
                            width: '100%',
                            dropdownAutoWidth: true,
                            theme: "bootstrap"
                        }); 
                    }
                }, 'json');
            });
            var table_id = {{$table_id}};
            if(table_id==1){
                $('.banga').show();
                $('.bangb').hide();
                $('#school').removeAttr("disabled", "");
            } 
            else if(table_id==2) {
                $('.bangb').show();
                $('.banga').hide();
                $('#school').attr("disabled", "");
            }

            $("body").on('change', '#table', function () {
                var table_id = $(this).val();
                var table_name = $("#table option:selected").text();
                $('input[name=table_name]').val(table_name);
                if(table_id==1){
                    $('.banga').show();
                    $('.bangb').hide();
                    $('#school').removeAttr("disabled", "");
                } 
                else if(table_id==2) {
                    $('.bangb').show();
                    $('.banga').hide();
                    $('#school').attr("disabled", "");
                }
            });
        })
    </script>
@stop
