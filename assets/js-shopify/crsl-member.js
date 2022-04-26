if ($("div#crsl_membership").length > 0) {
	var base_url = "https://crsl-member.com/";
	var datana = {
		'url_shopify': Shopify.shop,
		'customer_id': customer_id
	}

	$.ajax({
        type: "POST",
        url: base_url + "membership/cek_mem",
        data: datana,
        success: function(response){
            obj = JSON.parse(response);
        	if (obj.code == 0 || obj.code == 404) {
        		$("div#crsl_membership").html(
            		'<div style="text-align:center; margin: 35px;">' +
	            		'<h1 style="margin:15px;">Membership Rewards</h1>' +
	            		'<h3>You`re not registered as member, please contact administrator.</h3>' +
	            	'</div>'
            	);
        	}else{
        		$("div#crsl_membership").html(
            		'<div style="text-align:center; margin: 35px;">' +
	            		'<h1 style="margin:15px;">Membership Rewards</h1>' +
	            		'<h3>Point:'+obj.point+'</h3>' +
	            		'<h3>Total Spent:'+obj.total_spent+'</h3>' +
	            	'</div>'
            	);
        	}
        }
    });
}