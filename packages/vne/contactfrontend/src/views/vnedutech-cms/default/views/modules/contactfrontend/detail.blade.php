@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-newsfrontend::language.titles.index') }}@stop

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
							<a class="breadcrumb-link" href="#">Liên hệ</a>
						</li>
					</ul>
				</div>
			</nav>
			<!-- breadcrumb end -->

			<!-- contact -->
			<section class="section contact">
				<div class="container">
					<h1 class="headline">Thông tin liên hệ</h1>
					<div class="row">
						<div class="col-lg-5">
							<div class="maps">
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.6363086371703!2d105.79868641539858!3d21.007210986010058!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aca143131561%3A0x5d47295f81445f37!2zMjVUMSBUcnVuZyBIb8OgIE5ow6JuIENow61uaA!5e0!3m2!1svi!2s!4v1536573738817"
								  width="100%" height="410" frameborder="0" style="border:0" allowfullscreen></iframe>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="info">
								<div class="info-item">
									<h2 class="title">Ban tuyên giáo tỉnh ủy Đắk Nông</h2>
									<p><i class="fa fa-address"> </i> Phòng tuyên truyền, báo chí - xuất bản</p>
									<p><i class="fa fa-phone"> </i> 02613 545 662</p>
									<p><i class="fa fa-email"> </i> timhieubiendao@gmail.com</p>
								</div>
								<div class="info-item">
									<h2 class="title"> {{ $SETTING['company_name'] }} </h2>
									<p><i class="fa fa-address"> </i> {{ $SETTING['address'] }}</p>
									<p><i class="fa fa-phone"> </i> Hỗ trợ kỹ thuật: {{ $SETTING['hotline'] }} (8h - 22h hàng ngày)</p>
									<p><i class="fa fa-email"> </i>{{ $SETTING['email'] }}</p>
								</div>
							</div>
							<form action="{{ route('vne.contactfrontend.contact.add') }}" class="form-contact" id="form-contact" method="post">
								<h2 class="title">Liên hệ với chúng tôi:</h2>
								<div class="row">
									<div class="form-group col-md-6">
										<input type="name" name="name" class="form-control" placeholder="Họ và tên">
									</div>
									<div class="form-group col-md-6">
										<input type="email" name="email" class="form-control" placeholder="Email">
									</div>
									<div class="form-group col-12">
										<textarea class="form-control" name="content" rows="8" placeholder="Nội dung"></textarea>
									</div>
								</div>
								<button class="btn btn-primary" type="submit">Gửi thông tin</button>
							</form>
						</div>
					</div>
				</div>

			</section>
			<!-- contact end -->

		</main>
		<!-- main end -->

@stop

@section('footer_scripts')
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
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
	</script>
@stop