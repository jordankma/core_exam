@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = 'Trang tải bài tự luận' }}@stop

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

	<section class="section upload-file">
		<div class="container">
			<div class="inner">
				<h1 class="headline">Gửi bài thi</h1>
				<form class="upload">
					<div class="form-group">
						<label for="title">Tiêu đề</label>
						<input type="title" class="form-control" placeholder="Nhập vào tiêu đề bài thi">
					</div>
					<div class="form-group">
						<label for="fileLogo">Upload logo</label>
						<span class="btn-upload btn-upload-logo">
							<span>Upload</span>
							<input type="file" class="form-control-file">
						</span>
						<div class="form-text">Chấp nhận file: jpg, jpge, png, gif. Kích thước file không quá 1024px, dung lượng
							không quá 2MB</div>
						<div class="show-logo">
							<img src="https://thuthuatnhanh.com/wp-content/uploads/2018/07/anh-avatar-dep.jpg" alt="">
							<span>x 87 KB</span>
						</div>
					</div>
					<div class="form-group">
						<textarea class="form-control" rows="24" placeholder="Ghi chú"></textarea>
					</div>
					<div class="form-group">
						<label for="fileContest">Upload file dự thi</label>
						<div class="btn-upload btn-upload-contest">
							<span>Upload</span>
							<input type="file" class="form-control-file">
						</div>
					</div>
					<button type="submit" class="btn">Gửi bài thi</button>
				</form>
				<div class="upload-notification">
					<div class="inner">
						<div class="title">Thông báo</div>
						<p>Đã xảy ra lỗi trong quá trình gửi bài thi. <br>Bạn hãy kiểm tra và gửi lại bài. Ấn Ok để đóng thông báo</p>
						<button class="btn btn-closed">OK</button>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>
<!-- main end -->

@stop

@section('footer_scripts')
	{{-- <script type="text/javascript">
		$(document).ready(function() {
			$('#form-contact').bootstrapValidator({
	            feedbackIcons: {
	                // validating: 'glyphicon glyphicon-refresh'
	            },
	            fields: {
	                name: {
	                    validators: {
	                        notEmpty: {
	                            message: 'Trường này không được bỏ trống'
	                        },
	                        stringLength: {
	                            min: 3,
	                            max: 100,
	                            message: 'Tên phải từ 3 đến 100 kí tự'
	                        }
	                    }
	                },
	                email: {
	                    validators: {
	                    	notEmpty: {
	                            message: 'Trường này không được bỏ trống'
	                        },
	                        emailAddress: {
	                            message: 'Email không đúng định dạng'
	                        }
	                    }
	                },
	                content: {
	                    validators: {
	                    	notEmpty: {
	                            message: 'Trường này không được bỏ trống'
	                        }
	                    }
	                }
	            }
	        }); 	
		});
	</script> --}}
@stop