@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = 'Danh sách bài thi tự luận' }}@stop
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
                        <a class="breadcrumb-link" href="#">Danh sách bài thi</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- breadcrumb end -->

        <!-- search -->
        <section class="section search">
            <div class="container">
                <div class="search-wrapper">
                    <div class="headline"><i class="fa fa-search"></i> Tra cứu bài thi</div>
                    <form action="" class="search-form">
                        <div class="wrapper">
                            <div class="form-group col-md-4">
                                <label for="id">Tên đăng nhập</label>
                                <input type="id" class="form-control" placeholder="Tên đăng nhập">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name">Họ tên</label>
                                <input type="name" class="form-control" placeholder="Họ tên">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name_post">Tên bài viết</label>
                                <input type="name_post" class="form-control" placeholder="Tên bài viết">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    </form>
                </div>
            </div>
        </section>
        <!-- search end -->

        <!-- posts -->
        <div class="section posts">
            <div class="container">
                <div class="wrapper">
                    <div class="inner">
                        @if(!empty($list_essay))
                        @foreach ($list_essay as $essay)
                            <figure class="post-item">
                                <div class="img-cover">
                                    <a href="{{ route('vne.frontend.essay.detail', ['essay_id' => $essay->essay_id ] ) }}" class="img-cover__wrapper">
                                        <img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/images/new1.png?t=' . time()) }}" alt="">
                                    </a>
                                </div>
                                <div class="content">
                                    <h3 class="title">
                                        <a href="{{ route('vne.frontend.essay.detail', ['essay_id' => $essay->essay_id ]) }}">{{ $essay->name }}</a>
                                    </h3>
                                    <div class="date">{{ date_format($essay->created_at,"d/m/Y H:i:s") }}</div>
                                </div>
                            </figure>
                        @endforeach
                        @endif
                    </div>
                    <!-- pagination -->
                    {{$list_essay->links()}}
                    <!-- pagination end -->
                </div>
            </div>
        </div>
        <!-- posts end -->


    </main>
    <!-- main end -->

@stop

@section('footer_scripts')
	<script type="text/javascript">
	</script>
@stop