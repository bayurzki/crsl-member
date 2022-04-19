<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12 m-auto">
				<div class="card">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<th>No</th>
								<th>TOKEN</th>
								<th>Total Price</th>
								<th>CUSTOMER</th>
								<th>Checkout Link</th>
							</thead>
							<tbody>
								<?php 
								// var_dump($produkna);
								// die();
								$no=1; foreach ($checkouts as $key => $value) {?>
								<tr>
									<td><?php echo $no++ ?></td>
									<td><?php echo $value['token'] ?></td>
									<td><?php echo number_format($value['total_price']) ?></td>
									<td><?php echo $value['email'] ?></td>
									<td><a href="<?php echo $value['abandoned_checkout_url'] ?>" target="_blank"><?php echo $value['abandoned_checkout_url'] ?></a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>