@php
function showCategories($categories, $parent_id = 0, $char = '')
{
    // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
    $class = $parent_id == 0 ? 'nav js-navbar' : '';
    $cate_child = array();
    foreach ($categories as $key => $item)
    {
        // Nếu là chuyên mục con thì hiển thị
        if ($item->parent == $parent_id)
        {
            $cate_child[] = $item;
            unset($categories[$key]);
        }
    }
    // BƯỚC 2.2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
    if ($cate_child)
    {
        echo '<ul class="'.$class.'">';
        foreach ($cate_child as $key => $item)
        {
            // Hiển thị tiêu đề chuyên mục
            $url = ($item->route_name != '#') ? ($item->route_params) ? route($item->route_name, [$item->route_params]) : route($item->route_name) : '#';
            echo '<li class="nav-item">';
            echo '<a href="'.$url.'" class="nav-link">'.$item->name.'</a>';
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            showCategories($categories, $item->menu_id, $char.'|---');
            echo '</li>';
        }
        echo '</ul>';
    }
}
@endphp

<!-- header -->
<header class="header">

	<!-- top bar -->
	<section class="top-bar">
		<div class="container">
			<div class="inner">
				<div class="contact">
					<p class="phone">Hỗ trợ: {{ $SETTING['phone'] }}</p>
					<p class="email">Email:{{ $SETTING['email'] }}</p>
				</div> <!-- /top bar -->
				<ul class="nav">
					@if($USER_LOGGED)
					<li class="nav-item dropdown">
						<i class="ii ii-bachelor"></i>Vào thi
						<ul class="sub-menu">
							<li class="nav-item"><i class="fa fa-edit"></i><a href="{{ route('vne.index.try.exam') }}" class="nav-link">Thi Thử</a></li>
							<li class="nav-item"><i class="ii ii-bachelor"></i><a href="{{ route('vne.index.real.exam') }}" class="nav-link">Thi Thật</a></li>
							<li class="nav-item"><i class="fa fa-file-text"></i><a href="" class="nav-link">Tự Luận</a></li>
						</ul>
					</li>
						<a href="{{ route('vne.memberfrontend.result.member',$USER_LOGGED->member_id) }}" style="color: #fff;text-decoration: none;"><li class="nav-item"><i class="fa fa-user"></i> {{ $USER_LOGGED->u_name }}</li></a>
						<a href="{{ route('vne.member.auth.logout') }}" style="color: #fff;text-decoration: none;"><li class="nav-item"><i class="fa fa-user"></i> Đăng xuất</li></a>
					@else
						<li class="nav-item js-toggle-login"><i class="fa fa-user"></i> Đăng nhập</li>
						<li class="nav-item js-toggle-message"><i class="fa fa-bullhorn"></i>Thông báo</li>
						<li class="nav-item js-toggle-registration"><i class="fa fa-user"></i> Đăng ký</li>
					@endif
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
				@php 
					showCategories($MENU_LEFT); 
				@endphp
				{{-- <ul class="nav js-navbar">
					@if(!empty($MENU_LEFT))
					@foreach($MENU_LEFT as $key => $menu)
						@if($menu->level==0)
						<li class="nav-item">
							<a href="{{ $menu->route_name != '#' ? route($menu->route_name) : '#'}}" class="nav-link">{{ $menu->name }}</a>

							<ul>
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
							</ul>
						</li>
						@endif
					@endforeach
					@endif
				</ul> --}}
			</div>
		</div>
	</nav>
	<!-- navbar end -->

</header>
<!-- header end -->