<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="ml-3 mb-3">
					<a href="<?= base_url().'config/reward_form?id='.$id ?>" class="btn btn-sm btn-info">Add Rewards</a> 
					<!-- <a href="<?= base_url().'config/reward_form?id='.$id.'&data_id=1' ?>" class="btn btn-sm btn-info">Add Rewards</a> -->
				</div>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table datatables">
						<thead>
							<th>No</th>
							<th>Name</th>
							<th>Type</th>
							<th>Multi Use</th>
							<!-- <th>Terms</th> -->
							<th>Point</th>
							<th>Page Reward</th>
							<!-- <th>Created at</th> -->
							<th>#</th>
						</thead>
						<tbody>
						<?php 
						$no=1;
						foreach ($rewards as $key => $value) {
							if ($value['type'] == 0) {
								$type = 'Shipping Discount';
							}elseif ($value['type'] == 1) {
								$type = 'Voucher Discount';
							}else{
								$type = 'Gift';
							}

							if ($value['multi_use'] == 0) {
								$title = 'No';
							}else{
								$title = 'Yes';
							}
						?>
							<tr>
								<td><?=$no++?></td>
								<td><?=$value['title']?></td>
								<td><?=$type?></td>
								<td><?=$title?></td>
								<!-- <td><?=$value['terms']?></td> -->
								<td><?=$value['point']?></td>
								<td><a href=""><?=$value['url_redeem']?></a></td>
								
								<td>
									<a href="<?= base_url().'config/reward_form?id='.$id.'&data_id='.$value['id'] ?>" class="btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
								</td>
							</tr>
						<?php } ?>								
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>