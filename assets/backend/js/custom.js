$(document).ready(function() {
    $('#sukses_notif').hide();
    $("#edit_range").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
                $('.modal').modal('hide');
            },
            success: function(response){
                if (response === '1') {
                    $('#sukses_notif').show();
                }
            }
        });
    });

    $("#contact-mail").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
                $('.modal').modal('hide');
            },
            success: function(response){
                if (response == '1') {
                    swal({title: "Success", text: "Messages sent." , type: "success", icon: "success"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }else{
                    swal({title: "Error", text: "Something wrong." , type: "error", icon: "error"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }
            }
        });
    });

    $("#manual-form").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
            },
            success: function(response){
                if (response == '0') {
                    swal({title: "Error", text: "Product not found, Please read the documentation." , type: "error", icon: "error"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }else{
                    swal({title: "Success", text: "Configuration saved." , type: "success", icon: "success"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }
            }
        });
    });

    $("#request_install").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
                $('.modal').modal('hide');
            },
            success: function(response){
                if (response == '0') {
                    swal({title: "Error", text: "Product not found, Please read the documentation." , type: "error", icon: "error"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }else{
                    swal({title: "Success", text: "Request sent" , type: "success", icon: "success"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }
            }
        });
    });

});