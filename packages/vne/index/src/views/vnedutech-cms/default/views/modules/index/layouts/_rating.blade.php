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
						{{-- <li class="list-item">
							<div class="number">01</div>
							<div class="info">
								<div class="number-user">180356 <span>thí sinh</span></div>
								<div class="address">Phú Thọ</div>
							</div>
						</li>
						<li class="list-item">
							<div class="number">02</div>
							<div class="info">
								<div class="number-user">92297 <span>thí sinh</span></div>
								<div class="address">Hà Nội</div>
							</div>
						</li>
						<li class="list-item">
							<div class="number">03</div>
							<div class="info">
								<div class="number-user">92297 <span>thí sinh</span></div>
								<div class="address">Thái Nguyên</div>
							</div>
						</li> --}}
					</ul>
				</div>
				<div class="tab-item">
					<div class="title">Bảng B</div>
					<ul class="list">
						{{-- <li class="list-item">
							<div class="number">01</div>
							<div class="info">
								<div class="number-user">180356 <span>thí sinh</span></div>
								<div class="address">THPT Lưu Nhân Chú, Đại Từ</div>
							</div>
						</li>
						<li class="list-item">
							<div class="number">02</div>
							<div class="info">
								<div class="number-user">92297 <span>thí sinh</span></div>
								<div class="address">Trường Đại Học Nguyễn Tất Thành</div>
							</div>
						</li>
						<li class="list-item">
							<div class="number">03</div>
							<div class="info">
								<div class="number-user">92297 <span>thí sinh</span></div>
								<div class="address">THPT Lý Thái Tổ</div>
							</div>
						</li> --}}
					</ul>
				</div>
			</div>
			<a href="" class="btn btn-light">Xem thêm</a>
		</div>
	</div>
</section>