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
            theme = node.attr('data-theme'),
            lang  = node.attr('data-lang'),
            editor = ace.edit(node[0]);
        
        // Push each editor to the list of editors to be used later by onShow()
        this.editors.push(editor);
        
        ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/');
        editor.setTheme("ace/theme/"+theme);
        editor.getSession().setMode("ace/mode/"+lang);
        editor.setOptions({
            maxLines: Infinity
        });
        
        // Disabled editor
        if( node.hasClass('afw-ui-ace-editor-disabled') )
        {
            editor.setReadOnly(true);
            return;
        }
        
        // Since the onchange event only fires when bluring, 
        // form submission might not detect the new value. Hence this:
        var self = this;
        node.keyup(function(){
            $(this).parent().attr('data-value',editor.getValue());
            self.getInput(wrapper).val(editor.getValue());
        });
    },
    editors: [],
    onShow: function() {
        for( var i = 0; i < this.editors.length; i++ )
        {
            this.editors[i].resize();
            this.editors[i].renderer.updateFull();
        }
    }
});