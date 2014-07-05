<div class="amarkal-widget row datepicker<?php if ( true == $this->disabled ) echo ' disabled'; ?>">
	<label for="<?php echo $this->id; ?>"><?php echo $this->label; ?></label>
	<?php if ( $this->has_property('help') ): ?>
		<a class="help" data-toggle="tooltip" data-type="help" data-placement="bottom" title="<?php echo $this->help; ?>">?</a>
	<?php endif; ?>
	<div class="component-wrapper">
		<input type="text" 
			   id="<?php echo $this->id; ?>" 
			   name="<?php echo $this->name; ?>" 
			   value="<?php echo $this->value; ?>"
			   readonly 
			   <?php echo ($this->disabled ? 'disabled' : ''); ?>/>
		<a class="datepicker-button"></a>
	</div>
	<?php if ( $this->has_property('description') ): ?>
		<p class="description"><?php echo $this->description; ?></p>
	<?php endif; ?>
</div>