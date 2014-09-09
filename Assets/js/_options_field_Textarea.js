jQuery(document).ready(function($){
    $('.ao-field-textarea textarea').resizable({
        minHeight: 150,
        minWidth: 250
    });
    $('.ui-resizable-s').html('<i class="fa fa-bars"></i>');
    $('.ui-resizable-e').html('<i class="fa fa-bars fa-rotate-90"></i>');
});