<div class="amarkal-widget row checkbox<?php if ( $this->error ) echo ' error'; ?><?php if ( true == $this->disabled ) echo ' disabled'; ?>">
    <div class="component-wrapper">
		<input id="<?php echo $this->id; ?>" 
			   name="<?php echo $this->name; ?>" 
			   type="checkbox" 
			   class="widefat" 
			   <?php checked($this->value, 'on'); ?> 
			   <?php echo ($this->disabled ? 'disabled' : ''); ?>>
	</div>
	<label for="<?php echo $this->id; ?>"><?php echo $this->label; ?></label>
	<?php if ( $this->has_property('help') ): ?>
		<a class="help" data-toggle="tooltip" data-type="help" data-placement="bottom" title="<?php echo $this->help; ?>">?</a>
	<?php endif; ?>
	<?php if ( $this->has_property('description') ): ?>
		<p class="description"><?php echo $this->description; ?></p>
	<?php endif; ?>
</div>