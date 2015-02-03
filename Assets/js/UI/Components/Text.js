Amarkal.UI.register({
    wrapper: '.afw-ui-component-text',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        this.getInput(wrapper).val( value );
        
    },
    init: function( wrapper ) {
        // Since the onchange event only fires when bluring, 
        // form submission might not detect the new value. Hence this:
        this.getInput(wrapper).keyup(function(){
            $(this).parent().attr('data-value',$(this).val());
        });
    }
});