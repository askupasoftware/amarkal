/**
 * Implements an options page section.
 * 
 * @param {string} id The section id
 */
Amarkal.Options.Section = function( id )
{
    this.id         = id;
    this.button     = $('[data-section="'+this.id+'"]');
    this.triangleEl = $('<i class="fa fa-exclamation-triangle"></i>');
    this.circleEl   = $('<span class="number"></span>');
    this.noticePanel= $('#'+id).find('.section-notifications');
    this.notices    = [];
    this.updated    = []; // List of updated field ids
    this.subsections= []; // List of subsection ids (if exists)

    this.init();
};

/**
 * Initiate the section.
 */
Amarkal.Options.Section.prototype.init = function()
{
    this.button.append(this.triangleEl, this.circleEl);
    this.circleEl.hide();
    this.triangleEl.hide();
    var self = this;

    // Listen to change events on all inputs
    $('#'+this.id).find('.field-wrapper').change(function(){
        $(this).addClass('field-updated');
        self.updated.push($(this).attr('for'));
        $.unique(self.updated);
        self.circleEl.text(self.updated.length);
        self.circleEl.show();
    });

    // Check for subsections
    $('#'+this.id+' .sub-menu a').each(function(){      
        $(this).click(function(e){
            e.preventDefault();
            self.hideAllSubsections();
            self.showSubsection($(this).attr('href'));
        });
        self.subsections.push($(this).attr('href'));
    });

    // Show the first subsection
    this.hideAllSubsections();
    this.showSubsection( this.subsections[0] );
};

/**
 * Show this section.
 * This function does not hide other sections.
 */
Amarkal.Options.Section.prototype.show = function()
{
    Amarkal.Options.State.set( 'active_section', this.id );
    this.button.addClass('active');
    $('#'+this.id).show();
    Amarkal.UI.refresh();
};

/**
 * Hide this section.
 */
Amarkal.Options.Section.prototype.hide = function()
{
    this.button.removeClass('active');
    $('#'+this.id).hide();
};

/**
 * Show the subsection with the given ID.
 * 
 * @param {string} id The subsection id.
 */
Amarkal.Options.Section.prototype.showSubsection = function( id )
{
    $('[href="'+id+'"]').addClass('active');
    $('[data-subsection="'+id+'"]').show();
    Amarkal.UI.refresh();
};

/**
 * Hide all subsections for this section. 
 * Pretty self explanatory, isn't it?
 */
Amarkal.Options.Section.prototype.hideAllSubsections = function()
{
    $('#'+this.id+' .sub-menu a').each(function(){
        $(this).removeClass('active');
        $('[data-subsection="'+$(this).attr('href')+'"]').hide();
    });
};

/**
 * Add a notification for this section.
 * 
 * @param {string} message The message to show in the notification.
 */
Amarkal.Options.Section.prototype.addNotification = function( message )
{
    this.notices.push( message );
    this.triangleEl.show();
    var html = '';
    for( var i = 0; i < this.notices.length; i++ )
    {
        html += '<p>'+this.notices[i]+'</p>';
    }
    this.noticePanel.html(html);
};

/**
 * Clear all notifications for this section.
 */
Amarkal.Options.Section.prototype.clearNotifications = function()
{
    this.triangleEl.hide();
    this.notices = [];
};