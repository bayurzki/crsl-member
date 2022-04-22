<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<form class="form" action="<?= base_url().'config/earn_save' ?>" method="post">
					<div class="form-group form-inline">
						<label class="col-md-3 col-form-label">Name</label>
						<div class="col-md-6 p-0">
							<input type="hidden" name="shop_id" value="<?=$id?>" />
							<input type="hidden" name="id" value="<?=$earn->id?>" />
							<input type="text" name="nama" value="<?=$earn->nama?>" class="form-control input-full" disabled />
						</div>
					</div>
					<?php
					if ($earn->id == 1) {
					?>
					<div class="form-group form-inline">
						<label class="col-md-3 col-form-label">Type</label>
						<div class="col-md-6 p-0">
							<select name="type" class="form-control">
								<option value="0" <?php if ($earn->type == 0) { echo "selected"; } ?>>Flat every order</option>
								<option value="1" <?php if ($earn->type == 1) { echo "selected"; } ?>>Adjustable to order amount</option>
							</select>
						</div>
					</div>
					<?php
					}else{
						echo '<input type="hidden" name="type" value="'.$earn->type.'" />';
					}
					?>

					<div class="form-group form-inline">
						<label class="col-md-3 col-form-label">Point</label>
						<div class="col-md-6 p-0">
							<input type="text" name="point" value="<?=$earn->point?>" class="form-control input-full" />
						</div>
					</div>

					<div class="form-group form-inline">
						<label class="col-md-3 col-form-label">Status</label>
						<div class="col-md-6 p-0">
							<select name="is_active" class="form-control">
								<option value="0" <?php if ($earn->is_active == 0) { echo "selected"; } ?>>Disable</option>
								<option value="1" <?php if ($earn->is_active == 1) { echo "selected"; } ?>>Enable</option>
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