Amarkal.UI.register({
    wrapper: '.afw-ui-component-wp-attachment',
    getInput: function( wrapper ) {
        return $(wrapper).children('input');
    },
    setValue: function( wrapper, value ) {
        $(wrapper).attr('data-value',value);
        this.getInput(wrapper).value = value;
    },
    init: function( wrapper ) {
        // http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
        var file_frame,
            name = $(wrapper).attr('data-name'),
            value = $(wrapper).attr('data-value');
    
        $(wrapper).children('.afw-ui-attachment-button').click(function(e){
            e.preventDefault();
            
            // If the media frame already exists, reopen it.
            if ( file_frame ) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: $( this ).data( 'uploader_title' ),
                button: {
                    text: $( this ).data( 'uploader_button_text' ),
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            file_frame.on('open',function() {
                var attachment = wp.media.attachment(value);
                attachment.fetch();
                file_frame.state().get('selection').add(attachment);
            });

            // When an attachment is selected, run a callback.
            file_frame.on( 'select', function() {
                // We set multiple to false so only get one attachment from the uploader
                attachment = file_frame.state().get('selection').first().toJSON();

                // Do something with attachment.id and/or attachment.url here
                $('input[name="'+name+'"]').val( attachment.id );
            });

            // Finally, open the modal
            file_frame.open();
        });
        
        
    }
});