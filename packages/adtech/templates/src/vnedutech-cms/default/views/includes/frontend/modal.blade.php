<!-- slide out -->
		<div class="nav-trigger js-trigger">
			<span class="bar"></span>
			<span class="bar"></span>
			<span class="bar"></span>
		</div>
		<div class="slideout js-slideout">
			<div class="inner">
				<ul class="nav">
					<li class="nav-item js-toggle-login"><i class="fa fa-user"></i> Đăng nhập</li>
					<li class="nav-item js-toggle-registration"><i class="fa fa-user"></i> Đăng ký</li>
				</ul>
				<nav class="slideout-navbar">
					<ul class="nav">
						<li class="nav-item">
							<a href="" class="nav-link">Giới thiệu</a>
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
						<li class="nav-item">
							<a href="" class="nav-link">Tự luận</a>
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
						<li class="nav-item">
							<a href="" class="nav-link">Tra cứu</a>
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
						<li class="nav-item">
							<a href="" class="nav-link">Văn bản</a>
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
						<li class="nav-item">
							<a href="" class="nav-link">Tin tức</a>
						</li>
						<li class="nav-item">
							<a href="" class="nav-link">Liên hệ</a>
						</li>
					</ul>
				</nav>
				<div class="contact">
					<p class="phone">Hỗ trợ: 02613 545 662</p>
					<p class="email">Email: timhieubiendao@gmail.com</p>
				</div>

			</div>
		</div>
		<!-- slideout end -->

		<!-- popup -->
		<div class="form-user form-login js-login">
			<div class="logo">
				<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/images/egroup-logo.png?t=').time() }}" alt="">
			</div>
			<form action="" class="form">
				<p>Đã là thành viên?</p>
				<div class="form-group">
					<input type="username" class="form-control" placeholder="Email/Username">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="password">
				</div>
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input">
					<label class="form-check-label">Ghi nhớ đăng nhập</label>
				</div>
				<button type="submit" class="btn btn-success">Đăng nhập</button>
			</form>
			<div class="bottom">
				<p>Chưa có tài khoản?</p>
				<button class="btn btn-primary js-open-registration">Đăng ký mới</button>
			</div>
		</div>

		<div class="form-user from-registration js-registration">
			<div class="logo">
				<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/src/images/egroup-logo.png?t=').time() }}" alt="">
			</div>
			<form action="" class="form">
				<p>Thành viên mới?</p>
				<div class="form-group">
					<input type="username" class="form-control" placeholder="Email/Username">
					<small>(Tên đăng nhập viết liền không dấu, không chứa kí tự đặc biệt)</small>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Mật khẩu">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Xác nhận mật khẩu">
				</div>
				<div class="form-group">
					<input type="phone" class="form-control" placeholder="Số điện thoại">
				</div>
				<button type="submit" class="btn btn-success">Đăng ký</button>
			</form>
		</div>
		<!-- popup end -->

		<div class="body-overlay js-body-overlay"></div>