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
								</div>
								<small class="text-muted">*</small>
							</div>
							<div class="form-group">
								<label>Ngày sinh</label>
								<div class="input">
									<input type="text" name="birthday" value="{{ $member->birthday}}" class="form-control" id="birthday" placeholder="Ngày sinh">
								</div>
							</div>
							<div class="form-group">
								<label>Điện thoại</label>
								<div class="input">
									<input class="form-control" type="text" name="phone" value="{{ $member->phone }}" disabled="">
									<small class="form-text form-text-01">(Chú ý: Họ tên phải là tiếng Việt có dấu, không viết liền, không chứa ký tự đặc biệt)</small>
									<small class="text-muted">*</small>
								</div>
							</div>
							<div class="form-group">
								<label>Bạn là đối tượng</label>
								<div class="input">
									<select class="form-control" id="object" name="object_id" required="">
										<option value="0">Chọn đối tượng</option>
										@if(!empty($list_object))
                                            @foreach($list_object as $object)
                                                <option value="{{$object->object_id}}" @if($object->object_id == $member->object_id) selected="" @endif >{{$object->name}}</option>     
                                            @endforeach
                                        @endif
									</select>
									<small class="text-muted">*</small>
								</div>
							</div>
							<div class="class00">Thông tin nơi học tập, công tác</div>
							<div class="form-group">
								<label>Thành phố</label>
								<div class="input">
									<select id="city" class="form-control" name="city_id" required="">
                                        <option value="0" >Chọn thành phố</option>
                                        @if(!empty($list_city))
                                            @foreach($list_city as $city)
                                                <option value="{{$city->city_id}}" @if($city->city_id == $member->city_id) selected="" @endif>{{$city->name}}</option>     
                                            @endforeach
                                        @endif
                                    </select>
									<small class="text-muted">*</small>
								</div>
							</div>
							<div class="form-group">
								<label>Quận/Huyện</label>
								<div class="input">
									<select id="district" class="form-control" name="district_id" required="">
										<option value="0" >Chọn quận huyện</option>
	                                    @if(!empty($list_district))
	                                        @foreach($list_district as $district)
	                                            <option value="{{$district->district_id}}" @if($district->district_id == $member->district_id) selected="" @endif>{{$district->name}}</option>     
	                                        @endforeach
	                                    @endif   
	                                </select>
	                                <small class="text-muted">*</small>
                            	</div>
							</div>
							<div class="form-group">
								<label>Trường</label>
								<div class="input">
									<select id="school" class="form-control" name="school_id" required="">
                                        @if(!empty($list_school))
                                            @foreach($list_school as $school)
                                                <option value="{{$school->school_id}}" @if($school->school_id == $member->school_id) selected="" @endif>{{$school->name}}</option>     
                                            @endforeach
                                        @endif 
                                    </select>
									<small class="text-muted">*</small>
								</div>
							</div>
							<div class="form-group">
								<label>Lớp</label>
								<div class="input">
									<select id="class" class="form-control" name="class_id" required="">
                                        @if(!empty($class_old))
                                        <option value="{{ $class_old->class_id }}" >{{ $class_old->name }}</option>    
                                        @endif
                                    </select>
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
							<p class="or"><i>Hoặc</i></p>
							<div class="form-group">
								<label>Facebook</label>
								<div class="input">
									<input class="form-control" name="facebook" type="text" placeholder="facebook.com/nghiemvanmanh0192">
								</div>
							</div>
							<div class="btn-group">
								<button type="submit" class="btn btn-save">Lưu</button>
								<a class="btn btn-exit" href="">Bỏ qua</a>
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
                    }
                }
            });  
	        $('#birthday').datetimepicker({
                format: 'YYYY-MM-DD'
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
		});
	</script>
@stop