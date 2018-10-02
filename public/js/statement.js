$( document ).ready(function() {
    CKEDITOR.replace('editor1',
    {
        height: 500
    });
    
    var stat_class = new StatementClass($('#statement_origin').text());    
    
    $('#use_vars').click(function(){
        var set = $('#state_vars_block input');
        var length = set.length;
        set.each(function(index){
            stat_class.getInput([$(this).attr('name'), $(this).val()]);
            if (index === (length - 1)) {
                stat_class.refresh();
            }
        });
    });
    
    $('#use_vars').trigger('click');
    
    $('#comment_submit').click(function(){
        $.ajax({
            url:    '/statementComments',
            type:   "POST",
            dataType:   "json",
            data: { text: $("#comment_text").val(), statement_id: $("#statement_id").val() },
            async: true,
            complete: function (data){
                $('.card-body').html(data.responseText);
            }
        });
        return false;
    });
});

