<section class="section notification">
	<div class="notification-item">
		@php 
			$alias = config('site.news_cat.thongbaobtc');
		@endphp
		<h2 class="headline"><a href="{{route('vne.newsfrontend.news.list',$alias)}}">Thông báo BTC</a></h2>
		<div class="list">
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
			$alias = config('site.news_cat.biendaovietnamtailieuthamkhaochocuocthi');
		@endphp
		<h2 class="headline"><a href="{{route('vne.newsfrontend.news.list',$alias)}}">Biển đảo việt nam (Tài liệu tham khảo cho cuộc thi)</a></h2>
		<div class="list">
			@if(!empty($bien_dao_viet_nam))
			@foreach ($bien_dao_viet_nam as $element)
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
</section>