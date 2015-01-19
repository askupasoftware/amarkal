Amarkal.UI.register({
    wrapper: '.afw-ui-component-dropdown',
    getInput: function( wrapper ) {
        return $(wrapper).children('select');
    },
    init: function( wrapper ) {
        $(wrapper).children('select')
            .select2({width:'resolve'})
            .change(function(){
                // Fire change event
                $(this).parents('.afw-ui-component').trigger('change');
        });
    }
});