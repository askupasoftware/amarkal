/**
 * DatePicker component
 */
(function ($) {  
    // Fired when the widget is updated (saved/dragged/refreshed)
	$(document).bind('widget_init', function(event, widget){
		// Bind date picker
		$('.amarkal-widget.datepicker input').datepicker();
		$('.datepicker-button').click(function(){
			var dp = $(this).parent().find('input');
			if ( dp.datepicker('widget').is(':visible')) {
				dp.datepicker('hide');
			}
			else {
				dp.datepicker('show');
			}
		});
		$('.amarkal-widget.datepicker.disabled input').datepicker('disable');
	});
}(jQuery));