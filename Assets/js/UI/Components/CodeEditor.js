Amarkal.UI.register({
    wrapper: '.afw-ui-component-code-editor',
    getInput: function( wrapper ) {
        return $(wrapper).children('textarea');
    },
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        this.getInput(wrapper).val( value );
    },
    init: function( wrapper ) {
        
        var node = $(wrapper).children('.afw-ui-ace-editor'),
            editor = ace.edit(node[0]),
            theme = node.attr('data-theme'),
            lang  = node.attr('data-lang');
        
        ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/');
        editor.setTheme("ace/theme/"+theme);
        editor.getSession().setMode("ace/mode/"+lang);
        editor.setOptions({
            maxLines: Infinity
        });
        
        // Since the onchange event only fires when bluring, 
        // form submission might not detect the new value. Hence this:
        var self = this;
        node.keyup(function(){
            console.log('asd');
            $(this).parent().attr('data-value',editor.getValue());
            self.getInput(wrapper).val(editor.getValue());
        });
    }
});