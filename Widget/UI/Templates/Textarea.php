<div class="amarkal-widget row textarea<?php if ( true == $this->disabled ) echo ' disabled'; ?>">
	<label for="<?php echo $this->id; ?>"><?php echo $this->label; ?></label>
	<?php if ( $this->has_property('help') ): ?>
		<a class="help" data-toggle="tooltip" data-type="help" data-placement="bottom" title="<?php echo $this->help; ?>">?</a>
	<?php endif; ?>
	<div class="component-wrapper">
		<textarea 
			<?php echo ( $this->error ? 'data-toggle="tooltip" data-type="error" data-placement="bottom" title="'.$this->error_message.'" ' : ''); ?>
			class="widefat<?php if ( $this->error ) echo ' error'; ?>" 
			id="<?php echo $this->id; ?>" 
			name="<?php echo $this->name; ?>" 
			<?php echo ($this->disabled ? 'disabled' : ''); ?>><?php echo $this->value; ?></textarea>
	</div>
	<?php if ( $this->has_property('description') ): ?>
		<p class="description"><?php echo $this->description; ?></p>
	<?php endif; ?>
</div>