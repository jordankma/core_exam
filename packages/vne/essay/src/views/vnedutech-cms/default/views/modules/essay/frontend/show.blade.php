@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = 'Trang tải bài tự luận' }}@stop
@section('header_styles')
	<style type="text/css">
		.upload-file .inner .headline::before{
			background-image : url("{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/images/books.png?t=') }}");
		}
		.upload-file .inner .form-group .btn-upload.btn-upload-contest .form-control-file {margin-left: 10px !important}
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
			{{-- <div class="inner">
				<h1 class="headline">Gửi bài thi</h1>
				<form class="upload" action="{{ route('vne.frontend.essay.save') }}" method="post" enctype="multipart/form-data" id="form-add-essay">
					<div class="form-group">
						<label for="title">Tiêu đề</label>
						<input  type="text" name="name" value="{{ $name }}" class="form-control" placeholder="Nhập vào tiêu đề bài thi" >
					</div>
					<div class="form-group">
						<label for="fileLogo">Upload logo</label>
						<span class="btn-upload btn-upload-logo">
							<span>Upload</span>
							<input type="file" name="image" class="form-control-file">
						</span>
						<div class="form-text">Chấp nhận file: jpg, jpge, png, gif. Kích thước file không quá 1024px, dung lượng
							không quá 2MB</div>
						{{-- <div class="show-logo">
							<img src="https://thuthuatnhanh.com/wp-content/uploads/2018/07/anh-avatar-dep.jpg" alt="">
							<span>x 87 KB</span>
						</div> --}}
					</div>
					<div class="form-group">
						<textarea name="note" class="form-control" rows="7">{{ $note }}</textarea>
					</div>
					<div class="form-group">
						<label for="fileContest">Upload file dự thi</label>
						<div class="btn-upload btn-upload-contest">
							<span>Upload</span>
							<input type="file" name="fileToUpload" class="form-control-file">
						</div>
					</div>
					<button type="submit" class="btn">Gửi bài thi</button>
				</form>
				<div class="upload-notification">
					<div class="inner">
						<div class="title">Thông báo</div>
						<div class="content-notification">
							<p>Đã xảy ra lỗi trong quá trình gửi bài thi. <br>Bạn hãy kiểm tra và gửi lại bài. Ấn Ok để đóng thông báo</p>
						</div>
						<a href="" class="btn-ok"> <button class="btn btn-closed">Đồng ý</button></a>
					</div>
				</div>
			</div> --}}
			<div class="inner">
				{!! $data_file !!}
			</div>
		</div>
	</section>

</main>
<!-- main end -->

@stop

@section('footer_scripts')
	<script type="text/javascript">
		$(document).ready(function () {
			var flag = '{{ $flag }}';
			var message = '{{ $message }}';
			var route_index = '{{ route('index') }}';
			var route_show = '{{ route('vne.frontend.essay.show') }}';
			if( flag == 1 ){
				$('.content-notification').text(message);
				$('body').addClass('active-upload-notification');	
				$('.btn-ok').attr('href',route_index);			
			} else if(flag == 2){
				$('.content-notification').text(message);
				$('body').addClass('active-upload-notification');	
				$('.btn-ok').click(function(){
					$('body').removeClass('active-upload-notification');		
				});
			}
            $('#form-add-essay').bootstrapValidator({
                feedbackIcons: {
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập tên tên'
                            },
                            stringLength: {
                                max: 150,
                                message: 'Tên không được quá dài'
                            }
                        }
                    },
                    image: {
                        validators: {
                            file: {
                                extension: 'png,jpg',
                                message: 'Chọn sai định dạng ảnh'
                            }
                        }
                    },
                    fileToUpload: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa chọn bài thi để tải lên'
                            },
                            file: {
                                extension: 'pdf,pptx,txt',
                                message: 'Chọn sai định dạng file'
                            }
                        }
                    },
                }
            }); 
        });
	</script>
@stop