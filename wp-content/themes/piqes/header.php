<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( piqes_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
	<meta name="google-site-verification" content="taFBqOIqZhRpUSak31JGoQj2Rw3jl2nyPNQKlsiKI7k" />
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-78608347-2"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-78608347-2');
	</script>

</head>

<body <?php	body_class(); ?>>

	<?php do_action( 'piqes_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap">
			<?php
			// Desktop header
			$piqes_header_type = piqes_get_theme_option( 'header_type' );
			if ( 'custom' == $piqes_header_type && ! piqes_is_layouts_available() ) {
				$piqes_header_type = 'default';
			}
			get_template_part( apply_filters( 'piqes_filter_get_template_part', "templates/header-{$piqes_header_type}" ) );

			// Side menu
			if ( in_array( piqes_get_theme_option( 'menu_style' ), array( 'left', 'right' ) ) ) {
				get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-navi-side' ) );
			}

			// Mobile menu
			get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-navi-mobile' ) );
			
			// Single posts banner after header
			piqes_show_post_banner( 'header' );
			?>

			<div class="page_content_wrap">
				<?php
				// Single posts banner on the background
				if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {

					piqes_show_post_banner( 'background' );

					$piqes_post_thumbnail_type  = piqes_get_theme_option( 'post_thumbnail_type' );
					$piqes_post_header_position = piqes_get_theme_option( 'post_header_position' );
					$piqes_post_header_align    = piqes_get_theme_option( 'post_header_align' );

					// Boxed post thumbnail
					if ( in_array( $piqes_post_thumbnail_type, array( 'boxed', 'fullwidth') ) ) {
						ob_start();
						?>
						<div class="header_content_wrap header_align_<?php echo esc_attr( $piqes_post_header_align ); ?>">
							<?php
							if ( 'boxed' === $piqes_post_thumbnail_type ) {
								?>
								<div class="content_wrap">
								<?php
							}

							// Post title and meta
							if ( 'above' === $piqes_post_header_position ) {
								piqes_show_post_title_and_meta();
							}

							// Featured image
							piqes_show_post_featured_image();

							// Post title and meta
							if ( in_array( $piqes_post_header_position, array( 'under', 'on_thumb' ) ) ) {
								piqes_show_post_title_and_meta();
							}

							if ( 'boxed' === $piqes_post_thumbnail_type ) {
								?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
						$piqes_post_header = ob_get_contents();
						ob_end_clean();
						if ( strpos( $piqes_post_header, 'post_featured' ) !== false
							|| strpos( $piqes_post_header, 'post_title' ) !== false
							|| strpos( $piqes_post_header, 'post_meta' ) !== false
						) {
							piqes_show_layout( $piqes_post_header );
						}
					}
				}

				// Widgets area above page content
				$piqes_body_style   = piqes_get_theme_option( 'body_style' );
				$piqes_widgets_name = piqes_get_theme_option( 'widgets_above_page' );
				$piqes_show_widgets = ! piqes_is_off( $piqes_widgets_name ) && is_active_sidebar( $piqes_widgets_name );
				if ( $piqes_show_widgets ) {
					if ( 'fullscreen' != $piqes_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					piqes_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $piqes_body_style ) {
						?>
						</div><!-- </.content_wrap> -->
						<?php
					}
				}

				// Content area
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $piqes_body_style ? '_fullscreen' : ''; ?>">

					<div class="content">
						<?php
						// Widgets area inside page content
						piqes_create_widgets_area( 'widgets_above_content' );
