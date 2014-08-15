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
            self.showSection($(this).attr('href'));
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
            $('a[href="'+slug+'"]').parent().addClass('active');
            
            $('#'+this.activeSection+'.ao-section').removeClass('active');
            $('a[href="'+this.activeSection+'"]').parent().removeClass('active');
            
            // Change the form's action
            $('#ao-form').attr('action', '?page='+slug);
            
            this.activeSection = slug;
        }
    };
    
}(jQuery));