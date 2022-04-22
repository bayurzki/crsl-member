<?php
$datana = json_decode($member->data,false);
$customer = $this->shopify->api_get($shop->url_shopify,'customers/'.$datana->id.'.json',$shop->token_store);
$customer = json_decode($customer,false);
$customer = $customer->customer;
// echo "<pre>";
// var_dump($customer);
// echo "</pre>";
?>
<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr>
						<th>Name</th>
						<td>:</td>
						<th><?= $datana->first_name.' '.$datana->last_name ?></th>

						<th>Email</th>
						<td>:</td>
						<th><?= $datana->email?></th>
					</tr>

					<tr>
						<th>Phone</th>
						<td>:</td>
						<th><?= $datana->phone?></th>

						<th>Total Spent</th>
						<td>:</td>
						<th><?= number_format($customer->total_spent)?> </th>
					</tr>

					<tr>
						<th>Last Order</th>
						<td>:</td>
						<th><?= $customer->last_order_name?></th>

						<th>Point Balance</th>
						<td>:</td>
						<th><?= number_format($member->points)?> <a href="#" class="btn btn-xs btn-info ml-3">Adjust Point Balance</a></th>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h5>History Earning</h5>
					</div>
					<div class="card-body">
						<div class="card-list">
							<div class="item-list">
								<div class="info-user">
									<div class="username">
										voucher code
									</div>
									<div class="status">
										date
									</div>
								</div>
								<span class="badge badge-success">tes</span>
							</div>
							<div class="item-list">
								<div class="info-user">
									<div class="username">
										voucher code
									</div>
									<div class="status">
										date
									</div>
								</div>
								<span class="badge badge-success">tes</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h5>History Redeem</h5>
					</div>
					<div class="card-body">
						<div class="card-list">
							<div class="item-list">
								<div class="info-user">
									<div class="username">
										voucher code
									</div>
									<div class="status">
										date
									</div>
								</div>
								<span class="badge badge-warning">tes</span>
							</div>
							<div class="item-list">
								<div class="info-user">
									<div class="username">
										voucher code
									</div>
									<div class="status">
										date
									</div>
								</div>
								<span class="badge badge-warning">tes</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>