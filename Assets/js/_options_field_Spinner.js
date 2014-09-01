jQuery(document).ready(function($){
    $('.ao-field-spinner').each(function(){
        var input = $(this).find('input');
        var maxvalue = input.attr('data-maxvalue');
        var minvalue = input.attr('data-minvalue');
        var step = input.attr('data-step');
        var disabled = input.attr('disabled');
        
        input.spinner({
            min: minvalue,
            max: maxvalue,
            step: step,
            disabled: disabled
        });
        
        $(this).find('.ui-spinner-down').detach().insertBefore(input);
        $(this).find('.ui-spinner-up').html('<i class="fa fa-chevron-right"></i>')
        $(this).find('.ui-spinner-down').html('<i class="fa fa-chevron-left"></i>');
    });
});