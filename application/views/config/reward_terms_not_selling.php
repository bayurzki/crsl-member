<?php 
if (is_object($reward)) {
	$terms = $reward->terms;
}else{
	$terms = '';
}

if ($terms != '') {
	$terms = json_decode($decode,false);
	$minimum_order = $terms->minimum_order;
	$gift_name = $terms->gift_name;
}else{
	$minimum_order = 0;
	$gift_name = '';
}
?>
<div class="form-group form-inline">
	<label class="col-md-3 col-form-label">Minimum Order</label>
	<div class="col-md-6 p-0">
		<input type="text" name="minimum_order" value="<?=$minimum_order ?>" class="form-control input-full" />
	</div>
</div>

<div class="form-group form-inline">
	<label class="col-md-3 col-form-label">Gift Name</label>
	<div class="col-md-6 p-0">
		<input type="text" name="gift_name" value="<?=$gift_name ?>" class="form-control input-full" />
	</div>
</div>
