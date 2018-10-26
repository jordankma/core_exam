@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = $member->name }} @stop
@section('content')
	<!-- main -->
	<main class="main">

		<!-- breadcrumb -->
		<nav class="section breadcrumb">
			<div class="container">
				<ul class="breadcrumb-list">
					<li class="breadcrumb-item">
						<a class="breadcrumb-link" href="{{ route('index') }}">Trang chủ</a>
					</li>
					<li class="breadcrumb-item">
						<a class="breadcrumb-link" href="#">Thông tin thí sinh</a>
					</li>
				</ul>
			</div>
		</nav>
		<!-- breadcrumb end -->
		<section class="info" >
			<div class="container">
				<div class="detail" style="background: #fff; padding: 10px;">
					<p> Họ tên : {{ $member->name }} </p>
					<p> Tên tài khoản : {{ $member->u_name }} </p>
					<p> Ngày sinh : {{ $member->birthday }} </p>
					@if($member->city != null) <p> Tỉnh : {{ $member->city->name }} </p> @endif
					@if($member->district != null) <p> Quận huyện : {{ $member->district->name }} </p> @endif
					@if($member->school != null) <p> Trường : {{ $member->school->name }} </p> @endif
					@if($member->donvi != null) <p> Đơn vị : {{ $member->donvi }} </p> @endif
				</div>
			</div>	
		</section>
		<section class="result search-results">
			<div class="container">
				<div class="detail" style="background: #f1f1f1;">
					<ul class="detail-row title">
						<li class="detail-col-5">Vòng</li>
						<li class="detail-col-3">Tuần thi</li>
						<li class="detail-col-3">Lần thi</li>
						<li class="detail-col-3">Thời gian</li>
						<li class="detail-col-3">Điểm</li>
					</ul>
					<div class="detail-list">
						@if(!empty($result->data))
						@foreach($result->data as $element)
						<ul class="detail-row item">
							<li class="detail-col-5">{{ isset($element->round_name) ? $element->round_name : ''  }}</li>
							<li class="detail-col-3">{{ isset($element->topic_name) ? $element->topic_name : ''}}</li>
							<li class="detail-col-3">{{ isset($element->repeat_time) ? $element->repeat_time : ''}}</li>
							<li class="detail-col-3">
								@php
									$time = isset($element->used_time) ? (float)($element->used_time/1000) : '';
									$time_real =  $time > 720 ? 720 : $time ; 
								@endphp
								{{(int)($time_real/60) }}p {{$time_real%60 }}s
							</li>
							<li class="detail-col-3">{{ isset($element->point_real) ? $element->point_real : ''}}</li>
						</ul>
						@endforeach
						@endif
					</div>
				</div>
			</div>
		</section>
	</main>
	<!-- main end -->
@stop