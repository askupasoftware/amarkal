/**
 * Amarkal Options framework front end controller.
 */
Amarkal.Options   = {};

Amarkal.Options.formID = 'ao-form';

Amarkal.Options.init = function()
{   
    // Initiate sections
    Amarkal.Options.Sections.init();

    // Form control buttons
    $('.form-control-button').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        Amarkal.Options[$(this).attr('data-action')]();
    });
    
    // Display notifications
    var notifications = Amarkal.Options.State.get('notifications');
    for( var i = 0; i < notifications.length && notifications; i++ )
    {
        Amarkal.Notifier.notify( notifications[i].message, notifications[i].type );
    }
    
    // Display errors
    var errors = Amarkal.Options.State.get('errors');
    for( var i = 0; i < errors.length && errors; i++ )
    {
        var section = Amarkal.Options.Sections.getByID(errors[i].section);
        section.addNotification(errors[i].message);
    }

    // Control menu toggle
    $('.amarkal-options .append-control-menu').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        if( !$(this).parent().hasClass('active') )
        {
            $('.form-control-button').removeClass('active');
            $(this).parent().toggleClass('active');
        }
        else
        {
            $('.form-control-button').removeClass('active');
        }
    });
    
    // Show help tooltips
    $('[data-type="help"]').tooltip({
        delay: { show: 0, hide: 250 }
    });
};

Amarkal.Options.save = function()
{
    Amarkal.Options.State.set( 'action', 'save' );
    Amarkal.Options.submit();
};

Amarkal.Options.reset = function()
{
    Amarkal.Options.State.set( 'action', 'reset-all' );
    Amarkal.Options.submit();
};

Amarkal.Options.resetSection = function()
{
    Amarkal.Options.State.set( 'action', 'reset-section' );
    Amarkal.Options.submit();
};

Amarkal.Options.export = function()
{
    Amarkal.Notifier.success('This feature is not yet implemented.');
};

Amarkal.Options.exportAs = function()
{
    Amarkal.Notifier.success('This feature is not yet implemented.');
};

Amarkal.Options.import = function()
{
    Amarkal.Notifier.success('This feature is not yet implemented.');
};

Amarkal.Options.submit = function()
{
    $('#'+Amarkal.Options.formID).submit();
};
