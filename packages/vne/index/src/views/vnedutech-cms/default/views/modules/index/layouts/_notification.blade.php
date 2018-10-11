<section class="section notification">
	<div class="notification-item">
		@php 
			$alias = config('site.news_box.thongbaobtc');
		@endphp
		<h2 class="headline"><a href="{{route('vne.newsfrontend.news.list.box',$alias)}}" style="text-decoration: none;
    color: #ff1134;">Thông báo BTC</a></h2>
		<div class="list">
			@php 
				$alias = 'the-le-cuoc-thi-tim-hieu-ve-bien-dao-viet-nam-nam-2018.html'
			@endphp
			<div class="list-item">
				<h3 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">THỂ LỆ Cuộc thi “Tìm hiểu về biển, đảo Việt Nam” năm 2018</a></h3>
				<p class="date">20-09-2018</p>
			</div>
			@if(!empty($thong_bao_ban_to_chuc))
			@foreach ($thong_bao_ban_to_chuc as $element)
				@php 
					$alias = $element->title_alias .'.html';
				@endphp
				<div class="list-item">
					<h3 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a></h3>
					<p class="date">{{ $element->created_at }}</p>
				</div>
			@endforeach
			@endif
		</div>
	</div>
	<div class="notification-item">
		@php 
			$alias = config('site.news_box.biendaovietnamtailieuthamkhaochocuocthi');
		@endphp
		<h2 class="headline"><a href="{{route('vne.newsfrontend.news.list.box',$alias)}}" style="text-decoration: none;
    color: #ff1134;">Biển đảo việt nam (Tài liệu tham khảo cho cuộc thi)</a></h2>
		<div class="list">
			<div class="list-item">
				<h3 class="title"><a href="{{ URL::to('tin-tuc','vi-tri-va-tiem-nang-cua-bien-dao-viet-nam') }}">Vị trí và tiềm năng của biển, đảo Việt Nam</a></h3>
			</div>
			<div class="list-item">
				<h3 class="title"><a href="{{ URL::to('tin-tuc','chu-quyen-va-quyen-chu-quyen-cua-viet-nam-tren-bien-dong') }}">Chủ quyền và quyền chủ quyền của Việt Nam trên Biển Đông</a></h3>
			</div>
			<div class="list-item">
				<h3 class="title"><a href="{{ URL::to('tin-tuc','phap-luat-ve-bien-dao') }}">Pháp luật về biển đảo</a></h3>
			</div>
			<div class="list-item">
				<h3 class="title"><a href="{{ URL::to('tin-tuc','chu-truong-quan-diem-cua-dang-nha-nuoc-ve-bien-dao-viet-nam') }}">Chủ trương, quan điểm của Đảng, Nhà nước về biển đảo Việt Nam</a></h3>
			</div>
			<div class="list-item">
				<h3 class="title"><a href="{{ URL::to('tin-tuc','nhung-thanh-tuu-xay-dung-va-phat-trien-cua-linh-vuc-lien-quan-den-bien-dao-viet-nam') }}">Những thành tựu xây dựng và phát triển của lĩnh vực liên quan đến biển, đảo Việt Nam</a></h3>
			</div>
			{{-- <div class="list-item">
				<h3 class="title"><a href="{{ URL::to('tin-tuc','100-cau-hoi-dap') }}">100 câu hỏi đáp</a></h3>
			</div> --}}
			<div class="list-item">
				<h3 class="title"><a href="{{ URL::to('tin-tuc','cac-hoat-dong-phoi-hop-giua-dak-nong-va-quan-chung-hai-quan') }}">Các hoạt động phối hợp giữa Đắk Nông và Quân chủng Hải quân</a></h3>
			</div>
		</div>
	</div>
</section>