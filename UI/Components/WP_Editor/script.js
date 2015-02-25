Amarkal.UI.register({
    wrapper: '.afw-ui-component-wp-editor',
    getInput: function( wrapper ) {
        return $(wrapper).find('textarea');
    },
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        this.getInput(wrapper).val( value );
    },
    init: function( wrapper ) {
        
    }
});