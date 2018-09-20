<section class="new-user" style="background-image: url(/images/bg.png);">
	<div class="container">
		<h2 class="headline">Thành viên mới nhất</h2>
		<div class="row">.
			@if(!empty($list_news_member))
			@foreach ($list_news_member as $element)
			<div class="col-md-6 col-lg-3 user-item">
				<div class="wrapper">
					<div class="img-cover avatar">
						<span class="img-cover__wrapper">
							<img src="images/user1.png" alt="">
						</span>
					</div>
					<div class="info">
						<h3 class="name">Nguyễn Thị Ngân</h3>
						<p class="class-school">Lớp 12 -
							<span>THPT Hoài Đức A -</span></p>
						<p class="district">Quảng Bình</p>
					</div>
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</div>
</section>