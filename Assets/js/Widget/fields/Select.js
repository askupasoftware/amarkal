/**
 * Select component
 */
(function ($) {  
    // Fired when the widget is updated (saved/dragged/refreshed)
	$(document).bind('widget_init', function(event, widget){
        $(".amarkal-widget.select select").select2({width:'resolve'});
	});
}(jQuery));