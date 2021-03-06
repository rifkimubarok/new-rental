<div class="front_page_section front_page_section_blog<?php
	$piqes_scheme = piqes_get_theme_option( 'front_page_blog_scheme' );
	if ( ! empty( $piqes_scheme ) && ! piqes_is_inherit( $piqes_scheme ) ) {
		echo ' scheme_' . esc_attr( $piqes_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( piqes_get_theme_option( 'front_page_blog_paddings' ) );
?>"
		<?php
		$piqes_css      = '';
		$piqes_bg_image = piqes_get_theme_option( 'front_page_blog_bg_image' );
		if ( ! empty( $piqes_bg_image ) ) {
			$piqes_css .= 'background-image: url(' . esc_url( piqes_get_attachment_url( $piqes_bg_image ) ) . ');';
		}
		if ( ! empty( $piqes_css ) ) {
			echo ' style="' . esc_attr( $piqes_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$piqes_anchor_icon = piqes_get_theme_option( 'front_page_blog_anchor_icon' );
	$piqes_anchor_text = piqes_get_theme_option( 'front_page_blog_anchor_text' );
if ( ( ! empty( $piqes_anchor_icon ) || ! empty( $piqes_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_blog"'
									. ( ! empty( $piqes_anchor_icon ) ? ' icon="' . esc_attr( $piqes_anchor_icon ) . '"' : '' )
									. ( ! empty( $piqes_anchor_text ) ? ' title="' . esc_attr( $piqes_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_blog_inner
	<?php
	if ( piqes_get_theme_option( 'front_page_blog_fullheight' ) ) {
		echo ' piqes-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$piqes_css      = '';
			$piqes_bg_mask  = piqes_get_theme_option( 'front_page_blog_bg_mask' );
			$piqes_bg_color_type = piqes_get_theme_option( 'front_page_blog_bg_color_type' );
			if ( 'custom' == $piqes_bg_color_type ) {
				$piqes_bg_color = piqes_get_theme_option( 'front_page_blog_bg_color' );
			} elseif ( 'scheme_bg_color' == $piqes_bg_color_type ) {
				$piqes_bg_color = piqes_get_scheme_color( 'bg_color', $piqes_scheme );
			} else {
				$piqes_bg_color = '';
			}
			if ( ! empty( $piqes_bg_color ) && $piqes_bg_mask > 0 ) {
				$piqes_css .= 'background-color: ' . esc_attr(
					1 == $piqes_bg_mask ? $piqes_bg_color : piqes_hex2rgba( $piqes_bg_color, $piqes_bg_mask )
				) . ';';
			}
			if ( ! empty( $piqes_css ) ) {
				echo ' style="' . esc_attr( $piqes_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$piqes_caption = piqes_get_theme_option( 'front_page_blog_caption' );
			if ( ! empty( $piqes_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo ! empty( $piqes_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post( $piqes_caption ); ?></h2>
				<?php
			}

			// Description (text)
			$piqes_description = piqes_get_theme_option( 'front_page_blog_description' );
			if ( ! empty( $piqes_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo ! empty( $piqes_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post( wpautop( $piqes_description ) ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_blog_output">
			<?php
			if ( is_active_sidebar( 'front_page_blog_widgets' ) ) {
				dynamic_sidebar( 'front_page_blog_widgets' );
			} elseif ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! piqes_exists_trx_addons() ) {
					piqes_customizer_need_trx_addons_message();
				} else {
					piqes_customizer_need_widgets_message( 'front_page_blog_caption', 'ThemeREX Addons - Blogger' );
				}
			}
			?>
			</div>
		</div>
	</div>
</div>
