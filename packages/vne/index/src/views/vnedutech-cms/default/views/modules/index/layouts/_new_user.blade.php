@if(!empty($list_news_member))
<section class="new-user" style="background-image: url({{ asset('/vendor/' . $group_name . '/' . $skin . '/web/images/bg.png?t=' . time()) }});">
	<div class="container">
		<h2 class="headline">Thành viên mới nhất</h2>
		<div class="row">.
			@foreach ($list_news_member as $element)
			<div class="col-md-6 col-lg-3 user-item">
				<div class="wrapper">
					<div class="img-cover avatar">
						<span class="img-cover__wrapper">
							<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/web/images/user1.png?t=' . time()) }}" alt="">
						</span>
					</div>
					<div class="info">
						<h3 class="name"> {{ $element->u_name }} </h3>
						<p class="class-school"> {{ $element->classes != null ? $element->classes->name : '' }} -
							<span> {{ $element->school != null ? $element->school->name : '' }} -</span></p>
						<p class="district"> {{ $element->city != null ? $element->city->name : '' }} </p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endif