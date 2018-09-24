@if(!empty($tin_tuc_chung))
<section class="section news">
	<div class="news-wrapper">
		<div class="news-list">
			@foreach ($tin_tuc_chung as $element)
			@php 
				$alias = $element->title_alias . '.html';
			@endphp
			<figure class="news-item">
				<h2 class="title">
					<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
				</h2>
				<div class="content">
					<div class="img-cover">
						<a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
							<img src="{{ $element->image }}" alt="">
						</a>
					</div>
					<div class="info">
						<div class="date">{{ date_format($element->created_at,"Y/m/d") }}</div>
						<div class="description">{{ $element->desc }}</div>
						<div class="copyright"><i class="ii ii-bachelor-blue"></i> {{ $element->create_by }}</div>
					</div>
				</div>
			</figure>
			@endforeach
		</div>
		<a href="" id="load_more_news" class="btn btn-primary">Còn rất nhiều tin mới. Xem thêm ngay!</a>
	</div>
</section>
@endif