/**
 * Implements an options page notifier.
 */
Amarkal.Notifier  = {};

/**
 * @param {Node} top Initial distance from top
 */
Amarkal.Notifier.top = 32;

/**
 * @param {Node} notifications List of active notifications
 */
Amarkal.Notifier.notifications = [];

/**
 * Show a notification box of type 'type' with the message 'message'
 * 
 * @param {string} message
 * @param {string} type
 */
Amarkal.Notifier.notify = function( message, type )
{
   var wrapper  = document.createElement('div');
   var p        = document.createElement('p');
   var button   = document.createElement('div');

   wrapper.setAttribute('class', 'ao-notification notifier-' + type);
   button.setAttribute('class', 'ao-notification-button fa fa-times');
   wrapper.appendChild(p);
   wrapper.appendChild(button);
   p.innerHTML = message;

   $(button).click(function()
   {
       Amarkal.Notifier.removeNotification( wrapper );
   });

   $(wrapper).css({top: Amarkal.Notifier.top + 'px'});
   $('.amarkal-options').append(wrapper);

   Amarkal.Notifier.top += $(wrapper).outerHeight() + 10;
   Amarkal.Notifier.notifications.push(wrapper);
};

/**
 * Show a notification box of type 'success' with the message 'message'
 * 
 * @param {string} message
 */
Amarkal.Notifier.success = function( message )
{
   Amarkal.Notifier.notify( message, 'success' );
};

/**
 * Show a notification box of type 'error' with the message 'message'
 * 
 * @param {string} message
 */
Amarkal.Notifier.error = function( message )
{
   Amarkal.Notifier.notify( message, 'error' );
};

/**
 * Remove a notification box
 * 
 * @param {Node} wrapper
 */
Amarkal.Notifier.removeNotification = function( wrapper )
{
   var pos = Amarkal.Notifier.notifications.indexOf(wrapper);
   var height = $(wrapper).outerHeight() + 10;

   Amarkal.Notifier.top -= height;
   wrapper.parentNode.removeChild(wrapper);
   Amarkal.Notifier.notifications.splice(pos,1);

   for(;pos < Amarkal.Notifier.notifications.length; pos++)
   {
       $(Amarkal.Notifier.notifications[pos]).animate({top: '-=' + height});
   }
};

    