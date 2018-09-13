<section class="section notification">
	<div class="notification-item">
		<h2 class="headline">Thông báo BTC</h2>
		<div class="list">
			@if(!empty($thong_bao_ban_to_chuc))
			@foreach ($thong_bao_ban_to_chuc as $element)
				@php 
					$alias = $element->title_alias . '_' . $element->news_id .'.html';
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
		<h2 class="headline">Biển đảo việt nam (Tài liệu tham khảo cho cuộc thi)</h2>
		<div class="list">
			@if(!empty($bien_dao_viet_nam))
			@foreach ($bien_dao_viet_nam as $element)
				@php 
					$alias = $element->title_alias . '_' . $element->news_id .'.html';
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