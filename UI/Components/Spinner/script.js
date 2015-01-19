Amarkal.UI.register({
    wrapper: '.afw-ui-component-spinner',
    getInput: function( wrapper ) {
        return $(wrapper).find('input');
    },
    init: function( wrapper ) {
        var input    = $(wrapper).find('input');
        var max      = input.attr('data-max');
        var min      = input.attr('data-min');
        var step     = input.attr('data-step');
        var disabled = input.attr('disabled');

        input.spinner({
            min: min,
            max: max,
            step: step,
            disabled: disabled
        });

        $(wrapper).find('.ui-spinner-down').detach().insertBefore(input);
        $(wrapper).find('.ui-spinner-up').html('<i class="fa fa-chevron-right"></i>')
        $(wrapper).find('.ui-spinner-down').html('<i class="fa fa-chevron-left"></i>');

        // Fire change event
        $(wrapper).find('.ui-spinner-button').click(function(){
            input.trigger('change');
        });
    }
});