(function ($) {
	
	// Trigger an event after widget save/drag/load.
	// @see http://wordpress.stackexchange.com/questions/5515/update-widget-form-after-drag-and-drop-wp-save-bug
	$(document).ready(function(){
		$(document).trigger('widget_init');
	});
	$( document ).ajaxComplete( function( event, XMLHttpRequest, ajaxOptions ) {
		var request = {}, pairs = ajaxOptions.data.split('&'), i, split, widget;
		for( i in pairs ) {
			split = pairs[i].split( '=' );
			request[decodeURIComponent( split[0] )] = decodeURIComponent( split[1] );
		}

		if( request.action && ( request.action === 'save-widget' ) ) {
			widget = $('input.widget-id[value="' + request['widget-id'] + '"]').parents('.widget');
			if( !XMLHttpRequest.responseText ) 
				wpWidgets.save(widget, 0, 1, 0);
			else
				$(document).trigger('widget_init', widget);
		}
	});
	
	// Fire widget events when the widget is updated (saved/dragged)
	$(document).bind('widget_init', function(event, widget){
		widget_events();
	});
	
	// Widget events to bind to the widget's control panel.
	function widget_events() {
		// Set tooltips
		$('[data-type="error"]').tooltip({
			template: '<div class="tooltip tooltip-error"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
		});
		$('[data-type="help"]').tooltip({
			delay: { show: 0, hide: 250 }
		});

		// Set select button click event
		$('.amarkal-widget .select-button').click(function() {
			$(this).parent().find('select').focus();
		});

		// Bind color picker
		$('.amarkal-widget.colorpicker input').wpColorPicker();
		$('.amarkal-widget.colorpicker.disabled').find('.wp-color-result').unbind( "click" );
		
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
	}
}(jQuery));

