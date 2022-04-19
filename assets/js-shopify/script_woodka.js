(function($){
    var cartItems = cart_items, // attribute yg ada di cart
        qtyInTheCart = 0,
        cartUpdates = [];
        for (var i=0; i<cartItems.length; i++) {
          if ( cartItems[i].id == '35669138833573' ) {
            qtyInTheCart = cartItems[i].quantity;
            break;
          }
        }
        console.log(cartItems.length + ' - ' + qtyInTheCart);
        if ( ( cartItems.length === 1 ) && ( qtyInTheCart > 0 ) ) {
          cartUpdates = {35669138833573: 0};
        }else if ( ( cartItems.length >= 1 ) && ( qtyInTheCart !== 1 ) ) {
          cartUpdates = {35669138833573: 1};
        }else {
          return;
        }
        
        
            var params = {
              type: 'POST',
              url: '/cart/update.js',
              data: { updates: cartUpdates },
              dataType: 'json',
              success: function(stuff) { 
                setTimeout(function(){
                    //console.log(cartUpdates);
                    //window.location = '/checkout';
                    location.reload();
                }, 3000);
              },
              error: function (request, status, error) {
                  console.log(request.responseText);
              }
            };
            $.ajax(params);
})(jQuery);
