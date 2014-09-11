(function ($) {
    
    $(document).ready(function(){
        var op = new OptionsPage();
    });
    
    function OptionsPage()
    {
        this.activeSection = $('.ao-section.active').attr('id');
        this.setSidebar();
    };
    
    OptionsPage.prototype.setSidebar = function()
    {
        var self = this;
        $('.ao-section-list li a').click(function( event ){
            event.preventDefault();
            self.showSection($(this).attr('data-slug'));
        });
    };

    OptionsPage.prototype.getSections = function()
    {
        return $('.ao-sections').find('.ao-section');
    };
    
    OptionsPage.prototype.showSection = function( slug )
    {
        if( this.activeSection != slug )
        {
            $('#'+slug+'.ao-section').addClass('active');
            $('a[data-slug="'+slug+'"]').parent().addClass('active');
            
            $('#'+this.activeSection+'.ao-section').removeClass('active');
            $('a[data-slug="'+this.activeSection+'"]').parent().removeClass('active');
            
            // Change the form's action
            $('#ao-form').attr('action', $('a[data-slug="'+slug+'"]').attr('href'));
            
            this.activeSection = slug;
        }
    };
    
}(jQuery));