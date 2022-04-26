<?php 
if (is_object($reward)) {
	$terms = $reward->terms;
}else{
	$terms = '';
}

if ($terms != '') {
	$terms = json_decode($reward->terms,false);
	$minimum_order = $terms->min_order;
	$max_discount = $terms->max_discount;
}else{
	$minimum_order = 0;
	$max_discount = 0;
}
?>
	<div class="form-group form-inline">
		<label class="col-md-3 col-form-label">Minimum Order</label>
		<div class="col-md-6 p-0">
			<input type="text" name="minimum_order" value="<?=$minimum_order ?>" class="form-control input-full" />
		</div>
	</div>

	<div class="form-group form-inline">
		<label class="col-md-3 col-form-label">Maximum Shipping Discount</label>
		<div class="col-md-6 p-0">
			<input type="text" name="max_discount" value="<?=$max_discount ?>" class="form-control input-full" />
		</div>
	</div>
