<?php
if (is_object($reward)) {
	$reward_id = $reward->id;
	$title = $reward->title;
	$type = $reward->type;
	$terms = $reward->terms;
	$point = $reward->point;
	$multi_use = $reward->multi_use;
	$create_at = $reward->create_at;
	$update_at = $reward->update_at;
}else{
	$reward_id = 0;
	$title = '';
	$type = 0;
	$terms = '';
	$point = '';
	$multi_use = '';
	$create_at = '';
	$update_at = '';
}
?>
<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<form class="form" action="<?= base_url().'config/reward_save' ?>" method="post">
					<div class="form-group form-inline">
						<label class="col-md-3 col-form-label">Name</label>
						<div class="col-md-6 p-0">
							<input type="hidden" name="shop_id" value="<?=$id?>" />
							<input type="hidden" name="id" value="<?=$reward_id?>" />
							<input type="text" name="title" value="<?=$title?>" class="form-control input-full" />
						</div>
					</div>

					<div class="form-group form-inline">
						<label class="col-md-3 col-form-label">Type</label>
						<div class="col-md-6 p-0">
							<select name="type" class="form-control" onchange="get_type()">
								<option value="0" <?php if ($type == 0) { echo "selected"; } ?>>Discount Shipping</option>
								<option value="1" <?php if ($type == 1) { echo "selected"; } ?>>Selling Product</option>
								<option value="2" <?php if ($type == 2) { echo "selected"; } ?>>Not Selling Product</option>
							</select>
						</div>
					</div>
					<div id="terms"></div>
					

					<div class="form-group form-inline">
						<label class="col-md-3 col-form-label">Point</label>
						<div class="col-md-6 p-0">
							<input type="text" name="point" value="<?=$point?>" class="form-control input-full" />
						</div>
					</div>

					<div class="form-group form-inline">
						<label class="col-md-3 col-form-label">Multi Use</label>
						<div class="col-md-6 p-0">
							<select name="multi_use" class="form-control">
								<option value="0" <?php if ($multi_use == 0) { echo "selected"; } ?>>No</option>
								<option value="1" <?php if ($multi_use == 1) { echo "selected"; } ?>>Yes</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-md-9">
							<div class="form-gorup form-inline float-right">
								<button type="submit" value="Submit" class="btn btn-sm btn-info">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
init_type();
function init_type(){
	var id_ = "<?=$id?>";
	var type = "<?=$type?>";
    var urlna = "<?=base_url().'/config/form_terms/' ?>";
    $.ajax({
        url: urlna,  
        type: 'POST',
        data: {
        	type: type,
        	id: id_
        },
        success:function(data){
            $("#terms").html(data)
        }
    });
}

function get_type(){
	var id_ = "<?=$id?>";
	var type = $('select[name="type"]').val();
    var urlna = "<?=base_url().'/config/form_terms/' ?>";
    $.ajax({
        url: urlna,  
        type: 'POST',
        data: {
        	type: type,
        	id: id_
        },
        success:function(data){
            $("#terms").html(data)
        }
    });
}
</script>
