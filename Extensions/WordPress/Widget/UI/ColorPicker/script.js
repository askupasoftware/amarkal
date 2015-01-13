/**
 * ColorPicker component
 */
(function ($) {  
    // Fired when the widget is updated (saved/dragged/refreshed)
	$(document).bind('widget_init', function(event, widget){
		// Bind color picker
		$('.amarkal-widget.colorpicker input').wpColorPicker();
		$('.amarkal-widget.colorpicker.disabled').find('.wp-color-result').unbind( "click" );
	});
}(jQuery));