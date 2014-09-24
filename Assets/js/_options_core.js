(function ($) {
    
    $(document).ready(function(){
        var op = new OptionsPage();
    });
    
    function OptionsPage()
    {
        this.sidebar = $('.ao-sidebar');
        this.activeSection = $('.ao-section.active').attr('id');
        this.activeTab = $('.ao-tab.active').attr('id');
        this.setSidebar();
    };
    
    OptionsPage.prototype.setSidebar = function()
    {
        var self = this;
        $('.ao-section-list a[data-slug]').click(function( event ){
            event.preventDefault();
            self.showSection($(this).attr('data-slug'));
            
            // Show the first tab if this is a tabbed section
            if($(this).parent().has('.tabs'))
            {
                self.showTab($(this).parent().find('.tabs li a').first().attr('data-tab'));
            }
        });
        
        $('.ao-section-list a[data-tab]').click(function( event ){
            event.preventDefault();
            self.showTab($(this).attr('data-tab'));
        });
        
        $('.ao-section-list a[href="collapse"]').click(function(){
            event.preventDefault();
            self.sidebar.toggleClass('collapsed');
        });
    };

    OptionsPage.prototype.getSections = function()
    {
        return $('.ao-sections').find('.ao-section');
    };
    
    OptionsPage.prototype.showSection = function( slug )
    {   
        if( this.activeSection !== slug )
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
    
    OptionsPage.prototype.showTab = function( tab )
    { 
        if( this.activeTab !== tab )
        {
            $('#'+tab+'.ao-tab').addClass('active');
            $('a[data-tab="'+tab+'"]').parent().addClass('active');
            
            $('#'+this.activeTab+'.ao-tab').removeClass('active');
            $('a[data-tab="'+this.activeTab+'"]').parent().removeClass('active');
            
            // Change the form's action
            $('#ao-form').attr('action', $('a[data-tab="'+tab+'"]').attr('href'));
            this.activeTab = tab;
        }
    };
    
}(jQuery));