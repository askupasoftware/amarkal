/**
 * Implements an ajax form popup
 * 
 * @param {array} config
 */
Amarkal.Editor.Plugins.FormPopup = function( config )
{   
    if( typeof tinymce === 'undefined') return;
    
    // Add the button to the editor
    tinymce.PluginManager.add( config.slug, function( editor, url ) {
        
        // Bind a command to the given slug to allow for execution outside this script
        editor.addCommand( config.slug, function(ui, v ) {

            v = Amarkal.Utility.extend( Amarkal.Editor.Form.defaults(), v );
            
            // Open a new ajax popup form window
            Amarkal.Editor.Form.open( editor, {
                title: config.title,
                url: ajaxurl + '?action=' + config.slug,
                width: config.width,
                height: config.height,
                template: config.template,
                on_init: v.on_init,
                on_insert: v.on_insert,
                values: v.values,
            });
        });
        
        editor.addButton( config.slug, { 
            text: config.text, 
            icon: config.icon, 
            title: config.title,
            stateSelector: config.selector,
            onclick: function() {
                editor.execCommand(config.slug);
            }
        });
        
        // Run scripts that were binded to this slug by 
        // the function Amarkal.Editor.bindScript()
        Amarkal.Editor.runScripts( config.slug, editor );
    });
};