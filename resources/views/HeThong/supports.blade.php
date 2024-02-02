
<?php
	$model_vp = \App\Models\Hethong\dsvanphonghotro::all();
	$a_vp = a_unique(array_column($model_vp->toArray(),'vanphong'));
	$col =(int) 12 / (count($a_vp)>0?count($a_vp) : 1);
	$col = $col < 4 ? 4 : $col;
?>
<div class="row">
	<div class="col-md-12">
		<div class="well">
			<p>Công ty LifeSoft chân thành cảm ơn quý khách hàng đã tin tưởng sử dụng phần mềm của công ty.
				Thay mặt toàn bộ cán bộ nhân viên trong công ty gửi đến khách hàng lời chúc sức khỏe- thành công</p>
			<p>Nhằm chăm sóc, hỗ trợ khách hàng nhanh chóng và tiện dụng nhất công ty xin cung cấp thông tin các cán bộ hỗ trợ khách hàng trong quá trình sử dụng.
				Mọi vấn đề khúc mắc khách hàng có thể liên hệ trực tiếp cho cán bộ để được hỗ trợ!</p>
			<!--p>Số điện thoại công ty: <b>024 3634 3951</b></p-->
			<p style="color: #ec4844">Do các thay đổi trong chính sách bảo mật hệ thống. Các mật khẩu yếu nên thay đổi lại để tránh việc bị ăn cắp tài khoản. Mật khẩu mới nên đảm bảo các
				yếu tố: tối thiểu 06 ký tự, ít nhất có 01 chữ số, ít nhất 01 chữ cái hoặc ký tự đặc biệt.</p>
			<p>Phụ trách khối kỹ thuật:<b> Phó giám đốc:  Trần Ngọc Hiếu </b>- tel: <b>096 8206844</b></p>
		</div>
	</div>
</div>
<div class="row">
	@foreach($a_vp as $vp)
		<?php $vanphong = $model_vp->where('vanphong', $vp);  ?>
		<div class="col-md-{{$col}}">
		<!-- BEGIN PORTLET -->
		<div class="portlet light" minlength="350px">
			<div class="portlet-title">
				<div class="caption caption-md">
					<i class="icon-bar-chart theme-font hide"></i>
					<span class="caption-subject font-blue-madison bold uppercase">{{$vp}}</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-scrollable table-scrollable-borderless">
					<table class="table table-hover table-light">
						<thead>
							<tr class="uppercase">
								<th colspan="2">
									Cán bộ hỗ trợ
								</th>
								<th>
									Số điện thoại
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach($vanphong as $ct)
							<tr>
								<td class="fit">
									<img class="user-pic" src="{{url('images/avatar/default-user.png')}}">
								</td>
								<td>{{$ct->hoten}}</td>
								<td style="text-align: center">{{$ct->sdt}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- END PORTLET -->
	</div>
	@endforeach

</div>
