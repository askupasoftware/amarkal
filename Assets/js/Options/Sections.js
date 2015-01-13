/**
 * Static class that provides control over the option page sections.
 */
Amarkal.Options.Sections = {};

/**
 * List of Section objects representing all sections.
 * @type Section[]
 */
Amarkal.Options.Sections.sectionList = [];

/**
 * Initiate the sections of the options page.
 */
Amarkal.Options.Sections.init = function()
{
    // Generate sections
    $('.amarkal-options .section').each(function(){
        var section = new Amarkal.Options.Section( $(this).attr('id') );

        Amarkal.Options.Sections.sectionList.push( section );

        section.hide();
        if( section.id === Amarkal.Options.State.get('active_section') )
        {
            section.show();
        }
    });

    // Click event for section buttons
    $('[data-section]').click(function(e){
        e.preventDefault();
        Amarkal.Options.Sections.hideAll();
        Amarkal.Options.Sections.getByID( $(this).attr('data-section') ).show();

        // Change the form's action
        $('#'+Amarkal.Options.formID).attr('action', $(this).attr('href'));
    });
};

/**
 * Get a section by its ID (not including the # sign).
 * 
 * @param {string} sectionId
 * @returns {Amarkal.Options.Sections.getSection.section}
 */
Amarkal.Options.Sections.getByID = function( sectionId )
{
    for( var i = 0; i < Amarkal.Options.Sections.sectionList.length; i++ )
    {
        var section = Amarkal.Options.Sections.sectionList[i];
        if( section.id === sectionId )
        {
            return section;
        }
    }
};

/**
 * Hide all sections
 */
Amarkal.Options.Sections.hideAll = function()
{
    for( var i = 0; i < Amarkal.Options.Sections.sectionList.length; i++ )
    {
        Amarkal.Options.Sections.sectionList[i].hide();
    }
};