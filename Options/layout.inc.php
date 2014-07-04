<div class="wrap">
    <h2></h2>
</div>
<div class="clear"></div>
<div class="wrap">
    <div class="amarkal-options-wrapper">
        
        <!-- Header -->
        <div class="amarkal-options-header">
            <img class="icon" src="<?php echo $this->header['icon']; ?>" width="64" height="64"/>
            <h2><?php echo $this->header['title']; ?><span><?php echo $this->header['version']; ?></span></h2>
            <?php if( isset( $this->header['subtitle'] ) ): ?>
                <p><?php echo $this->header['subtitle']; ?></p>
            <?php endif; ?>
        </div>
        
        <!-- Body -->
        <div class="amarkal-options-body">
            
        </div>
        
        <!-- Footer -->
        <div class="amarkal-options-footer">
            <?php if( isset( $this->footer['icon'] ) ): ?>
                <img class="icon" src="<?php echo $this->footer['icon']; ?>" width="64" height="64"/>
            <?php endif; ?>
            <p><?php echo $this->footer['text']; ?></p>
        </div>
    </div>
    
    <!-- Subfooter -->
    <?php if( isset( $this->subfooter['text'] ) ): ?>
        <div class="amarkal-options-subfooter">
            <p><?php echo $this->subfooter['text']; ?></p>
        </div>
    <?php endif; ?>
</div>