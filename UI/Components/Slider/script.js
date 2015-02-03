Amarkal.UI.register({
    wrapper: '.afw-ui-component-slider',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    // value must be array if this is a range type slider
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        if( $(wrapper).attr('data-type') === 'range' )
        {
            $(wrapper).find('.slider').slider('values', value);
        }
        else
        {
            $(wrapper).find('.slider').slider('value', value);
        }
    },
    init: function( wrapper ) {
        
        var max = parseFloat( $(wrapper).attr('data-max') );
        var min = parseFloat( $(wrapper).attr('data-min') );
        var step = parseFloat( $(wrapper).attr('data-step') );
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