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
                    <form action="{{ route('vne.frontend.essay.list') }}" method="GET" class="search-form">
                        <div class="wrapper">
                            <div class="form-group col-md-3">
                                <label for="id">Tên đăng nhập</label>
                                <input type="id" name="u_name" value="{{ $params['u_name'] }}" class="form-control" placeholder="Tên đăng nhập">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="member_name">Họ tên</label>
                                <input type="name" name="member_name" value="{{ $params['member_name'] }}" class="form-control" placeholder="Họ tên">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="name">Tên bài viết</label>
                                <input type="name" name="name" value="{{ $params['name'] }}" class="form-control" placeholder="Tên bài viết">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Chọn bảng:</label>
                                <select class="form-control" name="table_id">
                                    <option value="">Chọn bảng</option>
                                    <option value="1">Bảng A</option>
                                    <option value="2">Bảng B</option>
                                </select>
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