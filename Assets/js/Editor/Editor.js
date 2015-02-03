/**
 * Editor namespace
 */
Amarkal.Editor = {};

/**
 * List of tinymce custom plugins
 */
Amarkal.Editor.Plugins = {};

/**
 * Register a custom tinymce plugin type
 * 
 * @param {string} type The type of the plugin
 * @param {array} config The configuration array
 */
Amarkal.Editor.Plugins.register = function( type, config )
{
    Amarkal.Editor.Plugins[type](config);
};

/**
 * Add a button to the tinymce editor.
 * 
 * @param {string} The plugin type to use for the button.
 * @param {array} config The configuration array
 */
Amarkal.Editor.addButton = function( type, config )
{
    Amarkal.Editor.Plugins.register( type, config );
};

/**
 * Parse a given template, replacing the placeholders with the given values.
 * Placeholders are specified using the notation <% placeholder_name %>.
 * The value 'values.placeholder_name' will replace the placeholder.
 * 
 * @param {string} template
 * @param {object} values
 * @returns {string} parsed template.
 */
Amarkal.Editor.parseTemplate = function( template, values )
{
    return template.replace(/(<%([^\%\<\>]*)%>)/g,function replacer( match, p1, p2 ) 
    {
        return values[p2.trim()];
    });
};