<!-- header -->
<header class="header">

	<!-- top bar -->
	<section class="top-bar">
		<div class="container">
			<div class="inner">
				<div class="contact">
					<p class="phone">Hỗ trợ: {{ $SETTING['phone'] }}</p>
					<p class="email">{{ $SETTING['email'] }}</p>
				</div> <!-- /top bar -->
				<ul class="nav">
					<li class="nav-item dropdown">
						<i class="ii ii-bachelor"></i>Vào thi
						<ul class="sub-menu">
							<li class="nav-item"><i class="fa fa-edit"></i><a href="" class="nav-link">Thi Thử</a></li>
							<li class="nav-item"><i class="ii ii-bachelor"></i><a href="" class="nav-link">Thi Thật</a></li>
							<li class="nav-item"><i class="fa fa-file-text"></i><a href="" class="nav-link">Tự Luận</a></li>
						</ul>
					</li>
					<li class="nav-item js-toggle-login"><i class="fa fa-user"></i> Đăng nhập</li>
					<li class="nav-item js-toggle-registration"><i class="fa fa-user"></i> Đăng ký</li>
				</ul> <!-- nav -->
			</div>
		</div>
	</section>
	<!-- top bar end -->

	<!-- navbar -->
	<nav class="navbar">
		<div class="container">
			<div class="wrapper">
				<div class="branb">
					<a class="logo" href="{{route('index')}}"><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/images/logo.png?t=' . time()) }}" alt=""></a>
					<div class="text">
						<p>CUỘC THI<br>
							TÌM HIỂU VỀ BIỂN, ĐẢO<br>
							<b>VIỆT NAM</b></p>
					</div>
				</div>
				<ul class="nav js-navbar">
					@if(!empty($MENU_LEFT))
					@foreach($MENU_LEFT as $key => $menu)
						@if($menu->level==0)
						<li class="nav-item">
							<a href="{{ $menu->route_name != '#' ? route($menu->route_name) : '#'}}" class="nav-link">{{ $menu->name }}</a>

							{{-- <ul>
								<li class="nav-item">
									<a href="" class="nav-link">Demo</a>
								</li>
								<li class="nav-item">
									<a href="" class="nav-link">Demo</a>
									<ul>
										<li class="nav-item">
											<a href="" class="nav-link">Demo</a>
										</li>
										<li class="nav-item">
											<a href="" class="nav-link">Demo</a>
										</li>
									</ul>
								</li>
							</ul> --}}
						</li>
						@endif
					@endforeach
					@endif
				</ul>
			</div>
		</div>
	</nav>
	<!-- navbar end -->

</header>
<!-- header end -->