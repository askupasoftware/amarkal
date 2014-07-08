<div class="wrap">
    <h2></h2>
</div>

<div class="clear"></div>
<div class="wrap">
    <div class="ao-wrapper">
        
        <!-- Header -->
        <div class="ao-header">
            <img class="icon" src="<?php echo $this->header['icon']; ?>" width="64" height="64"/>
            <h2><?php echo $this->header['title']; ?><span><?php echo $this->header['version']; ?></span></h2>
            <?php if( isset( $this->header['subtitle'] ) ): ?>
                <p><?php echo $this->header['subtitle']; ?></p>
            <?php endif; ?>
        </div>
        
        <!-- Body -->
        <div class="ao-body">
            <div class="ao-sidebar">
                <ul class="ao-section-list">
                    <?php foreach( $this->options['sections'] as $section ): ?>
                        <li class="item<?php echo $section->is_current_section() ? ' active' : ''; ?>">
                            <a href="?page=<?php echo $section->get_slug(); ?>">
                                <i class="<?php echo $section->get_icon_class(); ?>"></i><?php echo $section->title; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="ao-sections">
                <?php foreach( $this->options['sections'] as $section ): ?>
                    <div class="ao-section" id="<?php echo $section->get_slug(); ?>">
                        <h3><i class="<?php echo $section->get_icon_class(); ?>"></i><?php echo $section->title; ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="ao-footer">
            <?php if( isset( $this->footer['icon'] ) ): ?>
                <img class="icon" src="<?php echo $this->footer['icon']; ?>" width="32" height="32"/>
            <?php endif; ?>
            <p><?php echo $this->footer['text']; ?></p>
        </div>
    </div>
    
    <!-- Subfooter -->
    <?php if( isset( $this->subfooter['text'] ) ): ?>
        <div class="ao-subfooter">
            <p><?php echo $this->subfooter['text']; ?></p>
        </div>
    <?php endif; ?>
</div>