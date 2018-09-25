@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = 'Cập nhật thông tin' }}@stop
@section('header_styles')
	<style type="text/css">
		.pagination{
			display: inline !important;
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
						<a class="breadcrumb-link" href="#">Danh sách thí sinh</a>
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
						<form action="" class="search-form" method="post">
							<div class="wrapper">
								<div class="form-group col-12">
									<label for="bangThi">Chọn bảng</label>
									<select class="form-control" name="object_id">
										<option value="0">Chọn bảng</option>
										@if(!empty($list_table))
											@foreach ($list_table as $element)
												<option value="{{ $element->table_id }}">{{ $element->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-4">
									<label for="id">Tên đăng nhập</label>
									<input type="id" class="form-control" placeholder="Tên đăng nhập" name="u_name">
								</div>
								<div class="form-group col-md-4">
									<label for="name">Họ tên</label>
									<input type="name" class="form-control" placeholder="Họ tên" name="name">
								</div>
								<div class="form-group col-md-4">
									<label for="provinceCity">Chọn tỉnh/thành phố</label>
									<select class="form-control" name="city_id">
										<option value="0">Chọn tỉnh/thành phố</option>
										@if(!empty($list_city))
											@foreach ($list_city as $element)
												<option value="{{ $element->city_id }}">{{ $element->name }}</option>
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
												<option value="{{ $element->district_id }}">{{ $element->name }}</option>
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
												<option value="{{ $element->school_id }}">{{ $element->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-4">
									<label for="class">Lớp</label>
									<select class="form-control" name="class_id">
										<option value="0">Chọn lớp</option>
										@if(!empty($list_class))
											@foreach ($list_class as $element)
												<option value="{{ $element->class_id }}">{{ $element->name }}</option>
											@endforeach
										@endif
									</select>
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
					<div class="results">Tổng só: <span>1.965.697</span> lượt thi</div>
					<!-- pagination -->
					{{$list_member->links()}}
					<!-- pagination end -->
					<div class="detail">
						<ul class="detail-row title">
							<li class="detail-col-1">STT</li>
							<li class="detail-col-2">Họ tên</li>
							<li class="detail-col-3">Tên đăng nhập</li>
							<li class="detail-col-4">Lớp</li>
							<li class="detail-col-5">Trường</li>
							<li class="detail-col-6">Quận/Huyện</li>
							<li class="detail-col-7">Thành phố</li>
							<li class="detail-col-8">Thời gian</li>
							<li class="detail-col-9">Điểm</li>
						</ul>
						<div class="detail-list">
							@if(!empty($list_member))
							@foreach($list_member as $element )
							<ul class="detail-row item">
								<li class="detail-col-1">1</li>
								<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
								<li class="detail-col-3">banhbeovodung0102</li>
								<li class="detail-col-4">Lớp A10</li>
								<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
								<li class="detail-col-6">Quận 5</li>
								<li class="detail-col-7">TP. Hồ Chí Minh</li>
								<li class="detail-col-8">00:15:018</li>
								<li class="detail-col-9">200</li>
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