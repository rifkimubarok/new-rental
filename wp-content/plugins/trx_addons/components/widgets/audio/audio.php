<?php
/**
 * Widget: Audio player for Local hosted audio and Soundcloud and other embeded audio
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */


// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Load widget
if ( ! function_exists( 'trx_addons_widget_audio_load' ) ) {
	add_action( 'widgets_init', 'trx_addons_widget_audio_load' );
	function trx_addons_widget_audio_load() {
		register_widget( 'trx_addons_widget_audio' );
	}
}

// Widget Class
class trx_addons_widget_audio extends TRX_Addons_Widget {
	/** Widget base constructor. */
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_audio',
			'description' => esc_html__( 'Play audio from Soundcloud and other audio hostings or Local hosted audio', 'trx_addons' ),
		);
		parent::__construct( 'trx_addons_widget_audio', esc_html__( 'ThemeREX Audio player', 'trx_addons' ), $widget_ops );
	}

	/** Show widget */
	function widget( $args, $instance ) {

		$title        = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$subtitle     = isset( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$next_btn     = isset( $instance['next_btn'] ) ? $instance['next_btn'] : '1';
		$prev_btn     = isset( $instance['prev_btn'] ) ? $instance['prev_btn'] : '1';
		$next_text    = isset( $instance['next_text'] ) ? $instance['next_text'] : '';
		$prev_text    = isset( $instance['prev_text'] ) ? $instance['prev_text'] : '';
		$now_text     = isset( $instance['now_text'] ) ? $instance['now_text'] : '';
		$track_time   = isset( $instance['track_time'] ) ? $instance['track_time'] : '';
		$track_scroll = isset( $instance['track_scroll'] ) ? $instance['track_scroll'] : '';
		$track_volume = isset( $instance['track_volume'] ) ? $instance['track_volume'] : '';
		$media        = isset( $instance['media'] ) ? $instance['media'] : array();
		trx_addons_get_template_part(
			TRX_ADDONS_PLUGIN_WIDGETS . 'audio/tpl.default.php',
			'trx_addons_args_widget_audio',
			apply_filters(
				'trx_addons_filter_widget_args',
				array_merge( $args, compact( 'title', 'subtitle', 'next_btn', 'next_text', 'prev_btn', 'prev_text', 'now_text', 'track_time', 'track_scroll', 'track_volume', 'media' ) ),
				$instance, 'trx_addons_widget_audio'
			)
		);
	}

	/** Update the widget settings. */
	function update( $new_instance, $instance ) {
		$instance                 = array_merge( $instance, $new_instance );
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['subtitle']     = strip_tags( $new_instance['subtitle'] );
		$instance['next_btn']     = strip_tags( $new_instance['next_btn'] );
		$instance['prev_btn']     = strip_tags( $new_instance['prev_btn'] );
		$instance['next_text']    = strip_tags( $new_instance['next_text'] );
		$instance['prev_text']    = strip_tags( $new_instance['prev_text'] );
		$instance['now_text']     = strip_tags( $new_instance['now_text'] );
		$instance['track_time']   = strip_tags( $new_instance['track_time'] );
		$instance['track_scroll'] = strip_tags( $new_instance['track_scroll'] );
		$instance['track_volume'] = strip_tags( $new_instance['track_volume'] );
		$instance['media']        = array();
		if ( is_array( $new_instance['media'] ) ) {
			for ( $i = 0; $i < count( $new_instance['media'] ); $i++ ) {
				if ( empty( $new_instance['media'][ $i ]['url'] ) && empty( $new_instance['media'][ $i ]['embed'] ) ) {
					continue;
				}
				if ( empty( $new_instance['media'][ $i ]['new_window'] ) ) {
					$new_instance['media'][ $i ]['new_window'] = 0;
				}
				$instance['media'][] = $new_instance['media'][ $i ];
			}
		}
		return apply_filters( 'trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_audio' );
	}

	/** Displays the widget settings controls on the widget panel. */
	function form( $instance ) {
		/* Remove empty media array */
		if ( isset( $instance['media'] ) && ( ! is_array( $instance['media'] ) || count( $instance['media'] ) == 0 ) ) {
			unset( $instance['media'] );
		}
		/* Set up some default widget settings */
		$instance = wp_parse_args(
			(array) $instance, apply_filters(
				'trx_addons_filter_widget_args_default', array(
					'title'        => '',
					'subtitle'     => '',
					'next_btn'     => '1',
					'prev_btn'     => '1',
					'next_text'    => '',
					'prev_text'    => '',
					'now_text'     => '',
					'track_time'   => '1',
					'track_scroll' => '1',
					'track_volume' => '1',
					'media'        => array(
						array(
							'url'         => '',
							'embed'       => '',
							'caption'     => '',
							'author'      => '',
							'description' => '',
							'cover'       => '',
						),
						array(
							'url'         => '',
							'embed'       => '',
							'caption'     => '',
							'author'      => '',
							'description' => '',
							'cover'       => '',
						),
					),
				), 'trx_addons_widget_audio'
			)
		);

		do_action( 'trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_audio', $this );

		$this->show_field(
			array(
				'name'  => 'title',
				'title' => __( 'Title:', 'trx_addons' ),
				'value' => $instance['title'],
				'type'  => 'text',
			)
		);

		do_action( 'trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_audio', $this );

		$this->show_field(
			array(
				'name'  => 'subtitle',
				'title' => __( 'Subtitle:', 'trx_addons' ),
				'value' => $instance['subtitle'],
				'type'  => 'text',
			)
		);

		$this->show_field(
			array(
				'name'  => 'next_btn',
				'title' => __( 'Show next button:', 'trx_addons' ),
				'value' => $instance['next_btn'],
				'type'  => 'checkbox',
			)
		);

		$this->show_field(
			array(
				'name'  => 'prev_btn',
				'title' => __( 'Show prev button:', 'trx_addons' ),
				'value' => $instance['prev_btn'],
				'type'  => 'checkbox',
			)
		);

		$this->show_field(
			array(
				'name'  => 'next_text',
				'title' => __( 'Next button text:', 'trx_addons' ),
				'value' => $instance['next_text'],
				'type'  => 'text',
			)
		);

		$this->show_field(
			array(
				'name'  => 'prev_text',
				'title' => __( 'Prev button text:', 'trx_addons' ),
				'value' => $instance['prev_text'],
				'type'  => 'text',
			)
		);

		$this->show_field(
			array(
				'name'  => 'now_text',
				'title' => __( '"Now playing" text:', 'trx_addons' ),
				'value' => $instance['now_text'],
				'type'  => 'text',
			)
		);

		$this->show_field(
			array(
				'name'  => 'track_time',
				'title' => __( 'Show tack time:', 'trx_addons' ),
				'value' => $instance['track_time'],
				'type'  => 'checkbox',
			)
		);

		$this->show_field(
			array(
				'name'  => 'track_scroll',
				'title' => __( 'Show track scroll bar:', 'trx_addons' ),
				'value' => $instance['track_scroll'],
				'type'  => 'checkbox',
			)
		);

		$this->show_field(
			array(
				'name'  => 'track_volume',
				'title' => __( 'Show track volume bar:', 'trx_addons' ),
				'value' => $instance['track_volume'],
				'type'  => 'checkbox',
			)
		);

		foreach ( $instance['media'] as $k => $item ) {
			$this->show_field(
				array(
					'name'  => sprintf( 'item%d', $k + 1 ),
					'title' => sprintf( __( 'Media item %d', 'trx_addons' ), $k + 1 ),
					'type'  => 'info',
				)
			);
			$this->show_field(
				array(
					'name'  => "media[{$k}][url]",
					'title' => __( 'Media URL:', 'trx_addons' ),
					'value' => $item['url'],
					'type'  => 'text',
				)
			);
			$this->show_field(
				array(
					'name'  => "media[{$k}][embed]",
					'title' => __( 'Embed code:', 'trx_addons' ),
					'value' => $item['embed'],
					'type'  => 'textarea',
				)
			);
			$this->show_field(
				array(
					'name'  => "media[{$k}][caption]",
					'title' => __( 'Audio caption:', 'trx_addons' ),
					'value' => $item['caption'],
					'type'  => 'text',
				)
			);
			$this->show_field(
				array(
					'name'  => "media[{$k}][author]",
					'title' => __( 'Author name:', 'trx_addons' ),
					'value' => $item['author'],
					'type'  => 'text',
				)
			);
			$this->show_field(
				array(
					'name'  => "media[{$k}][description]",
					'title' => __( 'Description:', 'trx_addons' ),
					'value' => $item['description'],
					'type'  => 'textarea',
				)
			);

			$this->show_field(
				array(
					'name'  => "media[{$k}][cover]",
					'title' => __( 'Cover image', 'trx_addons' ),
					'value' => $item['cover'],
					'type'  => 'image',
				)
			);
		}
		do_action( 'trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_audio', $this );
	}
}


/** Load required styles and scripts for the frontend */
if ( ! function_exists( 'trx_addons_widget_audio_load_scripts_front' ) ) {
	add_action( 'wp_enqueue_scripts', 'trx_addons_widget_audio_load_scripts_front' );
	function trx_addons_widget_audio_load_scripts_front() {
		if ( trx_addons_is_on( trx_addons_get_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'trx_addons-widget_audio', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'audio/audio.css'), array(), null );
			wp_enqueue_script( 'trx_addons-widget_audio', trx_addons_get_file_url( TRX_ADDONS_PLUGIN_WIDGETS . 'audio/audio.js' ), array( 'jquery' ), null, true );
		}
	}
}


/** Merge widget specific styles into single stylesheet */
if ( ! function_exists( 'trx_addons_widget_audio_merge_styles' ) ) {
	add_filter( 'trx_addons_filter_merge_styles', 'trx_addons_widget_audio_merge_styles' );
	function trx_addons_widget_audio_merge_styles( $list ) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'audio/audio.css';
		return $list;
	}
}

/** Merge widget specific scripts into single file */
if ( ! function_exists( 'trx_addons_widget_audio_merge_scripts' ) ) {
	add_action( 'trx_addons_filter_merge_scripts', 'trx_addons_widget_audio_merge_scripts' );
	function trx_addons_widget_audio_merge_scripts( $list ) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'audio/audio.js';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'audio/audio-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'audio/audio-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'audio/audio-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'audio/audio-sc-vc.php';
}
