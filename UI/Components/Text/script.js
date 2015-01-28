Amarkal.UI.register({
    wrapper: '.afw-ui-component-text',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    init: function( wrapper ) {
        // Since the onchange event only fires when bluring, 
        // form submission might not detect the new value. Hence this:
        $(wrapper).children('input').keyup(function(){
            $(this).parent().attr('data-value',$(this).val());
        });
    }
});