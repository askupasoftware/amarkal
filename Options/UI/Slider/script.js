jQuery(document).ready(function($){
    $('.ao-field-slider').each(function(){
        var input = $(this).find('input');
        var max = input.attr('data-max');
        var min = input.attr('data-min');
        var step = input.attr('data-step');
        var disabled = input.attr('disabled');
        
        $(this).children('.slider').slider({
            min: parseInt( min ),
            max: parseInt( max ),
            step: parseInt( step ),
            disabled: disabled,
            value: parseInt( input.val() ),
            slide: function( event, ui ) {
                input.val( ui.value );
            }
        });
        
        $(this).find('.ui-slider-handle').html('<i class="fa fa-navicon fa-rotate-90"></i>');
    });
});