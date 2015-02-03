Amarkal.UI.register({
    wrapper: '.afw-ui-component-textarea',
    getInput: function( wrapper ) {
        return $(wrapper).find('textarea');
    },
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        this.getInput(wrapper).val( value );
    },
    init: function( wrapper ) {
        this.getInput(wrapper).resizable({
            minHeight: 150,
            minWidth: 250
        });
        $(wrapper).find('.ui-resizable-s').html('<i class="fa fa-bars"></i>');
        $(wrapper).find('.ui-resizable-e').html('<i class="fa fa-bars fa-rotate-90"></i>');
    }
});