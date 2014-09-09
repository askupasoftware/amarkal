<div class="amarkal-widget row input<?php if ( true == $this->disabled ) echo ' disabled'; ?>">
	<label for="<?php echo $this->id; ?>"><?php echo $this->label; ?></label>
	<?php if ( $this->has_property('help') ): ?>
		<a class="help" data-toggle="tooltip" data-type="help" data-placement="bottom" title="<?php echo $this->help; ?>">?</a>
	<?php endif; ?>
	<div class="component-wrapper">
		<input <?php echo ( $this->error ? 'data-toggle="tooltip" data-type="error" data-placement="bottom" title="'.$this->error_message.'" ' : ''); ?>
			   id="<?php echo $this->id; ?>" 
			   name="<?php echo $this->name; ?>" 
			   type="<?php echo $this->type; ?>" 
			   value="<?php echo $this->value; ?>"
               min="<?php echo $this->min; ?>"
               max="<?php echo $this->max; ?>"
               step="<?php echo $this->step; ?>"
			   class="widefat <?php if ( $this->error ) echo ' error'; ?>" 
			   <?php echo ($this->disabled ? 'disabled' : ''); ?>>
	</div>
	<?php if ( $this->has_property('description') ): ?>
		<p class="description"><?php echo $this->description; ?></p>
	<?php endif; ?>
</div>
