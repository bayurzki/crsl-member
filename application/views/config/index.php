<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table datatables">
						<thead>
							<th>No</th>
							<th>Nama</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Point</th>
							<th>Status Member</th>
							<th>#</th>
						</thead>
						<tbody>
							<?php 
							$no=1;
							foreach ($member as $key => $value) {
							$data = json_decode($value['data'], false);
							if ($value['is_member'] == 0) {
								$sta_member = 'Non Active';
								$sta_badge = 'badge-warning';
							}elseif ($value['is_member'] == 1) {
								$sta_member = 'Active';
								$sta_badge = 'badge-success';
							}else{
								$sta_member = 'Suspend';
								$sta_badge = 'badge-danger';
							}
							?>
							<tr>
								<td><?=$no++?></td>
								<td><a href="<?= base_url().'config/member/'.$value['id'].'?id='.$id ?>"><?=$data->first_name.' '.$data->last_name?></a></td>
								<td><?=$data->email?></td>
								<td><?=$data->phone?></td>
								<td><?=$value['points']?></td>
								<td><span class="badge badge-sm <?=$sta_badge?>"><?=$sta_member?></span></td>
								<td>
								<a href="#" class="btn "></a>
								<?php
								
								?>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>