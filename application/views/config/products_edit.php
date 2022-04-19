<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<?php
				if ($type_cart == 'drawer') {
				?>
				
				<span class="sec-note">
					Your themes have cart with type 'Drawer', please change to type 'Page'. Online Store > Themes > Customize > Theme Settings > Cart page.
				</span>
				<?php
				}

				if ($cart_tf == 1) {
					echo '
					<span class="sec-note">
					Please hide cart drawer in Online Store > Themes > Customize > Theme Settings > Cart drawer > uncheck.
					</span>
					';
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 m-auto">
				<div class="card">
					<?php
					if ($merchant_row->id_variant != NULL) { 
						$product = $this->shopify->shopify_call($merchant_row->token_store, $merchant_row->url_shopify, "/admin/api/2020-01/variants/".$merchant_row->id_variant.".json", array(), 'GET');
						$produkna = json_decode($product['response'], TRUE);
						
						$products = $this->shopify->shopify_call($merchant_row->token_store, $merchant_row->url_shopify, "/admin/api/2020-01/products/".$produkna['variant']['product_id'].".json", array(), 'GET');
						$products = json_decode($products['response'], TRUE);

						
					?>
					<span class="badge badge-success" id="sukses_notif">Success!</span>
					<table class="table">
						<tr>
							<th>Active</th>
							<td>:</td>
							<td>
							<?php
							if ($merchant_row->id_script_tags != NULL AND $merchant_row->id_script_tags != '' AND $is_active ) {
								$checkna = 'checked';
							}else{
								$checkna = '';
							}
							?>
								<label class="switch">
								  	<input type="checkbox" id="app_active" onchange="app_active()" <?php echo $checkna ?>>
								  	<span class="slider round"></span>
								</label>
							</td>
						</tr>
						<tr>
							<th>Code Range</th>
							<td>:</td>
							<td>
								<form action="<?php echo base_url().'otomatisasi/save_coderange' ?>" id="edit_range" onsubmit="edit_range()">
									<input type="hidden" name="id_merchant" value="<?php echo $merchant_row->id_merchant ?>">
									<input type="hidden" name="url_shopify" value="<?php echo $merchant_row->url_shopify ?>" id="url_shopify">
									<input type="hidden" name="themesna" value="<?php echo $themesna['id'] ?>" id="themesna">
									<div class="form-group form-inline">
										<input type="text" name="start_code" class="form-control" value="<?php echo $merchant_row->start_code ?>" /> 
										<input type="text" name="end_code" class="form-control" value="<?php echo $merchant_row->end_code ?>" />
										<button type="submit" class="btn btn-sm btn-primary">Save</button>
									</div>
								</form>
							</td>
						</tr>
						<tr>
							<th>Unique Code Transaction</th>
							<td>:</td>
							<th><?php echo $produkna['variant']['price']?></th>
						</tr>
						<tr>
							<th>Mandatory Code</th>
							<td>:</td>
							<th><pre><?php echo $products['product']['handle']?></pre></th>
						</tr>
					</table>
					
					
					
					<?php }?>
				</div>

				<!-- <div class="card">
					<div class="btn-carana">
						<a href="#">Complete your configuration with.</a>
						<i class="fa caret-square-up"></i>
					</div>
					<div class="card-body">
						<div>
							Add this script to file Layout/theme.liquid before tag <?php //echo htmlspecialchars('</head>', ENT_QUOTES) ?>
							<pre>{% include 'bdd-uniquetrans' %}</pre>
						</div>
					</div>	
				</div> -->

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function edit_range(){
		var form = $('#edit_range');
        var urlna_ = form.attr('action');
        $.ajax({
            type: "POST",
            url: urlna_,
            data: form.serialize(), 
            beforeSend: function() {
		        $('#load-before-send').removeClass('hide');
		    },
            success: function(response){
                swal({title: "Success", text: "Code Range updated" , type: "success", icon: "success"}).then(function(){ 
                	$('#load-before-send').addClass('hide');
		   			location.reload();
		   		});
            }
        });
	}

	function app_active(){
        var mode= $('#app_active').prop('checked');
        var urlna_ = "<?=base_url().'otomatisasi/app_active' ?>";
        var datana = {
            url_shopify: $('#url_shopify').val(),
            themesna: $('#themesna').val(),
            mode: mode
        };
        $.ajax({
            type: "POST",
            url: urlna_,
            data: datana,
            beforeSend: function() {
		        $('#load-before-send').removeClass('hide');
		    },
            success: function(result) {
                swal({title: "Success", text: result , type: "success", icon: "success"}).then(function(){ 
                	$('#load-before-send').addClass('hide');
		   			location.reload();
		   		});
            }
        });
	}
</script>