Amarkal.UI.register({
    wrapper: '.afw-ui-component-checkbox',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    init: function( wrapper ) {
        $(wrapper).children('label').click(function()
        {
            var value = [];
            var parent = $(this).parent();
            var input = parent.children('input');

            if( $(wrapper).hasClass('afw-ui-component-disabled') )
            {
                return;
            }

            parent.find(':checked').each(function(){
                value.push( $(this).val() );
            });

            input.val(value);
            input.trigger('change');
        });
    }
});