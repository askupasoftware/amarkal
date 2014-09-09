<div class="amarkal-widget row select<?php if ( true == $this->disabled ) echo ' disabled'; ?>">
	<label for="<?php echo $this->id; ?>"><?php echo $this->label; ?></label>
	<?php if ( $this->has_property('help') ): ?>
		<a class="help" data-toggle="tooltip" data-type="help" data-placement="bottom" title="<?php echo $this->help; ?>">?</a>
	<?php endif; ?>
	<div class="component-wrapper">
		<select id="<?php echo $this->id; ?>" 
				name="<?php echo $this->name; ?>" 
				class="widefat" value="<?php echo $choice; ?>"
				<?php echo ($this->disabled ? 'disabled' : ''); ?>>
			<?php foreach ( $this->choices as $choice => $label ): ?>
				<option value="<?php echo $choice; ?>"<?php echo $this->value == $choice ? ' selected' : ''; ?>><?php echo $label; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php if ( $this->has_property('description') ): ?>
		<p class="description"><?php echo $this->description; ?></p>
	<?php endif; ?>
</div>