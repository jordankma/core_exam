@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-newsfrontend::language.titles.index') }}@stop
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
							<a class="breadcrumb-link" href="#">Tin tức</a>
						</li>
					</ul>
				</div>
			</nav>
			<!-- breadcrumb end -->

			<div class="container container-main">
				<div class="row">
					<div class="col-lg-8 left-main">

						<!-- new -->
						<section class="section news">
							<div class="news-wrapper">
								<div class="news-list">
									@if(!empty($list_news))
									@foreach ($list_news as $element)
									@php 
										$alias = $element->title_alias .'.html';
									@endphp
									<figure class="news-item">
										<h2 class="title">
											<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
										</h2>
										<div class="content">
											<div class="img-cover">
												<a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
													<img src="{{ $element->image }}" alt="">
												</a>
											</div>
											<div class="info">
												<div class="date">{{ $element->created_at }}</div>
												<div class="description">{{ $element->desc }}</div>
												<div class="copyright"><i class="ii ii-bachelor-blue"></i> {{ $element->create_by }}</div>
											</div>
										</div>
									</figure>
									@endforeach
									@endif
								</div>
							</div>
						</section>
						<!-- new end -->
						<!-- pagination -->
						{{$list_news->links()}}
						<!-- pagination end -->
					</div>
					<div class="col-lg-4 right-main">

						@include('includes.frontend.sidebar')

					</div>
				</div>

			</div>

		</main>
		<!-- main end -->

@stop