@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = 'Cập nhật thông tin' }}@stop
@section('header_styles')
	<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
@stop
@section('content')
<!-- main -->
		<main class="main">

			<section class="section registration">
				<div class="container">
					<div class="inner">
						<form action="{{ route('vne.memberfrontend.update') }}" method="post" id="form-update-info"> 
							<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            				<input type="hidden" name="member_id" value="{{ $member->member_id }}"/>
							<div class="form-group">
								<label>Họ tên</label>
								<div class="input">
									<input class="form-control" name="name" value="{{$member->name}}" type="name" >
									<small class="form-text">(Chú ý: Họ tên phải là tiếng Việt có dấu, không viết liền, không chứa ký tự đặc biệt)</small>
									<small class="text-muted">*</small>
								</div>
							</div>
							<div class="form-group">
								<label>Giới tính</label>
								<div class="input">
									<div class="item">
										<input class="form-check-input" name="gender" type="radio" name="exampleRadios" id="exampleRadios1" value="male" @if($member->gender=="male") checked="checked" @endif>
										<label class="form-check-label" for="exampleRadios1">Nam</label>
									</div>
									<div class="item">
										<input class="form-check-input" name="gender" type="radio" name="exampleRadios" id="exampleRadios2" value="female" @if($member->gender=="female") checked="checked" @endif>
										<label class="form-check-label" for="exampleRadios2">Nữ</label>
									</div>
								    <small class="text-muted">*</small>
                                </div>
							</div>
							<div class="form-group">
                                <label>Ngày sinh</label>
                                <div class="input">
                                    <select class="form-control date" name="day">
                                        <option value="0"></option>
                                        @for($i = 1; $i < 32; $i++)
                                            <option value="{{$i}}" @if($birthday[0]==$i) selected="" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <span>/</span>
                                    <select class="form-control date" name="month">
                                        <option value="0"></option>
                                        @for($i = 1; $i < 13; $i++)
                                            <option value="{{$i}}" @if($birthday[1]==$i) selected="" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <span>/</span>
                                    <select class="form-control date year" name="year">
                                        <option value="0"></option>
                                        @for($i = 1950; $i < 2018; $i++)
                                            <option value="{{$i}}" @if($birthday[2]==$i) selected="" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <small class="text-muted">*</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Điện thoại</label>
                                <div class="input">
                                    <input class="form-control" type="text" name="phone" value="{{ $member->phone }}" disabled="">
                                    <small class="text-muted">*</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Bạn thuộc bảng</label>
                                <div class="input">
                                    <select class="form-control" id="table" name="table_id" required="">
                                        <option></option>
                                        @if(!empty($list_table))
                                            @foreach($list_table as $table)
                                                <option value="{{$table->table_id}}" @if($table->table_id == $member->table_id) selected="" @endif >{{$table->name}}</option>     
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="form-text">
                                        - Bảng A: Dành cho thí sinh là học sinh đang theo học tại các trường trung học phổ thông, học viên các trung tâm giáo dục thường xuyên và sinh viên đang theo học tại các trường trung cấp, cao đẳng trên địa bàn tỉnh Đắk Nông. <br>
                                        - Bảng B: Dành cho các đối tượng từ 16 tuổi trở lên đang sinh sống, lao động, làm việc trên địa bàn tỉnh Đắk Nông.
                                    </small>
                                    <small class="text-muted">*</small>
                                </div>
                            </div>
							<div class="class00">Thông tin nơi học tập, công tác</div>
							<div class="form-group">
								<label>Thành phố</label>
								<div class="input">
									<select id="city" class="form-control" name="city_id" required="">
                                        <option value="{{$city->city_id}}">{{$city->name}}</option>
                                    </select>
									<small class="text-muted">*</small>
								</div>
							</div>
							<div class="form-group">
								<label>Quận/Huyện</label>
								<div class="input">
									<select id="district" class="form-control" name="district_id">
                                        <option></option>
	                                    @if(!empty($list_district))
	                                        @foreach($list_district as $district)
	                                            <option value="{{$district->district_id}}" @if($district->district_id == $member->district_id) selected="" @endif>{{$district->name}}</option>     
	                                        @endforeach
	                                    @endif   
	                                </select>
	                                <small class="text-muted">*</small>
                            	</div>
							</div>
							<div class="form-group banga">
								<label>Trường</label>
								<div class="input">
									<select id="school" class="form-control" name="school_id">
                                        <option value="0">Chọn trường</option>
                                        @if(!empty($list_school))
                                            @foreach($list_school as $school)
                                                <option value="{{$school->school_id}}" @if($school->school_id == $member->school_id) selected="" @endif>{{$school->name}}</option>     
                                            @endforeach
                                        @endif 
                                    </select>
									<small class="text-muted">*</small>
								</div>
							</div>
							<div class="form-group banga">
								<label>Lớp</label>
								<div class="input">
									{{-- <select id="class" class="form-control" name="class_id" required="">
                                        @if(!empty($class_old))
                                        <option value="{{ $class_old->class_id }}" >{{ $class_old->name }}</option>    
                                        @endif
                                    </select> --}}
                                    <input type="text" name="class_id" value="{{ $member->class_id}}" class="form-control" id="classes" placeholder="Lớp">
									<small class="text-muted">*</small>
								</div>
							</div>
                            <div class="form-group bangb">
                                <label>Đơn vị</label>
                                <div class="input">
                                    <input class="form-control" name="don_vi" id="don_vi" value="{{$member->don_vi}}" type="name">
                                    <small class="text-muted">*</small>
                                </div>
                            </div>
							<div class="class01">Xác thực *</div>
							<div class="form-group">
								<label>Email</label>
								<div class="input">
									<input class="form-control" name="email" value="{{$member->email}}" type="text" @if($member->is_reg==1) disabled="" @endif>
								</div>
							</div>
							<div class="btn-group">
								<button type="submit" class="btn btn-save">Lưu</button>
								{{-- <a class="btn btn-exit" href="">Bỏ qua</a> --}}
							</div>
						</form>
					</div>
				</div>
			</section>

		</main>
		<!-- main end -->	

@stop

@section('footer_scripts')
	<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#form-update-info').bootstrapValidator({
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
                    // class_id: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Trường này không được bỏ trống'
                    //         },
                    //         stringLength: {
                    //             min: 3,
                    //             max: 100,
                    //             message: 'Tên phải từ 3 đến 100 kí tự'
                    //         }
                    //     }
                    // },
                    // school_id: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Trường này không được bỏ trống'
                    //         }
                    //     }
                    // },
                    district_id: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
                            }
                        }
                    },
                    table_id: {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được bỏ trống'
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
                    }
                }
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
            $("body").on('change', '#table', function () {
                var table_id = $(this).val();
                if(table_id==1){
                    $('.banga').show();
                    $('.bangb').hide();
                } 
                else if(table_id==2) {
                    $('.bangb').show();
                    $('.banga').hide();
                }
            });
		});
	</script>
@stop