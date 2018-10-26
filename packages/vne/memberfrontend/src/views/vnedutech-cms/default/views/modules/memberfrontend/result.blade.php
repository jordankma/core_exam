@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = 'Tra cứu kết quả' }}@stop
@section('header_styles')
	<style type="text/css">
		.pagination{
			display: inline !important;
		}
		.pagination .active .page-link{
			background: #0690d1;
			color: white;
		}
		.pagination .page-item{
			float: left !important;
		}
	</style>
@stop
@section('content')
<!-- main -->
		<main class="main">

		<!-- breadcrumb -->
		<nav class="section breadcrumb">
			<div class="container">
				<ul class="breadcrumb-list">
					<li class="breadcrumb-item">
						<a class="breadcrumb-link" href="#">Trang chủ</a>
					</li>
					<li class="breadcrumb-item">
						<a class="breadcrumb-link" href="#">Tra cứu</a>
					</li>
					<li class="breadcrumb-item">
						<a class="breadcrumb-link" href="#">Tra cứu kết quả</a>
					</li>
				</ul>
			</div>
		</nav>
		<!-- breadcrumb end -->
			<!-- search -->
			<section class="section search">
				<div class="container">
					<div class="search-wrapper">
						<div class="headline"><i class="fa fa-search"></i> Tra cứu kết quả thí sinh</div>
						<form action="{{route('vne.memberfrontend.result')}}" class="search-form" method="get">
							<div class="wrapper">
								<div class="form-group col-4">
									<label for="bangThi">Chọn bảng</label>
									<select class="form-control" name="table_id">
										<option value="0">Chọn bảng</option>
										@if(!empty($list_table))
											@foreach ($list_table as $element)
												<option value="{{ $element->table_id }}" @if($element->table_id==$params['table_id']) selected="" @endif>{{ $element->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-4">
									<label for="bangThi">Chọn tuần</label>
									<select class="form-control" name="topic_id">
										<option value="0">Chọn tuần</option>
										@if(!empty($list_topic))
											@foreach ($list_topic as $element)
												<option value="{{ $element['topic_id'] }}" @if($element['topic_id']==$params['topic_id']) selected="" @endif>{{ $element['topic_name'] }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-4">
									<label for="name">Họ tên</label>
									<input type="name" class="form-control" value="{{$params['name']}}" placeholder="Họ tên" name="name">
								</div>
								<div class="form-group col-md-4">
									<label for="provinceCity">Chọn tỉnh/thành phố</label>
									<select class="form-control" name="city_id">
										<option value="0">Chọn tỉnh/thành phố</option>
										@if(!empty($list_city))
											@foreach ($list_city as $element)
												<option value="{{ $element->city_id }}" @if($element->city_id==$params['city_id']) selected="" @endif>{{ $element->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-4">
									<label for="district">Quận/huyện</label>
									<select class="form-control" name="district_id">
										<option value="0">Chọn quận/huyện</option>
										@if(!empty($list_district))
											@foreach ($list_district as $element)
												<option value="{{ $element->district_id }}" @if($element->district_id==$params['district_id']) selected="" @endif>{{ $element->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-4">
									<label for="school">Trường</label>
									<select class="form-control" name="school_id">
										<option value="0">Chọn trường</option>
										@if(!empty($list_school))
											@foreach ($list_school as $element)
												<option value="{{ $element->school_id }}" @if($element->school_id==$params['school_id']) selected="" @endif>{{ $element->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-4">
									<label for="class">Lớp</label>
									<input type="text" class="form-control" value="{{$params['class_id']}}" placeholder="Lớp" name="class_id">
								</div>
							</div>
							<button class="btn btn-primary" type="submit">Tìm kiếm</button>
						</form>
					</div>
				</div>
			</section>
			<!-- search end -->

			<!-- search results -->
			<section class="section search-results">
				<div class="container">
					<div class="results">Tổng số: <span> {{$list_member->total()}}</span> lượt thi</div>
					<!-- pagination -->
					 {{$list_member->links()}}
					<!-- pagination end -->
					<div class="detail" style="background: #f1f1f1;">
						<ul class="detail-row title">
							<li class="detail-col-1">STT</li>
							<li class="detail-col-2">Họ tên</li>
							<li class="detail-col-2">Ngày sinh</li>
							{{-- <li class="detail-col-4">Lớp</li> --}}
							{{-- <li class="detail-col-4">Trường</li> --}}
							<li class="detail-col-5">Đơn vị/Trường</li>
							<li class="detail-col-4">Thành phố</li>
							<li class="detail-col-7">Quận/Huyện</li>
							<li class="detail-col-8">Thời gian</li>
							<li class="detail-col-9">Điểm</li>
						</ul>
						<div class="detail-list">
							@if(!empty($list_member))
							@foreach($list_member as $member_data )
							<input type="hidden" name="" value="{{ $member_data['is_reg'] }}">
							<ul class="detail-row item">
								<li class="detail-col-1">{{ (($params['page']-1)*20) + $loop->index + 1 }}</li>
								<li class="detail-col-2"><a href="{{ route('vne.memberfrontend.result.member',$member_data['user_id']) }}" style="text-decoration: none;color: black"> {{ isset($member_data['name'])?$member_data['name']:'' }} </a></li>
								<li class="detail-col-2">{{ isset($member_data['birthday'])?$member_data['birthday']:'' }}</li>
								{{-- <li class="detail-col-4">{{ $member['class_id }}</li> --}}
								{{-- <li class="detail-col-4">{{ $member['school != null ? $member['school->name : '' }}</li> --}}
								<li class="detail-col-5">
									@if($member_data['table_id'] == 2 )
									{{ isset($member_data['don_vi'])?$member_data['don_vi']:'' }}
									@else 
									{{ isset($member_data['school_name'])?$member_data['school_name']:'' }}
									@endif
								</li>
								<li class="detail-col-4">{{ isset($member_data['city_name']) ? $member_data['city_name'] : '' }}</li>
								<li class="detail-col-7">{{ isset($member_data['district_name']) != null ? $member_data['district_name'] : '' }}</li>
								<li class="detail-col-8">
									@php 
									$time = isset($member_data['used_time']) ? (float)($member_data['used_time']/1000) : 0;
									$time_real =  $time > 720 ? '720' : $time ; 
									@endphp
									{{(int)($time_real/60) }}p {{$time_real%60 }}s
								</li>
								<li class="detail-col-9">{{ isset($member_data['point_real'])?$member_data['point_real']: 0 }}</li>
							</ul>
							@endforeach
							@endif
						</div>
					
					</div>
				</div>
			</section>
			<!-- search results end -->


		</main>
		<!-- main end -->
@stop
@section('footer_scripts')

@stop