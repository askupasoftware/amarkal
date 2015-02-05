<?php

namespace Amarkal\Extensions\WordPress\Options;

/**
 * Implements an options page section.
 * 
 * To be used as a part of the OptionsConfig construct settings.
 */
class Section extends \Amarkal\Template\Controller
{
    /**
     * Current section state.
     * @var boolean True if this is the current section.
     */
    private $active;
    
    /**
     * Section's slug. Used as the query argument 'section'.
     * @var string 
     */
    private $slug;
    
    /**
     * Construct default settings.
     * @return mixed[] The default settings.
     */
    public function default_model()
    {
        return array(
            'title'         => '',      // The section's title. MUST be unique.
            'description'   => '',      // The section's description.
            'icon'          => '',      // One of the icon classes from Font Awesome or Dashicons.
            'parent'        => null,    // The parent's title, if applicable.
            'fields'        => array(), // The section's fields.
            'subsections'   => null     // An array holding subsections, each of which has a title and an array of fields. 
                                        // If this parameter is provided, the 'fields' parameter is ignored
        );
    }
    
    /**
     * Option page section.
     * 
     * @param array $model
     * <ul>
     *      <li>[title] <i>string</i> The section's title. MUST be unique.</li>
     *      <li>[description] <i>string</i> The section's description.</li>
     *      <li>[icon] <i>string</i> One of the icon classes from Font Awesome or Dashicons.</li>
     *      <li>[parent] <i>string</i> The parent's title, if applicable.</li>
     *      <li>[fields] <i>array</i> The section's fields.</li>
     *      <li>[subsections] <i>array</i> An array holding subsections, each of which has a title and an array of fields. If this parameter is provided, the 'fields' parameter is ignored</li>
     * </ul>
     */
    public function __construct( array $model = array() )
    {
        parent::__construct( $model );
    }
    
    /**
     * Generates the appropriate CSS class for the icon.
     * 
     * Examples: 
     * 'fa-twitter' returns 'fa fa-twitter'
     * 'dashicons-admin-media' returns 'dashicons dashicons-admin-media' 
     * 
     * @return type
     */
    public function get_icon_class()
    {
        return preg_replace( '/(fa|dashicons)(-[\w\-]+)/', '$1 $1$2', $this->model['icon'] );
    }
    
    /**
     * Set section's slug.
     * @param string $slug
     */
    public function set_slug( $slug )
    {
        $this->slug = $slug;
    }
    
    /**
     * Get section's slug.
     * @return string slug.
     */
    public function get_slug()
    {
        return $this->slug;
    }
    
    /**
     * Check if this is the current section.
     * @return boolean True if this is the currently active section.
     */
    public function is_current_section()
    {
        if( !isset( $this->active ) )
        {
            $this->active = filter_input(INPUT_GET, 'section') == $this->get_slug();
        }
        return $this->active;
    }
    
    /**
     * Returns true if this section has subsections.
     * 
     * @return boolean
     */
    public function has_sub_sections()
    {
        return is_array( $this->model['subsections'] );
    }
    
    /**
     * Get the array of fields for this section.
     * If this section has subsections, the returning array will consist of
     * all fields from all subsections.
     * 
     * @return array
     */
    public function get_fields()
    {
        if( !isset( $this->fields ) )
        {
            if( !$this->has_sub_sections() )
            {
                $this->fields = $this->model['fields'];
            }
            else
            {
                $this->fields = array();
                foreach( $this->model['subsections'] as $subsection )
                {
                    foreach( $subsection['fields'] as $field )
                    {
                        $field->subsection = \Amarkal\Common\Tools::strtoslug( $subsection['title'] );
                    }
                    $this->fields = array_merge( $this->fields, $subsection['fields'] );
                }
            }
        }
        return $this->fields;
    }
}