/**
 * Select component
 */
(function ($) {  
    // Fired when the widget is updated (saved/dragged/refreshed)
	$(document).bind('widget_init', function(event, widget){
		// Set select button click event
        $('.amarkal-widget .select-button').click(function() {
            $(this).parent().find('select').focus();
        });
	});
}(jQuery));