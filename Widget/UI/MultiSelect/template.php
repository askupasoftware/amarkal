<div class="amarkal-widget row multiselect<?php if ( true == $this->disabled ) echo ' disabled'; ?>">
	<label><?php echo $this->label; ?></label>
	<?php if ( $this->has_property('help') ): ?>
		<a class="help" data-toggle="tooltip" data-type="help" data-placement="bottom" title="<?php echo $this->help; ?>">?</a>
	<?php endif; ?>
	<div class="component-wrapper">
		<?php foreach ( $this->choices as $choice => $label ): ?>
			<label>
				<input id="<?php echo $choice; ?>" 
				   name="<?php echo $this->name; ?>[]" 
				   type="checkbox" 
				   value="<?php echo $choice; ?>" 
				   <?php foreach ( $this->value as $value ) { if( $value == $choice ) { echo 'checked'; break; } } ?>
				   <?php echo ($this->disabled ? 'disabled' : ''); ?>>
				<span><?php echo $label; ?></span>
			</label>
		<?php endforeach; ?>
	</div>
	<?php if ( $this->has_property('description') ): ?>
		<p class="description"><?php echo $this->description; ?></p>
	<?php endif; ?>
</div>