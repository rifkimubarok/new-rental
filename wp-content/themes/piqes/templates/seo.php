<?php
/**
 * The template to display the Structured Data Snippets
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.30
 */

// Structured data snippets
if ( piqes_is_on( piqes_get_theme_option( 'seo_snippets' ) ) ) {
	?>
	<div class="structured_data_snippets">
		<meta itemprop="headline" content="<?php the_title_attribute( '' ); ?>">
		<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
		<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date( 'Y-m-d' ) ); ?>">
		<div itemscope itemprop="publisher" itemtype="//schema.org/Organization">
			<meta itemprop="name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<meta itemprop="telephone" content="">
			<meta itemprop="address" content="">
			<?php
			$piqes_logo_image = piqes_get_logo_image();
			if ( ! empty( $piqes_logo_image['logo'] ) ) {
				?>
				<meta itemprop="logo" itemtype="//schema.org/ImageObject" content="<?php echo esc_url( $piqes_logo_image['logo'] ); ?>">
				<?php
			}
			?>
		</div>
		<?php
		if ( piqes_get_theme_option( 'show_author_info' ) != 1 || ! is_single() || is_attachment() || ! get_the_author_meta( 'description' ) ) {  // || 	!is_multi_author()
			?>
			<div itemscope itemprop="author" itemtype="//schema.org/Person">
				<meta itemprop="name" content="<?php echo esc_attr( get_the_author() ); ?>">
			</div>
			<?php
		}
		if ( ( is_singular() || is_attachment() ) && has_post_thumbnail() ) {
			?>
			<meta itemprop="image" itemtype="//schema.org/ImageObject" content="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>">
			<?php
		}
		?>
	</div>
	<?php
}
