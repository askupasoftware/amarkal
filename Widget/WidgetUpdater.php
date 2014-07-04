<?php

namespace Amarkal\Widget;

use Amarkal\Widget\UI;

/**
 * Implements a widget options updater.
 * 
 * The widget updater is responsible for the updating process of the widget. It
 * filters, validates or ignores each component as needed.
 * 
 * @see AbstractWidget::update()
 */
class WidgetUpdater {
	
	/**
	 * The list of UI\AbstractComponent type objects to be updated.
	 * 
	 * @var UI\AbstractComponent[] component list
	 */
	private $components;
	
	/**
	 * The old component values array. These values are used if the new values
	 * are invalid.
	 * Structure: component_name => component_value
	 * 
	 * @var array The values array.
	 */
	private $old_instance;
	
	/**
	 * The new component values array.
	 * Structure: component_name => component_value
	 * 
	 * @var array The values array.
	 */
	private $new_instance;
	
	/**
	 * Constructor.
	 * 
	 * @param array $components	  The list of components to update.
	 * @param array $new_instance The new component values array.
	 * @param array $old_instance The old component values array.
	 */
	public function __construct(
		array $components,
		array $new_instance,
		array $old_instance
	) {
		$this->components	= $components;
		$this->new_instance = $new_instance;
		$this->old_instance = $old_instance;
	}
	
	/**
	 * Get the updated component values (validated, filtered or ignored).
	 * 
	 * Loops through each component and acts according to its type:
	 * - Disableable components are ignored if they are disabled.
	 * - Validatable components are validated using their validation function. 
	 *   If the new value is invalid, the old value will be used.
	 * - Filterable components are filtered using their filter function.
	 * 
	 * @return array The validated values array.
	 */
	public function update()
	{
		foreach ( $this->components as $component ) {
			if ( $component instanceof UI\ValueComponentInterface ) {
				$this->update_component( $component );
			}
		}
		return $this->new_instance;
	}
	
	/**
	 * Update the component's value with the new value.
	 * 
	 * Update the $new_instance array with the appropriate value.
	 * 
	 * @param UI\ValueComponentInterface $component The component to validate.
	 * @param type $new_instance The new component values array.
	 * @param type $old_instance The old component values array.
	 */
	private function update_component( UI\ValueComponentInterface $component )
	{
		$name = $component->get_name();
		
		// If this is the first time this widget is created, there are no
		// old values: use default value.
		if( empty( $this->old_instance[$name] ) )
		{
			$this->old_instance[$name] = $component->get_default_value();
		}
		
		// Disabled component: no update needed
		if ( $component instanceof UI\DisableableComponentInterface &&
			 true == $component->is_disabled() )
		{
			return;
		}
		
		// Apply user-defined filter
		if( $component instanceof UI\FilterableComponentInterface )
		{
			$this->update_filterable( $component );
		}
		
		// Validate value
		if( $component instanceof UI\ValidatableComponentInterface )
		{
			$this->update_validatable( $component );
		}
	}
	
	/**
	 * Filter the component's value using its filter function.
	 * 
	 * @param UI\FilterableComponentInterface $component
	 */
	private function update_filterable( UI\FilterableComponentInterface $component )
	{
		$component->apply_filter( $this->new_instance[$component->get_name()] );
	}
	
	/**
	 * Validate the component's value using its validation function.
	 * 
	 * If the value is invalid, the old value is used, and an error message is
	 * saved into the array as {component_name}_error_message.
	 * 
	 * @param UI\ValidatableComponentInterface $component The component to validate.
	 */
	private function update_validatable( UI\ValidatableComponentInterface $component )
	{
		$name = $component->get_name();

		// Invalid input
		if ( !$component->validate( $this->new_instance[$name] ) ) {
			$this->new_instance[$name] = $this->old_instance[$name];
			$this->new_instance[$name.'_error'] = // Tell the component to render error
				true; 
			$this->new_instance[$name.'_error_message'] = // Show the user his invalid value
				$component->get_error_message();
		}
	}
}
