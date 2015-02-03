Amarkal.UI.register({
    wrapper: '.afw-ui-component-togglebutton',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        this.getInput(wrapper).val(value);
        values = value.split(',');
        $(wrapper).children('label').each(function(){
            if( $.inArray($(this).attr('data-value'),values) > -1 )
            {
                $(this).addClass('active');
            }
            else
            {
                $(this).removeClass('active');
            }
        });
    },
    init: function( wrapper ) {
        $(wrapper).children('label').click(function()
        {
            var value = [];
            var parent = $(this).parent();
            var input = parent.children('input');

            if( input.attr('disabled') )
            {
                return;
            }
            
            if(parent.attr('data-multivalue') === 'false')
            {
                parent.find('label').removeClass('active');
            }
            $(this).toggleClass('active');

            parent.find('.active').each(function(){
                value.push( $(this).attr('data-value') );
            });

            input.val(value);
            input.trigger('change');
        });
    }
});