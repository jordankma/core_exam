<section class="section rating">
	<div class="rating-item">
		<div class="wrapper">
			<h2 class="headline">Top thí sinh đăng ký</h2>
			<div class="tab js-tab">
				<div class="tab-item active">
					<div class="title">Bảng A</div>
					<ul class="list">
						@if(!empty($list_member_top_a))
						@foreach ($list_member_top_a as $member_top_a)
							<li class="list-item">
								<div class="number">{{$loop->index+1}}</div>
								<div class="info">
									<div class="number-user">{{ $member_top_a->user_reg_exam_a }} <span>thí sinh</span></div>
									<div class="address">{{ $member_top_a->name }}</div>
								</div>
							</li>
						@endforeach
						@endif
					</ul>
				</div>
				<div class="tab-item">
					<div class="title">Bảng B</div>
					<ul class="list">
						@if(!empty($list_member_top_b))
						@foreach ($list_member_top_b as $member_top_b)
							<li class="list-item">
								<div class="number">{{$loop->index+1}}</div>
								<div class="info">
									<div class="number-user">{{ $member_top_b->user_reg_exam_b }} <span>thí sinh</span></div>
									<div class="address">{{ $member_top_b->name }}</div>
								</div>
							</li>
						@endforeach
						@endif
					</ul>
				</div>
			</div>
			<a href="{{route('vne.memberfrontend.list.top.member')}}" class="btn btn-light">Xem thêm</a>
		</div>
	</div>
	<div class="rating-item">
		<div class="wrapper">
			<h2 class="headline">Top thí sinh đã thi</h2>
			<div class="tab js-tab">
				<div class="tab-item active">
					<div class="title">Bảng A</div>
					<ul class="list">
						@if(!empty($list_member_exam_top_a))
						@foreach($list_member_exam_top_a as $value)
						<li class="list-item">
							<div class="number">{{$loop->index +1 }}</div>
							<div class="info">
								<div class="number-user">{{ $value['total'] }} <span>thí sinh</span></div>
								<div class="address">{{ $value['district_name'] }}</div>
							</div>
						</li>
						@if($loop->index==2)
							 @break
						@endif
						@endforeach
						@endif
					</ul>
				</div>
				<div class="tab-item">
					<div class="title">Bảng B</div>
					<ul class="list">
						@if(!empty($list_member_exam_top_b))
						@foreach($list_member_exam_top_b as $value)
						<li class="list-item">
							<div class="number">{{$loop->index +1 }}</div>
							<div class="info">
								<div class="number-user">{{ $value['total'] }} <span>thí sinh</span></div>
								<div class="address">{{ $value['district_name'] }}</div>
							</div>
						</li>
						@if($loop->index==2)
							 @break
						@endif
						@endforeach
						@endif
					</ul>
				</div>
			</div>
			<a href="{{ route('vne.memberfrontend.list.top.member.exam') }}" class="btn btn-light">Xem thêm</a>
		</div>
	</div>
</section>