jQuery(document).ready(function($){
    // Fire change event
    $('.ao-field-input input').change(function(){
        $(this).parents('.field-wrapper').trigger('change');
    });
});