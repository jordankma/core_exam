@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = 'Top thí sinh đã thi' }}@stop
@section('header_styles')

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
							<a class="breadcrumb-link" href="#">Bảng xếp hạng</a>
						</li>
					</ul>
				</div>
			</nav>
			<!-- breadcrumb end -->

			<!-- ratings -->
			<section class="section ratings">
				<div class="container">
					<div class="ratings-wrapper">
						<h1 class="headline">Top thí sinh thi</h1>
						{{-- <form class="ratings-search" action="">
							<select class="form-control" name="table_id">
								<option value="1">Top quận bảng đã thi</option>
								<option value="1">Bảng A</option>
								<option value="2">Bảng B</option>
							</select>
							<button class="btn btn-primary" type="submit" id="table">Tìm kiếm</button>
						</form> --}}
						<div class="content">
							<div class="row title">
								<div class="col-2 col-md-1"></div>
								<div class="col-6 col-md-6">Quận huyện</div>
								<div class="col-4 col-md-5">Số lượng</div>
							</div>
							<h2>Bảng A</h2>
							<ol class="list list_a">
								@if(!empty($list_member_exam_top_a))
								@foreach ($list_member_exam_top_a as $member_top_a)
								<li class="row">
									<div class="col-2 col-md-1 top">{{$loop->index+1}}</div>
									<div class="col-6 col-md-6 name-city">{{$member_top_a['district_name']}}</div>
									<div class="col-4 col-md-5 number">{{ $member_top_a['total'] }}</div>
								</li>
								@endforeach
								@endif
							</ol>
							<h2>Bảng B</h2>
							<ol class="list list_b">
								@if(!empty($list_member_exam_top_b))
								@foreach ($list_member_exam_top_b as $member_top_b)
								<li class="row">
									<div class="col-2 col-md-1 top"> {{ $loop->index+1 }} </div>
									<div class="col-6 col-md-6 name-city"> {{$member_top_b['district_name']}} </div>
									<div class="col-4 col-md-5 number"> {{ $member_top_b['total'] }} </div>
								</li>
								@endforeach
								@endif
							</ol>
						</div>
					</div>
				</div>
			</section>
			<!-- ratings end -->


		</main>
		<!-- main end -->
				
@stop
@section('footer_scripts')
<script type="text/javascript">
	// $(document).ready(function() {
	// 	$('#table').click(function(event) {
	// 		$table_id = $('table_id').val();
	// 		alert(table_id);
	// 		return false;
			
	// 	});
	// });
</script>
@stop