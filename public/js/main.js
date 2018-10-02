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
});

