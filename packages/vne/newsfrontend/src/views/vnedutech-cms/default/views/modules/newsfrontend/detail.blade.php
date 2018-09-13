@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = $news->title }}@stop

@section('content')
<!-- main -->
		<main class="main">

			<!-- breadcrumb -->
			<nav class="section breadcrumb">
				<div class="container">
					<ul class="breadcrumb-list">
						<li class="breadcrumb-item">
							<a class="breadcrumb-link" href="{{route('index')}}">Trang chủ</a>
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

						<!-- news detail -->
						<section class="section news-detail">
							<div class="wrapper">
								<h1 class="title">{{ $news->title }}</h1>
								<p class="date">{{ $news->created_at }}</p>
								<div class="content">
									{!! $news->content !!}
								</div>
							</div>
						</section>
						<!-- news detail end -->

					</div>
					<div class="col-lg-4 right-main">

						@include('includes.frontend.sidebar')

					</div>
				</div>

			</div>

		</main>
		<!-- main end -->

@stop