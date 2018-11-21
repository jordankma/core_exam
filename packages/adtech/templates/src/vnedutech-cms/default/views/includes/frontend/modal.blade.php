<!-- slide out -->
		<div class="nav-trigger js-trigger">
			<span class="bar"></span>
			<span class="bar"></span>
			<span class="bar"></span>
		</div>
		<div class="slideout js-slideout">
			<div class="inner">
				<ul class="nav">
					@if($USER_LOGGED)
						<li class="nav-item"><i class="fa fa-user"></i> {{ $USER_LOGGED->u_name }}</li>
						<li class="nav-item"><i class="fa fa-user"></i> <a href="{{ route('vne.member.auth.logout') }}">Đăng xuất</a></li>
					@else
						<li class="nav-item js-toggle-login"><i class="fa fa-user"></i> Đăng nhập</li>
						<li class="nav-item js-toggle-registration"><i class="fa fa-user"></i> Đăng ký</li>
					@endif
				</ul>
				<nav class="slideout-navbar">
					@php 
						showCategories($MENU_LEFT); 
					@endphp
				</nav>
				<div class="contact">
					<p class="phone">Hỗ trợ: {{ $SETTING['phone'] }}</p>
					<p class="email">Email: {{ $SETTING['email'] }}</p>
				</div>

			</div>
		</div>
		<!-- slideout end -->

		<!-- popup -->
		<div class="form-user form-login js-login">
			<div class="logo">
				<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/images/egroup-logo.png?t=').time() }}" alt="">
			</div>
			<form action="{{ route('vne.member.auth.login')}}" method="post" class="form" id="form-login">
				<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				<p>Đã là thành viên?</p>
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Email/Username">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Password">
				</div>
				{{-- <div class="form-group form-check">
					<input type="checkbox" name="remember" class="form-check-input" id="check_renember">
					<label class="form-check-label" for="check_renember">Ghi nhớ đăng nhập</label>
				</div> --}}
				<small class="help-block"></small>
				<button type="submit" class="btn btn-success">Đăng nhập</button>
			</form>
			<div class="bottom">
				<p>Chưa có tài khoản?</p>
				<button class="btn btn-primary js-open-registration">Đăng ký mới</button>
			</div>
		</div>

		<div class="form-user message js-message">
            <div class="logo">
                <img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/images/egroup-logo.png?t=').time() }}" alt="">
            </div>
            <div class="inner-message">
                <h4>Cuộc thi đã kết thúc.</h4>
            </div>
        </div>

		<div class="form-user from-registration js-registration">
			<div class="logo">
				<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/images/egroup-logo.png?t=').time() }}" alt="">
			</div>
			<form action="{{ route('vne.member.member.register') }}" method="post" class="form" id="form-register">
				<p>Thành viên mới?</p>
				<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				<div class="form-group">
					<input type="username" name="u_name" class="form-control" placeholder="Email/Username">
					{{-- <small>(Tên đăng nhập viết liền không dấu, không chứa kí tự đặc biệt)</small> --}}
				</div>
				<div class="form-group">
					<input type="password" name="password_reg" class="form-control" placeholder="Mật khẩu">
				</div>
				<div class="form-group">
					<input type="password" name="conf_password" class="form-control" placeholder="Xác nhận mật khẩu">
				</div>
				<div class="form-group">
					<input type="phone" name="phone" class="form-control" placeholder="Số điện thoại">
				</div>
				<button type="submit" class="btn btn-success">Đăng ký</button>
			</form>
		</div>
		<!-- popup end -->

		<div class="body-overlay js-body-overlay"></div>