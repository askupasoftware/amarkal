jQuery(document).ready(function($) { 
    $(".ao-field-dropdown select")
        .select2({width:'resolve'})
        .change(function(){
            // Fire change event
            $(this).parents('.field-wrapper').trigger('change');
    });
});