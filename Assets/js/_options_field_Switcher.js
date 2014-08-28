jQuery(document).ready(function($){
    $('.ao-field-switcher').children('label').click(function()
    {
        var value = [];
        var parent = $(this).parent();
        
        if(parent.hasClass('singlevalue'))
        {
            parent.find('label').removeClass('active');
        }
        $(this).toggleClass('active');
        
        parent.find('.active').each(function(){
            value.push( $(this).attr('data-value') );
        });
        console.log(value.join(','));
        
        parent.children('input').val(value);
    });
});