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
						<div class="headline"><i class="fa fa-search"></i> Tra cứu danh sách thí sinh</div>
						<form action="{{route('vne.memberfrontend.search.result.member')}}" class="search-form" method="get">
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
					<div class="results">Tổng số: <span>0</span> lượt thi</div>
					<!-- pagination -->
					{{-- {{$list_member->links()}} --}}
					<!-- pagination end -->
					<div class="detail" style="background: #f1f1f1;">
						<ul class="detail-row title">
							<li class="detail-col-1">STT</li>
							<li class="detail-col-2">Họ tên</li>
							<li class="detail-col-2">Ngày sinh</li>
							{{-- <li class="detail-col-4">Lớp</li> --}}
							{{-- <li class="detail-col-4">Trường</li> --}}
							<li class="detail-col-5">Đơn vị</li>
							<li class="detail-col-4">Thành phố</li>
							<li class="detail-col-7">Quận/Huyện</li>
							<li class="detail-col-8">Thời gian</li>
							<li class="detail-col-9">Điểm</li>
						</ul>
						<div class="detail-list">
							@if(!empty($list_member))
							@foreach($list_member->data as $member_data )
							<ul class="detail-row item">
								<li class="detail-col-1">{{$loop->index + 1}}</li>
								<li class="detail-col-2">{{ isset($member_data->name)?$member_data->name:'' }}</li>
								<li class="detail-col-2">{{ isset($member_data->birthday)?$member_data->birthday:'' }}</li>
								{{-- <li class="detail-col-4">{{ $member_data->class_id }}</li> --}}
								{{-- <li class="detail-col-4">{{ $member_data->school != null ? $member_data->school->name : '' }}</li> --}}
								<li class="detail-col-5">{{ isset($member_data->don_vi)?$member_data->don_vi:'' }}</li>
								<li class="detail-col-4">{{ isset($member_data->city_name) ? $member_data->city_name : '' }}</li>
								<li class="detail-col-7">{{ isset($member_data->district_name) != null ? $member_data->district_name : '' }}</li>
								<li class="detail-col-8">
									@php 
									$point = isset($member_data->used_time) ? (float)($member_data->used_time/1000) : '';
									$point_real =  $point > 720 ? '720' : $point ; 
									@endphp
									{{$point_real}}
								</li>
								<li class="detail-col-9">{{ isset($member_data->total_point)?$member_data->total_point:'' }}</li>
							</ul>
							@endforeach
							@endif
						</div>

					Tổng: {{$list_member->total}} kết quả
					
					</div>
				</div>
			</section>
			<!-- search results end -->


		</main>
		<!-- main end -->
@stop
@section('footer_scripts')

@stop