<section class="section video-right">
	<h3 class="headline">Video nổi bật</h3>
	@php 
		$flag = 0;
	@endphp
	@if(!empty($video_noi_bat))
	@foreach ($video_noi_bat as $element)
	@php 
		$alias = $element->title_alias . '_' . $element->news_id .'.html';
	@endphp
	@if($loop->index==0)
	<div class="video-item">
		<div class="img-cover">
			<a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
				<img src="{{ $element->image }}" alt="">
			</a>
		</div>
		<h4 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}"> {{ $element->title }} </a></h4>
	</div>
	@else
	@if($flag == 0)
	<ul class="list">
		@php $flag++ @endphp
	@endif
		<li class="list-item">
			<h5 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}"> {{ $element->title }} </a></h5>
			<p class="date">{{ $element->created_at }}</p>
		</li>
	@endif
	@endforeach
	@endif
	</ul>
	<a href="" class="btn btn-light">Xem thêm</a>
</section>