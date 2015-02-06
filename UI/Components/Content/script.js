Amarkal.UI.register({
    wrapper: '.afw-ui-component-content',
    getInput: function( wrapper ) {
        return false;
    },
    setValue: function( wrapper, value ) {},
    init: function( wrapper ) {},
    onShow: function() {
        // Resize the iframe's height to fit its content
        $(this.wrapper).each(function(){
            if( $(this).hasClass('afw-ui-component-ajaxified') && $(this).is(":visible") )
            {
                var iframe = $(this).find('.afw-ui-iframe');
                iframe.height( iframe.contents().find("html").outerHeight() );
            }
        });
        
    }
});