<section class="section hero">
	<div class="container">
		<div class="carousel js-carousel">
			@if(!empty($banners))
			@foreach ($banners as $key => $value)
			@if($value->position==1)
			<div class="img-cover carousel-item">
				<a href="#" class="img-cover__wrapper">
					<img src="{{ $value->image }}" alt="">
				</a>
			</div>
			@endif
			@endforeach
			@endif
		</div>
	</div>
</section>