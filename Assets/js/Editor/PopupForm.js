/**
 * Implements a popup form for the tinymce popup window.
 */
Amarkal.Editor.PopupForm = function() {};

/**
 * Initiate the popup form
 */
Amarkal.Editor.PopupForm.init = function()
{
    var form = $('.afw-editor-popup-form');
    
    if( 0 !== form.length ) 
    {
        this.setValues();
    }       
};

/**
 * Set values according to active editor selected 
 */
Amarkal.Editor.PopupForm.setValues = function()
{
    var selection = top.tinymce.activeEditor.selection.getContent();
    
    if(selection === '')
    {
        return;
    }
    
    $('.afw-editor-popup-form').find('.afw-ui-component').each(function()
    {
        var name = $(this).attr('data-name');
        var regex = new RegExp(name+'="([^\"]+)"');
        var match = selection.match(regex);
        if( null !== match )
        {
            Amarkal.UI.setValue( this, match[1] );
        }
    });
};