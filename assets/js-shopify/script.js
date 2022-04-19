(function($){
  
    var cartItems = cart_items,
        qtyInTheCart = 0,
        cartUpdates = [];
        for (var i=0; i<cartItems.length; i++) {
          if ( cartItems[i].id === variant_id ) {
            qtyInTheCart = cartItems[i].quantity;
            break;
          }
        }

        if ( ( cartItems.length === 1 ) && ( qtyInTheCart > 0 ) ) {
          cartUpdates = {[variant_id]: 0};
        }else if ( ( cartItems.length >= 1 ) && ( qtyInTheCart !== 1 ) ) {
          cartUpdates = {[variant_id]: 1};
        }else {
          return;
        }

        console.log(cartUpdates);
        
            var params = {
              type: 'POST',
              url: '/cart/update.js',
              data: { updates: cartUpdates },
              dataType: 'json',
              success: function(stuff) { 
                setTimeout(function(){
                    console.log(cartUpdates);
                    //window.location = '/checkout';
                    location.reload();
                }, 3000);
              }
            };
            $.ajax(params);
})(jQuery);

