jQuery(document).ready(function($){
    $('.ao-field-switcher').children('label').click(function()
    {
        var value = [];
        var parent = $(this).parent();
        var input = parent.children('input');
        var disabled = input.attr('disabled');
        
        if( !disabled )
        {
            if(parent.hasClass('singlevalue'))
            {
                parent.find('label').removeClass('active');
            }
            $(this).toggleClass('active');
        }
        
        parent.find('.active').each(function(){
            value.push( $(this).attr('data-value') );
        });
        
        input.val(value);
    });
});