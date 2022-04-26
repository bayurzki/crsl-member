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
	if (property_exists($terms, 'condition')) {
		$con = $terms->condition;
		if ($con == 'include') {
			$show_div = '';
			$selected_in = 'selected';
			$selected_ex = '';
			$selected_all = '';
		}elseif ($con == 'exclude'){
			$show_div = '';
			$selected_ex = 'selected';
			$selected_in = '';
			$selected_all = '';
		}else{
			$show_div = 'hide';
			$selected_all = 'selected';
			$selected_ex = '';
			$selected_in = '';
		}
	}else{
		$con = NULL;
		$show_div = 'hide';
		$selected_in = '';
		$selected_ex = '';
		$selected_all = '';
	}
	
}else{
	$minimum_order = 0;
	$max_discount = 0;
	$con = 0;
	$show_div = 'hide';
	$selected_in = '';
	$selected_ex = '';
	$selected_all = '';
}
var_dump($con,$show_div);
?>
<div class="form-group form-inline">
	<label class="col-md-3 col-form-label">Minimum Order</label>
	<div class="col-md-6 p-0">
		<input type="text" name="minimum_order" value="<?=$minimum_order ?>" class="form-control input-full" />
	</div>
</div>

<div class="form-group form-inline">
	<label class="col-md-3 col-form-label">Maximum Discount</label>
	<div class="col-md-6 p-0">
		<input type="text" name="max_discount" value="<?=$max_discount ?>" class="form-control input-full" />
	</div>
</div>

<div class="form-group form-inline">
	<label class="col-md-3 col-form-label">Condition</label>
	<div class="col-md-6 p-0">
		<select name="condition" class="form-control" onchange="add_collection()">
			<option value="all" <?=$selected_all?>>All</option>
			<option value="include" <?=$selected_in?>>Include Collection</option>
			<option value="exclude" <?=$selected_ex?>>Exclude Collection</option>
		</select>
	</div>
</div>
<div id="btn-collection" class="<?=$show_div?>">
	<div class="row">
		<div class="col-md-5 pr-5">
			<button type="button" class="float-right btn btn-info btn-sm" onclick="get_collection()" data-toggle="modal">Add Collection</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-7">
			<div id="selected-include">
				<div class="card-list">
					<?php if (property_exists($terms, 'condition')) {
					if ($con == 'include') {
						$col = json_decode($terms->collection);
						for ($i=0; $i < sizeof($col) ; $i++) { 
					?>
					<div class="item-list" data-type="<?=$con?>" data-id="<?=$col[$i]?>">
						<div class="pl-3"><?=$col[$i]?> <input type="hidden" name="col_inc[]" value="<?=$col[$i]?>" /></div>
						<div class="pl-5"><a href="#" onclick="remove_selected(<?=$col[$i]?>)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></div>
					</div>
					<?php
						}
					} }?>
				</div>
			</div>
			<div id="selected-exclude">
				<div class="card-list">
					<?php if (property_exists($terms, 'condition')) {
					if ($con == 'exclude') {
						$col = json_decode($terms->collection);
						for ($i=0; $i < sizeof($col) ; $i++) { 
					?>
					<div class="item-list" data-type="<?=$con?>" data-id="<?=$col[$i]?>">
						<div class="pl-3"><?=$col[$i]?> <input type="hidden" name="col_exl[]" value="<?=$col[$i]?>" /></div>
						<div class="pl-5"><a href="#" onclick="remove_selected(<?=$col[$i]?>)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></div>
					</div>
					<?php
						}
					} }?>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal-col" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Select Collection</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" >
				<table class="table" id="select-collections"></table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function add_collection(){
		var con = $('select[name="condition"]').val();
		console.log(con);
		if (con == 'include' || con == 'exclude') {
			$('#btn-collection').removeClass('hide');
			if (con == 'include') {
				$('#selected-include').removeClass('hide');
				$('#selected-exclude').addClass('hide');
			}else{
				$('#selected-exclude').removeClass('hide');
				$('#selected-include').addClass('hide');
			}
		}else{
			$('#btn-collection').addClass('hide');
			$('#selected-include').addClass('hide');
			$('#selected-exclude').addClass('hide');
		}
	}

	function get_collection(){
		var id_ = "<?=$id?>";
		var con = $('select[name="condition"]').val();
	    var urlna = "<?=base_url().'/config/get_collection/' ?>";
	    $.ajax({
	        url: urlna,  
	        type: 'POST',
	        data: {
	        	id: id_
	        },
	        success:function(data){
	        	$('#modal-col').modal('toggle');
	        	console.log(data)
                var obj = JSON.parse(data);
                var list_collection = [];
                for (var i = 0; i < obj.length; i++) {
                	if ($('.item-list[data-type='+con+'][data-id='+obj[i].id+']').length > 0){
                		btn_show = 'none';
                	}else{
                		btn_show = 'block'
                	}
                	list_collection[i] = '\
                	<tr>	\
                	<td>'+(parseInt(i)+parseInt(1)) +'</td>	\
                	<td>'+obj[i].title+'</td>	\
                	<td><a href="#" data-id="'+obj[i].id+'" data-value="'+obj[i].title+'" class="btn btn-xs btn-primary added_col_'+i+'" data-type="'+con+'" onclick="added_col('+i+')" style="display: '+btn_show+'"><i class="fa fa-plus"></i></a></td>	\
                	</tr>\
                	';
                }
	            $("#select-collections").html(list_collection);

	        }
	    });
	}
	
	function added_col(e){
		var con = $('select[name="condition"]').val();
       	$('.added_col_'+e+'[data-type='+con+']').hide();
		if (con == 'include') {
			var html = '\
			<div class="item-list" data-type="'+con+'" data-id="'+$(".added_col_"+e).attr('data-id')+'">\
				<div class="pl-3">'+$(".added_col_"+e).attr('data-value')+' <input type="hidden" name="col_inc[]" value="'+$(".added_col_"+e).attr('data-id')+'" /></div>\
				<div class="pl-5"><a href="#" onclick="remove_selected('+$(".added_col_"+e).attr('data-id')+')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></div>\
			</div>\
			';
			$(html).appendTo($("#selected-include > .card-list"));
		}else{
			var html = '\
			<div class="item-list" data-type="'+con+'" data-id="'+$(".added_col_"+e).attr('data-id')+'">\
				<div class="pl-3">'+$(".added_col_"+e).attr('data-value')+' <input type="hidden" name="col_exl[]" value="'+$(".added_col_"+e).attr('data-id')+'" /></div>\
				<div class="pl-5"><a href="#" onclick="remove_selected('+$(".added_col_"+e).attr('data-id')+')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></div>\
			</div>\
			';
			$(html).appendTo($("#selected-exclude > .card-list"));
		}
		$('#modal-col').modal('toggle');

		// setTimeout(function(){
		// 	$('#modal-col').modal('toggle');
		// },300)
	}
</script>