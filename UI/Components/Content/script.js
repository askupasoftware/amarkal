Amarkal.UI.register({
    wrapper: '.afw-ui-component-content',
    getInput: function( wrapper ) {
        return false;
    },
    setValue: function( wrapper, value ) {},
    init: function( wrapper ) {
        
        // Resize the iframe's height to fit its content
        if( $(wrapper).hasClass('afw-ui-component-ajaxified') )
        {
            $(wrapper).find('.afw-ui-iframe').load(function() {
                $(this).height( $(this).contents().find("html").outerHeight() );
            });
        }
    }
});