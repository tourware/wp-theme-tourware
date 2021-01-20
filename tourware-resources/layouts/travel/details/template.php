<?php use Elementor\Icons_Manager; ?>
<ul <?php echo $this->get_render_attribute_string( 'icon_list' ); ?>>
    <?php
    foreach ( $content as $index => $item ) { ?>
        <li <?php echo $this->get_render_attribute_string( 'list_item' ); ?>>
            <?php if ($settings['type'] == 'countries') { ?>
            <?php if ($settings['icon_display'] == 'each' || $settings['icon_display'] == 'first' && $index == 0) { ?>
                <span class="elementor-icon-list-icon">
							<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</span>
            <?php } ?>
            <span class="elementor-icon-list-text"><?php echo $item; ?></span>
            <?php } ?>
            <?php if ($settings['type'] == 'additional_field') { ?>
                <?php if ($item['icon']) { ?>
                    <span class="elementor-icon-list-icon">
							<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</span>
                <?php } ?>
                <span class="elementor-icon-list-text"><?php echo $item['text']; ?></span>
            <?php } ?>
        </li>
    <?php } ?>
</ul>