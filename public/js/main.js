$( document ).ready(function() {
    $('#statementRequest').click(function(){
        $.ajax({
                url:    '/requestStatement',
                type:   "POST",
                dataType:   "json",
                async: true,
                complete: function (data){
                    $('#modal_content').html(data.responseText);
                    $('#statement_request_submit').click(function(){
                        $.ajax({
                            url:    '/requestStatement',
                            type:   "POST",
                            dataType:   "json",
                            data: { text: $("#modal_content form #form_text").val() },
                            async: true,
                            complete: function (data){
                                $('#modal_content').html(data.responseText);
                            }
                        });
                        return false;
                    });
                }
        }); 
    });
    
    $('#_submit').click(function(){
        $(this).html('<div style="color:#fff" class="ld ld-ring ld-spin"></div>').prop('disabled', true);
        $.ajax({
                url:    $('#login_form').attr('action'),
                type:   "POST",
                dataType:   "json",
                data: $('#login_form').serialize(),
                async: true,
                complete: function (data){
                    if(data.responseJSON.success == false){
                        $('#login_error').show();
                        $('#_submit').html('Войти').prop('disabled', false);
                    }
                    else
                        location.reload();
                }                
        }); 
        return false;
    });
});

