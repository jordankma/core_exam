<!-- footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 branb">
				<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/images/logo.png?t=' . time()) }}" alt="">
				<p>CUỘC THI TÌM HIỂU VỀ
					BIỂN, ĐẢO VIỆT NAM</p>
			</div>
			<div class="col-lg-10 info">
				<div class="headline">Ban Tổ chức Cuộc thi</div>
				<div class="info-inner">
					<div class="block">
						<h2 class="name">Ban Tuyên giáo Tỉnh ủy Đắk Nông<br>
							Phòng Tuyên truyền, Báo chí – Xuất bản</h2>
						<ul class="info-contact">
							<li><i class="fa fa-phone"></i> {{ $SETTING['phone'] }} </li>
							<li><i class="fa fa-email"></i> {{ $SETTING['email'] }} </li>
						</ul>
					</div>
					<div class="block">
						<h2 class="name"> {{ $SETTING['company_name'] }} </h2>
						<ul class="info-contact">
							<li><i class="fa fa-address"></i> {{ $SETTING['address'] }} </li>
							<li><i class="fa fa-phone"></i> Hỗ trợ kỹ thuật: {{ $SETTING['hotline'] }} (8h - 22h hàng ngày)</li>
							<li><i class="fa fa-email"></i> {{ $SETTING['email'] }} </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- footer end -->