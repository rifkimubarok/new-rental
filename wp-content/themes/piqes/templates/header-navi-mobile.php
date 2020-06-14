<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr( piqes_get_theme_option( 'menu_mobile_fullscreen' ) > 0 ? 'fullscreen' : 'narrow' ); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<div class="mobile_menu_top_wrap">
            <a class="menu_mobile_close theme_button_close"><span class="theme_button_close_icon"></span></a>
            <?php
            // Logo
            set_query_var( 'piqes_logo_args', array( 'type' => 'mobile' ) );
            get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-logo' ) );
            set_query_var( 'piqes_logo_args', array() ); ?>
        </div>

        <?php

		// Mobile menu
		$piqes_menu_mobile = piqes_get_nav_menu( 'menu_mobile' );
		if ( empty( $piqes_menu_mobile ) ) {
			$piqes_menu_mobile = apply_filters( 'piqes_filter_get_mobile_menu', '' );
			if ( empty( $piqes_menu_mobile ) ) {
				$piqes_menu_mobile = piqes_get_nav_menu( 'menu_main' );
				if ( empty( $piqes_menu_mobile ) ) {
					$piqes_menu_mobile = piqes_get_nav_menu();
				}
			}
		}
		if ( ! empty( $piqes_menu_mobile ) ) {
			$piqes_menu_mobile = str_replace(
				array( 'menu_main',   'id="menu-',        'sc_layouts_menu_nav', 'sc_layouts_menu ', 'sc_layouts_hide_on_mobile', 'hide_on_mobile' ),
				array( 'menu_mobile', 'id="menu_mobile-', '',                    ' ',                '',                          '' ),
				$piqes_menu_mobile
			);
			if ( strpos( $piqes_menu_mobile, '<nav ' ) === false ) {
				$piqes_menu_mobile = sprintf( '<nav class="menu_mobile_nav_area" itemscope >%s</nav>', $piqes_menu_mobile );
			}
			piqes_show_layout( apply_filters( 'piqes_filter_menu_mobile_layout', $piqes_menu_mobile ) );
		}

		?>
	</div>
</div>
