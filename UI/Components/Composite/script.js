Amarkal.UI.register({
    wrapper: '.afw-ui-composite-component',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    setValue: function( wrapper, value ) {
        // Can't reverse composite value into individual component values.
        throw "Composite components cannot dynamically change value";
    },
    init: function( wrapper ) {
        $(wrapper).find('.afw-ui-component').change(function(){
            var input       = $(this).parent().parent().children('input'),
                components  = $(this).parent().parent().find('.afw-ui-component'),
                template    = input.attr('data-template');
            
            // Update the composite component master value, using the template
            input.val(template);
            for( var i = 0; i < components.length; i++ )
            {
                var value = input.val(),
                    c     = $(components[i]);
                input.val(value.replace('<% '+c.attr('data-name')+' %>', c.attr('data-value')));
            }
        });
    }
});