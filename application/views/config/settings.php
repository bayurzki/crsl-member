<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table datatables">
						<thead>
							<th>No</th>
							<th>Trigger</th>
							<th>Type</th>
							<th>Point</th>
							<th>Status</th>
							<th>Updated at</th>
							<th>#</th>
						</thead>
						<tbody>
						<?php 
						$no=1;
						foreach ($earns as $key => $value) {
							if ($value['type'] == 0) {
								$type = 'Flat';
							}else{
								$type = 'Adjustable';
							}

							if ($value['is_active'] == 0) {
								$icon = 'fa-close';
								$badge = 'badge-danger';
								$btn = 'btn-danger';
								$title = 'Disable';
							}else{
								$icon = 'fa-check';
								$btn = 'btn-success';
								$title = 'Enable';
								$badge = 'badge-info';
							}
						?>
							<tr>
								<td><?=$no++?></td>
								<td><?=$value['event']?></td>
								<td><?=$type?></td>
								<td><?=$value['point']?></td>
								<td><span class="badge <?=$badge?>"><?=$title?></span></td>
								<td><?=date('d-m-Y H:i', strtotime($value['update_at']))?></td>
								<td>
									<!-- <a href="#" class="btn btn-xs <?=$btn?>" title="<?=$title?>"><i class="fa <?=$icon?>"></i></a> -->
									<a href="<?= base_url().'config/update_earn/'.$value['id'].'?id='.$id ?>" class="btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
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