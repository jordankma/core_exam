<section class="section news">
	<div class="news-wrapper">
		<div class="news-list">
			@if(!empty($tin_tuc_chung))
			@foreach ($tin_tuc_chung as $element)
			@php 
				$alias = $element->title_alias . '_' . $element->news_id .'.html';
			@endphp
			<figure class="news-item">
				<h2 class="title">
					<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
				</h2>
				<div class="content">
					<div class="img-cover">
						<a href="#" class="img-cover__wrapper">
							<img src="{{ $element->image }}" alt="">
						</a>
					</div>
					<div class="info">
						<div class="date">{{ $element->created_at }}</div>
						<div class="description">{{ $element->desc }}</div>
						<div class="copyright"><i class="ii ii-bachelor-blue"></i> {{ $element->create_by }}</div>
					</div>
				</div>
			</figure>
			@endforeach
			@endif
		</div>
		{{-- <a href="" class="btn btn-primary">Còn rất nhiều tin mới. Xem thêm ngay!</a> --}}
    	{{$tin_tuc_chung->links()}}
	</div>
</section>