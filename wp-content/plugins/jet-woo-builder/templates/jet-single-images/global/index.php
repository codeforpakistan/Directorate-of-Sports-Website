<?php
/**
 * JetWooBuilder Single Images template.
 */

$settings      = $this->get_settings();
$nav_direction = apply_filters( 'jet-woo-builder/jet-single-image-template/navigation-direction', $settings['control_nav_direction'] );
$nav_position  = 'vertical' === $nav_direction ? 'jet-single-images-nav-' . $settings['control_nav_v_position'] : '';

printf( '<div class="jet-single-images__wrap jet-single-images-nav-%s %s">', $nav_direction, $nav_position );
printf( '<div class="jet-single-images__loading">%s</div>', __( 'Loading...', 'jet-woo-builder' ) );
woocommerce_show_product_images();
echo '</div>';
