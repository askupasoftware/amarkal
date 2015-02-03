/**
 * Implements an icon popup box tinymce plugin
 * 
 * @param {array} config
 */
Amarkal.Editor.Plugins.IconBoxPopup = function( config )
{   
    if( typeof tinymce === 'undefined') return;
    
    // Add the button to the editor
    tinymce.PluginManager.add( config.slug, function( editor, url ) { 
        var dimensions = Amarkal.Editor.Plugins.IconBoxPopup.calcDimensions( config.buttons.length, config.max_cols );
        editor.addButton( config.slug, { 
            text: config.text, 
            icon: config.icon, 
            title: config.title, 
            onclick: function() {
                
                // Open a window showing all icon boxes
                editor.windowManager.open( {
                    title: config.title,
                    width: dimensions.width,
                    height: dimensions.height,
                    body: [{
                        type: 'container',
                        html: Amarkal.Editor.Plugins.IconBoxPopup.genHTML( config.buttons, config.max_cols )
                    }],
                    buttons: [] // Hide footer
                });
                 
                 // Click event for each icon box
                $('.afw-editor-popup-icon').click(function(){
                    
                    var id      = $(this).attr('data-id'),
                        action  = config.buttons[id].action,
                        title   = config.buttons[id].title,
                        width   = config.buttons[id].width,
                        height  = config.buttons[id].height,
                        disabled = $(this).hasClass('disabled'),
                        url     = ajaxurl + '?action=' + action;
                    
                    // Disabled button, do nothing
                    if( disabled )
                    {
                        return;
                    }
                    
                    // Close the previous dialog
                    editor.windowManager.close(); 
                    
                    // Open a new ajax window
                    editor.windowManager.open({
                        title: title,
                        url: url,
                        width: width,
                        height: height,
                        buttons: [{
                            text: 'Insert',
                            classes: 'widget btn primary first abs-layout-item',
                            disabled: false,
                            onclick: function(e){
                                //editor.insertContent( '<h3>' + e.data.title + '</h3>');
                                var args = tinymce.activeEditor.windowManager.getParams();
                                var iframe = $('iframe[src$="'+action+'"]').contents();
                                var values = {};
                                iframe.find('.afw-ui-component').each(function(){
                                    var name  = $(this).attr('data-name');
                                    var value = $(this).attr('data-value') == 'undefined' ? '' : $(this).attr('data-value');
                                    values[name] = value;
                                });
                                editor.insertContent( Amarkal.Editor.parseTemplate( args.template, values ) );
                                editor.windowManager.close();
                            }
                        }, 
                        {
                            text: 'Close',
                            onclick: function() {editor.windowManager.close();}
                        }]
                    }, { /* parameters. see http://www.tinymce.com/wiki.php/Tutorials:Creating_custom_dialogs */
                        template: config.buttons[id].template,
                        selection: tinymce.activeEditor.selection.getContent()
                    });
                });
            } 
        });
    });
};

Amarkal.Editor.Plugins.IconBoxPopup.genHTML = function( buttons, maxCols )
{
    var html = '';
    for( var i = 0; i < buttons.length; i++ )
    {
        html += '<div class="afw-editor-popup-icon'+(buttons[i].disabled ? ' disabled' : '')+'" title="'+buttons[i].label+'" data-id="'+i+'">';
        html += '<img src="'+buttons[i].img+'"/>';
        html += '<h3>'+buttons[i].label+'</h3>';
        html += '</div>';
        
        if( (i+1) % maxCols === 0 )
        {
            html += '<br />';
        }
    }
    
    return html;
};

Amarkal.Editor.Plugins.IconBoxPopup.calcDimensions = function( boxCount, maxCols )
{
    var boxWidth    = 107,
        cols        = Math.min( maxCols, boxCount ),
        rows        = Math.ceil( boxCount / maxCols );
    return { width: cols*boxWidth+25, height: rows*boxWidth+25 };
};