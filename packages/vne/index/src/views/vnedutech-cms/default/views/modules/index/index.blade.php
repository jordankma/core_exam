@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-index::language.titles.index') }}@stop
@section('header_styles')
	<meta property="og:locale" content="vi_VN" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Cuộc thi tìm hiểu về biển đảo việt nam" />
	<meta property="og:description" content="Cuộc thi tìm hiểu về biển đảo việt nam" />
	<meta property="og:url" content="http://timhieubiendao.daknong.vn/" />
	<meta property="og:site_name" content="Cuộc thi tìm hiểu về biển đảo việt nam" />
	<meta property="og:image" content="http://timhieubiendao.daknong.vn/files/photos/anh_tin_tuc/new2.png" />
	<meta property="og:image:secure_url" content="http://timhieubiendao.daknong.vn/files/photos/anh_tin_tuc/new2.png" />
	<link rel="canonical" href="http://timhieubiendao.daknong.vn/" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="Cuộc thi tìm hiểu về biển đảo việt nam" />
	<meta name="twitter:title" content="Cuộc thi tìm hiểu về biển đảo việt nam" />
	<meta name="twitter:image" content="http://timhieubiendao.daknong.vn/files/photos/anh_tin_tuc/new2.png" />
@stop
@section('content')
<!-- main -->
		<marquee id="marquee" behavior="scroll" direction="left" style="font-size: 22px">{{ $SETTING['slogan'] }} </marquee>

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

@section('footer_scripts')
	<script type="text/javascript">

		$(document).ready(function() {
			var last_page_tin_tuc_chung = {{$last_page_tin_tuc_chung}};
			var page = 1;
			$('#load_more_news').click(function(event) {
				page++;
				var route_get = "{{ route('vne.index.news.box','tintucchung') .'?tintucchung=' }}";
				if(last_page_tin_tuc_chung == page){
				    $.ajax({
			            url: "{{ route('vne.index.news.box','tintucchung') }}",
			            type: 'GET',
			            cache: false,
			            data: {
			                'tintucchung': page,

			            },
			            success: function (data, status) {
			            	var data = JSON.parse(data);
			            	var str = '';
			            	for(i = 0; i<data.length; i++) {
			            		var alias = data[i].title_alias + '_' + data[i].news_id +'.html';
			            		str += '<figure class="news-item">'
									+		'<h2 class="title">'
									+			'<a href="/chi-tiet/'+ alias +'">'+data[i].title+'</a>'
									+		'</h2>'
									+		'<div class="content">'
									+			'<div class="img-cover">'
									+				'<a href="/chi-tiet/' +alias+ '" class="img-cover__wrapper">'
									+					'<img src="'+data[i].image+'" alt="">'
									+				'</a>'
									+			'</div>'
									+			'<div class="info">'
									+				'<div class="date">'+data[i].created_at+'</div>'
									+				'<div class="description">'+data[i].desc+'</div>'
									+				'<div class="copyright"><i class="ii ii-bachelor-blue"></i> '+data[i].create_by+'</div>'
									+			'</div>'
									+		'</div>'
									+	'</figure>';  
						        
						    }   
						    $('.news-list').append(str); 
			            }
			        }, 'json');
					$("#load_more_news").css("display", "none");
					$("#load_more_news").css("visible", "hidden");
				} else{	
					$.ajax({
			            url: "{{ route('vne.index.news.box','tintucchung') }}",
			            type: 'GET',
			            cache: false,
			            data: {
			                'tintucchung': page,

			            },
			            success: function (data, status) {
			            	var data = JSON.parse(data);
			            	var str = '';
			            	for(i = 0; i<data.length; i++) {
			            		var alias = data[i].title_alias + '_' + data[i].news_id +'.html';
			            		str += '<figure class="news-item">'
									+		'<h2 class="title">'
									+			'<a href="/chi-tiet/'+ alias +'">'+data[i].title+'</a>'
									+		'</h2>'
									+		'<div class="content">'
									+			'<div class="img-cover">'
									+				'<a href="/chi-tiet/' +alias+ '" class="img-cover__wrapper">'
									+					'<img src="'+data[i].image+'" alt="">'
									+				'</a>'
									+			'</div>'
									+			'<div class="info">'
									+				'<div class="date">'+data[i].created_at+'</div>'
									+				'<div class="description">'+data[i].desc+'</div>'
									+				'<div class="copyright"><i class="ii ii-bachelor-blue"></i> '+data[i].create_by+'</div>'
									+			'</div>'
									+		'</div>'
									+	'</figure>';  
						        
						    }   
						    $('.news-list').append(str); 
			            }
			        }, 'json');
				}
				return false;
			});
		});
	</script>
@stop