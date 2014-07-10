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
            
            <!-- Sidebar -->
            <div class="ao-sidebar">
                <ul class="ao-section-list">
                    <?php foreach( $this->options['sections'] as $section ): ?>
                        <li class="item<?php echo $section->is_current_section() ? ' active' : ''; ?>">
                            <a href="<?php echo $section->get_slug(); ?>">
                                <i class="<?php echo $section->get_icon_class(); ?>"></i>
                                <span><?php echo $section->title; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Sections -->
            <div class="ao-sections">
                <?php foreach( $this->options['sections'] as $section ): ?>
                    <div class="ao-section<?php echo $section->is_current_section() ? ' active' : ''; ?>" id="<?php echo $section->get_slug(); ?>">
                        <div class="section-header">
                            <h3><i class="<?php echo $section->get_icon_class(); ?>"></i><?php echo $section->title; ?></h3>
                            <p><?php echo $section->description; ?></p>
                        </div>
                        <?php foreach( $section->fields as $field ): ?>
                            <div class="field-wrapper">
                                <div class="field-label">
                                    <label><?php echo $field->title; ?></label>
                                    <p><?php echo $field->description; ?></p>
                                </div>
                                <div class="field">
                                    <?php echo $field->render(); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
            <div class="ao-control">
                <button class="button" type="submit" class="button"><i class="fa fa-save"></i> Save</button>
                <button class="button" type="submit" class="button"><i class="fa fa-mail-reply"></i> Reset Section</button>
                <button class="button" type="submit" class="button"><i class="fa fa-refresh"></i> Reset All</button>
            </div>
        </div>
    </div>
    
    <!-- Subfooter -->
    <?php if( isset( $this->subfooter['text'] ) ): ?>
        <div class="ao-subfooter">
            <p><?php echo $this->subfooter['text']; ?></p>
        </div>
    <?php endif; ?>
</div>