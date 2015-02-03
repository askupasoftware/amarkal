/**
 * Amarkal Widget framework
 */
Amarkal.Widget    = {};

Amarkal.Widget.init = function() 
{
    if( !$('body').hasClass('widgets-php') )
    {
        return;
    }
    
    $(document).trigger('widget_init');
    Amarkal.Widget.setAjaxListener();
    
    $(document).bind('widget_init', function(event, widget){
        // Set tooltips on widgets
        $('[data-type="help"]').tooltip({
            delay: { show: 0, hide: 250 }
        });
        // Rebind UI component scripts after save
        Amarkal.UI.init();
    });
}

Amarkal.Widget.setAjaxListener = function() 
{
    // Trigger an event after widget save/drag/load.
    // @see http://wordpress.stackexchange.com/questions/5515/update-widget-form-after-drag-and-drop-wp-save-bug
    $( document ).ajaxComplete( function( event, XMLHttpRequest, ajaxOptions ) {
        var request = {}, pairs = ajaxOptions.data.split('&'), i, split, widget;
        for( i in pairs ) {
                split = pairs[i].split( '=' );
                request[decodeURIComponent( split[0] )] = decodeURIComponent( split[1] );
        }

        if( request.action && ( request.action === 'save-widget' ) ) 
        {
            widget = $('input.widget-id[value="' + request['widget-id'] + '"]').parents('.widget');
            if( !XMLHttpRequest.responseText )
            {
                wpWidgets.save(widget, 0, 1, 0);
            }
            else
            {
                $(document).trigger('widget_init', widget);
            }
        }
    });
};

Amarkal.Widget.init();