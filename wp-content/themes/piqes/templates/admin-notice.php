<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.1
 */

$piqes_theme_obj = wp_get_theme();
?>
<div class="piqes_admin_notice piqes_welcome_notice update-nag">
	<?php
	// Theme image
	$piqes_theme_img = piqes_get_file_url( 'screenshot.jpg' );
	if ( '' != $piqes_theme_img ) {
		?>
		<div class="piqes_notice_image"><img src="<?php echo esc_url( $piqes_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'piqes' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="piqes_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'piqes' ),
				$piqes_theme_obj->name . ( PIQES_THEME_FREE ? ' ' . __( 'Free', 'piqes' ) : '' ),
				$piqes_theme_obj->version
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="piqes_notice_text">
		<p class="piqes_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $piqes_theme_obj->description ) );
			?>
		</p>
		<p class="piqes_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'piqes' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="piqes_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=piqes_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'piqes' );
			?>
		</a>
		<?php		
		// Dismiss this notice
		?>
		<a href="#" class="piqes_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="piqes_hide_notice_text"><?php esc_html_e( 'Dismiss', 'piqes' ); ?></span></a>
	</div>
</div>
