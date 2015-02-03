Amarkal.UI.register({
    wrapper: '.afw-ui-component-dropdown',
    getInput: function( wrapper ) {
        return $(wrapper).children('select');
    },
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        this.getInput(wrapper).select2("val", value);
    },
    init: function( wrapper ) {
        this.getInput(wrapper)
            .select2({width:'resolve'})
            .change(function(){
                // Fire change event
                $(this).parents('.afw-ui-component').trigger('change');
        });
    }
});