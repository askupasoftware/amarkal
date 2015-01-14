/**
 * A static object holding the current state for the options page.
 * 
 * The state object holds information about the current state (e.g. active section, 
 * action type etc...) and is used for communications between the front end 
 * and the back end.
 * 
 * The state data is stored as a json string to the input value with the id
 * #options-state
 */
Amarkal.Options.State = {};

/**
 * The id of the input element.
 * @type String
 */
Amarkal.Options.State.inputID = 'options-state';

/**
 * Holds current state data.
 */
Amarkal.Options.State.data = $.parseJSON( $('#'+Amarkal.Options.State.inputID).val() );

/**
 * Set a state parameter.
 * 
 * @param {string} param
 * @param {mixed} value
 */
Amarkal.Options.State.set = function( param, value )
{
    Amarkal.Options.State.data[param] = value;
    Amarkal.Options.State.update();
};

/**
 * Get a state parameter.
 * 
 * @param {string} param
 * @returns {mixed}
 */
Amarkal.Options.State.get = function( param )
{
    var data = Amarkal.Options.State.data;
    if( null !== data && data.hasOwnProperty(param) )
    {
        return data[param];
    }
    return false;
};

/**
 * Update the state object.
 */
Amarkal.Options.State.update = function()
{
    $('#options-state').val(JSON.stringify(Amarkal.Options.State.data));
};
