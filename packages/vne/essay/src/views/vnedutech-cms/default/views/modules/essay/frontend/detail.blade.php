@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = $essay->name }}@stop
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
                            <a class="breadcrumb-link" href="#">Tự luận</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="breadcrumb-link" href="#">{{ $essay->name }}</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- breadcrumb end -->

            <!-- news detail -->
            <section class="section news-detail">
                <div class="container">
                    <div class="wrapper">
                        <h1 class="title">{{ $essay->name }}</h1>
                        <p class="date">{{ date_format($essay->created_at,"d/m/Y H:i:s") }}</p>
                        <div class="content">
                            <p>{{ $essay->note }}</p>
                            <iframe src="{{ $file }}" height="800px" width="100%"></iframe>
                            {{-- <embed src="{{ $file }}#toolbar=0" width="100%" height="1200px"> --}}
                        </div>
                    </div>
                </div>
            </section>
            <!-- news detail end -->

        </main>
        <!-- main end -->
@stop

@section('footer_scripts')
	<script type="text/javascript">
	</script>
@stop