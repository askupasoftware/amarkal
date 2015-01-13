jQuery(document).ready(function($){
    $('.ao-field-slider').each(function(){
        
        var max = parseInt( $(this).attr('data-max') );
        var min = parseInt( $(this).attr('data-min') );
        var step = parseInt( $(this).attr('data-step') );
        var type = $(this).attr('data-type');
        var disabled = $(this).attr('disabled');
        
        if( type === 'range' )
        {
            var inputs = $(this).find('input');
            
            $(this).children('.slider').slider({
                min: min,
                max: max,
                step: step,
                range: true,
                disabled: disabled,
                values: [ parseInt( inputs[0].value ), parseInt( inputs[1].value )],
                slide: function( event, ui ) {
                    inputs[0].value = ui.values[0];
                    inputs[1].value = ui.values[1];
                    $(this).parents('.field-wrapper').trigger('change');
                }
            });
        }
        else
        {
            var input = $(this).find('input');
            
            $(this).children('.slider').slider({
                min: min,
                max: max,
                step: step,
                range: type,
                disabled: disabled,
                value: parseInt( input.val() ),
                slide: function( event, ui ) {
                    input.val( ui.value );
                    $(this).parents('.field-wrapper').trigger('change');
                }
            });
        }
        
        $(this).find('.ui-slider-handle').html('<i class="fa fa-navicon fa-rotate-90"></i>');
    });
});