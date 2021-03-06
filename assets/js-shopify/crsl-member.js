function base_url(){
    //var base_url = "https://crsl-member.com/";
    var base_url = "https://crsl-member.shopify-plugin.devbdd.com/";
    return base_url   
}

if ($("div#crsl_membership").length > 0) {
	var datana = {
		'url_shopify': Shopify.shop,
		'customer_id': customer_id
	}

	$.ajax({
        type: "POST",
        url: base_url() + "membership/cek_mem",
        data: datana,
        success: function(response){
            obj = JSON.parse(response);
        	if (obj.code == 0) {
        		$("div#crsl_membership").html(
            		'<div style="margin: 35px; max-width:520px; margin: auto;">' +
	            		'<h2 style="font-size:24px; font-weight: bold;">Membership Rewards</h2>' +
	            		'<h5>'+obj.messages+'</h5>' +
	            		'<table class="table" style="width: 100%;">'+
		            		'<tr>'+
		            			'<th style="text-align: left;">Status Member</th>'+
		            			'<th style="text-align: right;">Tidak aktif</th>'+
		            		'</tr>'+
		            		'<tr>'+
		            			'<th style="text-align: left;">Akumulasi total belanja</th>'+
		            			'<th style="text-align: right;">Rp. '+obj.total_spent+'</th>'+
		            		'</tr>'+
		            		'<tr>'+
		            			'<th style="text-align: left;">Point</th>'+
		            			'<th style="text-align: right;">'+obj.point+'</th>'+
		            		'</tr>'+
	            		'</table>'+
	            	'</div>'
            	);
        	}else{
        		$("div#crsl_membership").html(
            		'<div style="margin: 35px; max-width:520px; margin: auto;">' +
	            		'<h2 style="font-size:24px; font-weight: bold;">Membership Rewards</h2>' +
	            		'<h5>'+obj.messages+'</h5>' +
	            		'<table class="table" style="width: 100%;">'+
		            		'<tr>'+
		            			'<th style="text-align: left;">Status Member</th>'+
		            			'<th style="text-align: right;">Aktif</th>'+
		            		'</tr>'+
		            		'<tr>'+
		            			'<th style="text-align: left;">Akumulasi total belanja</th>'+
		            			'<th style="text-align: right;">Rp. '+obj.total_spent+'</th>'+
		            		'</tr>'+
		            		'<tr>'+
		            			'<th style="text-align: left;">Point</th>'+
		            			'<th style="text-align: right;">'+obj.point+'</th>'+
		            		'</tr>'+
	            		'</table>'+
	            	'</div>'
            	);
        	}
        }
    });
}

$("#cek_shipping_membership").click(function(){
	var datana = {
		'url_shopify': Shopify.shop,
		'voucher_shipping': $("#shipping_code").val(),
		'customer_id': customer_id
	}

	$.ajax({
        type: "POST",
        url: base_url() + "membership/apply_shipping",
        data: datana,
        success: function(response){
        	if (response == 1){
        		var cart = jQuery.post('/cart/change.js', {
			    	line: 1,
			    	properties: { 'shipping_code': $("#shipping_code").val() }
			    });
        	}else{
        		console.log("nott");
        	}
            
        }
    });
	
	return false;
});

function redeem_reward(i){
	var datana = {
		"id_reward": i,
		"url_shopify": Shopify.shop,
		"customer_id": customer_id
	}

	$.ajax({
        type: "POST",
        url: base_url() + "membership/redeem",
        data: datana,
        success: function(response){
        	obj = JSON.parse(response);
        	if (obj.code == 3){
        		$('#result_redeem').html(
	        		'<div style="text-align:center; margin: 35px;">' +
	            		'<h1 style="margin:15px;">'+obj.title+'</h1>' +
	            		'<p>'+obj.messages+'</p>' +
	            	'</div>'
	        	);	
        	}else{
        		$('#result_redeem').html(
	        		'<div style="text-align:center; margin: 35px;">' +
	            		'<h1 style="margin:15px;">Congratulations!</h1>' +
	            		'<h3>You\'ve successfully redeemed a Gift, for more info admin will contact you.</h3>' +
	            	'</div>'
	        	);	
        	}
        }
    });
}