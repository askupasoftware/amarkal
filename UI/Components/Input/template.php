<div class="ac ac-input">
    <input 
        id="<?php echo $this->name; ?>" 
        name="<?php echo $this->name; ?>" 
        type="<?php echo $this->type; ?>" 
        value="<?php echo $this->value; ?>"
        min="<?php echo $this->min; ?>"
        max="<?php echo $this->max; ?>"
        step="<?php echo $this->step; ?>"
        class="widefat" 
        <?php echo ($this->disabled ? 'disabled' : ''); ?>>
</div>