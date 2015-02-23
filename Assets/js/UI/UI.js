/**
 * Amarkal UI namespace
 */
Amarkal.UI = {};

/**
 * Array of component objects
 * New objects can be added using Amarkal.UI.register
 * 
 * @type Array
 */
Amarkal.UI.components = [];

/**
 * Initiate All Amarkal UI components.
 */
Amarkal.UI.init = function()
{
    for( var i = 0; i < Amarkal.UI.components.length; i++ )
    {
        var component = Amarkal.UI.components[i];
        
        // Use the wrapper parameter for the DOM query
        $(component.wrapper).each(function(){
            component.init(this);
            
            // Trigger the change event and update the wrapper value attribute
            $(component.getInput(this)).change(function(){
                var wrap = $(this).parents('.afw-ui-component');
                    wrap.trigger('change');
                    wrap.attr('data-value',$(this).val()); // This value is used by composite components to generate the final value
            });
        });
    }
};

/**
 * Register a UI component type.
 * Registered components MUST be an object with the following properties:
 * <ul>
 *   <li><b>wrapper</b> <i>string</i> a query selector to the component's 
 *   wrapper</li>
 *   <li><b>getInput</b> <i>function</i> a function that accepts the components 
 *   wrapper as an argument and returns the component's input element or elements.
 *   This function is used to bind certain events to the component, such as the 
 *   change trigger.</li>
 *   <li><b>init</b> <i>function</i> a function that accepts the component's 
 *   wrapper as an argument and initiates the component</li>
 * </ul>
 * 
 * @param {object} obj
 */
Amarkal.UI.register = function( obj )
{
    Amarkal.UI.components.push(obj);
};

/**
 * Set the given value to the given component.
 * 
 * @param {Node} Amarkal UI component DOM Node
 */
Amarkal.UI.setValue = function( component, value )
{
    for( var i = 0; i < Amarkal.UI.components.length; i++ )
    {
        // Find the corresponding registered UI component script
        if( $(component).hasClass( Amarkal.UI.components[i].wrapper.replace('.','') ) )
        {
            Amarkal.UI.components[i].setValue( component, value );
        }
    }
};

/**
 * Get a UI component configuration object by a DOM Node.
 * 
 * @param {Node} component Amarkal UI component DOM Node
 */
Amarkal.UI.getComponent = function( component )
{
    for( var i = 0; i < Amarkal.UI.components.length; i++ )
    {
        // Find the corresponding registered UI component script
        if( $(component).hasClass( Amarkal.UI.components[i].wrapper.replace('.','') ) )
        {
            return Amarkal.UI.components[i];
        }
    }
    return null;
};

/**
 * Refresh UI components.
 * Some UI components run a special script when shown. This function
 * calls the 'onshow' function of the UI component, if applicable.
 */
Amarkal.UI.refresh = function()
{
    $.each(Amarkal.UI.components, function(i, c){
        if(c.hasOwnProperty('onShow'))
        {
            c.onShow();
        }
    });
};