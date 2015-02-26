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
            input = this.getInput(wrapper),
            title = $(wrapper).attr('data-uploader-title'),
            btn_text = $(wrapper).attr('data-uploader-button-text'),
            disabled = $(wrapper).hasClass('afw-ui-component-disabled'),
            multiple = $(wrapper).hasClass('afw-wp-multi-attachment') ? 'add' : false;

        $(wrapper).find('.afw-ui-attachment-button, .afw-ui-wp-attachments').click(function(e){
            e.preventDefault();
            
            if( disabled )
            {
                return;
            }
            
            // If the media frame already exists, reopen it.
            if ( file_frame ) 
            {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: title,
                button: {
                    text: btn_text,
                },
                multiple: multiple
            });

            /**
             * Called when the media uploader is opened
             */
            file_frame.on('open',function() {
                var value = input.val();
                // Multiple attachments
                if( false !== multiple )
                {
                    var ids = value.split(',');
                    for( var i = 0; i < ids.length; i++ )
                    {
                        var attachment = wp.media.attachment(ids[i]);
                        attachment.fetch();
                        file_frame.state().get('selection').add(attachment);
                    }
                }
                // Single attachment
                else
                {
                    var attachment = wp.media.attachment(value);
                    attachment.fetch();
                    file_frame.state().get('selection').add(attachment);
                }
            });

            /**
             * Called when an attachment is selected
             */
            file_frame.on( 'select', function() {
                var selection = file_frame.state().get('selection');
                
                // Multiple attachments
                if( false !== multiple )
                {
                    var ids = [], imgs = [];
                    selection.map( function( attachment ) {
                        if( '' === attachment.id )
                        {
                            return;
                        }
                        
                        attachment = attachment.toJSON();
                        ids.push(attachment.id);
                        imgs.push(attachment.type === 'image' ? attachment.url : attachment.icon);
                    });
                    update_images( imgs );
                    input.val( ids.join(',') );
                }
                
                // Single attachment
                else
                {
                    var attachment = selection.first().toJSON();
                    var img = attachment.type === 'image' ? attachment.url : attachment.icon;
                    update_images( [img] );
                    input.val( attachment.id );
                }
                
                input.trigger('change');
            });

            // Finally, open the modal
            file_frame.open();
        });
        
        /**
         * Update the attachments images/icons
         * 
         * @param {array} imgs Array of images
         */
        function update_images( imgs )
        {
            $(wrapper).children('.afw-ui-wp-attachments').html('');
            imgs.map(function(img){
                $(wrapper).children('.afw-ui-wp-attachments').append('<div class="afw-ui-wp-attachment"><img src="'+img+'"></div>');
            });
        }
    }
});