Amarkal.UI.register({
    wrapper: '.afw-ui-component-slider',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    init: function( wrapper ) {
        
        var max = parseInt( $(wrapper).attr('data-max') );
        var min = parseInt( $(wrapper).attr('data-min') );
        var step = parseInt( $(wrapper).attr('data-step') );
        var type = $(wrapper).attr('data-type');
        var disabled = $(wrapper).hasClass('afw-ui-component-disabled');

        if( type === 'range' )
        {
            var inputs = $(wrapper).find('input');

            $(wrapper).find('.slider').slider({
                min: min,
                max: max,
                step: step,
                range: true,
                disabled: disabled,
                values: [ parseInt( inputs[0].value ), parseInt( inputs[1].value )],
                slide: function( event, ui ) {
                    inputs[0].value = ui.values[0];
                    inputs[1].value = ui.values[1];
                    inputs.trigger('change');
                }
            });
        }
        else
        {
            var input = $(wrapper).find('input');

            $(wrapper).find('.slider').slider({
                min: min,
                max: max,
                step: step,
                range: type,
                disabled: disabled,
                value: parseInt( input.val() ),
                slide: function( event, ui ) {
                    input.val( ui.value );
                    input.trigger('change');
                }
            });
        }

        $(wrapper).find('.ui-slider-handle').html('<i class="fa fa-navicon fa-rotate-90"></i>');
    }
});