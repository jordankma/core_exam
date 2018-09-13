@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-index::language.titles.index') }}@stop

@section('content')
<!-- main -->
		{{-- @php
		echo '<pre>';
		print_r($MENU_LEFT);

		@endphp --}}
		<main class="main">

			<!-- hero -->
			@include('VNE-INDEX::modules.index.layouts._slide')
			<!-- hero end -->

			<!-- logo list -->
			@include('VNE-INDEX::modules.index.layouts._logo_group')
			<!-- logo list end -->

			<div class="container container-main">
				<div class="row">
					<div class="col-lg-8 left-main">

						<!-- notification -->
						@include('VNE-INDEX::modules.index.layouts._notification')
						<!-- notification end -->

						<!-- rating -->
						@include('VNE-INDEX::modules.index.layouts._rating')
						<!-- rating end -->

						<!-- new -->
						@include('VNE-INDEX::modules.index.layouts._news')
						<!-- new end -->

					</div>
					<div class="col-lg-4 right-main">
						
						@include('includes.frontend.sidebar')	

					</div>
				</div>

			</div>

			<!-- new user -->
			@include('VNE-INDEX::modules.index.layouts._new_user')
			<!-- new user end -->

		</main>
		<!-- main end -->

@stop