<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.14
 */
$piqes_header_video = piqes_get_header_video();
$piqes_embed_video  = '';
if ( ! empty( $piqes_header_video ) && ! piqes_is_from_uploads( $piqes_header_video ) ) {
	if ( piqes_is_youtube_url( $piqes_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $piqes_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php piqes_show_layout( piqes_get_embed_video( $piqes_header_video ) ); ?></div>
		<?php
	}
}
