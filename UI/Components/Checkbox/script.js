Amarkal.UI.register({
    wrapper: '.afw-ui-component-checkbox',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        this.getInput(wrapper).value = value;
        values = value.split(',');
        
        $(wrapper).children('label').each(function() {
            var input = $(this).children('input');
            input.prop('checked', $.inArray(input.val(),values) > -1);
        });
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