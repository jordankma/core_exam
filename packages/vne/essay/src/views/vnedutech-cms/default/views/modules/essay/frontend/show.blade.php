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
							<a class="breadcrumb-link" href="#">Trang tải bài tự luận</a>
						</li>
					</ul>
				</div>
			</nav>
			<!-- breadcrumb end -->

			<!-- essay -->
			<section class="section essay registration">
				<div class="container">
                    <div class="inner">
                        <h1 class="headline">Thông tin bài tự luận</h1>
                        <form>
                            <div class="form-group">
                                <label>Tên bài</label>
                                <div class="input">
                                    <input class="form-control" type="name">
                                    <small class="text-muted">*</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <div class="input">
                                    <input class="form-control" type="name">
                                    <small class="text-muted">*</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Đề tài</label>
                                <div class="input">
                                    <select class="form-control">
                                        @if(!empty($essay_topic))
                                        @foreach($essay_topic as $element)
                                            <option value="{{ $element->essay_topic_id }}">{{ $element->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <small class="text-muted">*</small>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-save">Lưu</button>
                                <a class="btn btn-exit" href="">Bỏ qua</a>
                            </div>
                        </form>
                    </div>
				</div>

			</section>
			<!-- essay end -->

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