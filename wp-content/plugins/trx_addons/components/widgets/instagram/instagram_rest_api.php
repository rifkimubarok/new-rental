<?php
/**
 * Instagram support: REST API callbacks
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.47
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Get recent photos
if ( !function_exists( 'trx_addons_widget_instagram_get_recent_photos' ) ) {
	function trx_addons_widget_instagram_get_recent_photos($args) {
		// Check photos in the cache
		$client_id = trx_addons_widget_instagram_get_client_id();
		$cache_data = sprintf('trx_addons_instagram_data_%1$s_%2$s', $client_id, $args['hashtag']);
		$data = get_transient($cache_data);
		// If no photos - request its from Instagram and put to the cache for 4 hours
		if (!is_array($data) || count($data) < $args['count']) {
			$access_token = trx_addons_get_option('api_instagram_access_token');
			// Get Instagram photos via API
			if ( ! empty($access_token ) ) {
				$count = max(1, $args['count']);
				$args['hashtag'] = ! empty( $args['hashtag'] ) ? str_replace( '#', '', $args['hashtag'] ) : '';
				$url = 'https://api.instagram.com/v1/'
						. ( empty( $args['hashtag'] ) ? 'users/self' : "tags/{$args['hashtag']}" )
						.  "/media/recent?access_token={$access_token}&count={$count}";
				$resp = trx_addons_remote_get($url);
				if (substr($resp, 0, 1) == '{') {
					$data = json_decode($resp, true);
				}

			// Get Instagram photos via direct GET (parse html output)
			} else {
				// If parameter 'hashtag' not start with '#' - use it as user name
				if ( empty($args['username']) && !empty($args['hashtag']) && $args['hashtag'][0] != '#' ) {
					$args['username'] = $args['hashtag'];
					$args['hashtag']  = '';
				}
				$data = array(
					'data' => trx_addons_parse_instagram_output( $args )
				);
			}
			if ( is_array($data) && count($data) > 0 ) {
				set_transient($cache_data, $data, 4*60*60);
			}
		}
		return $data;
	}
}


//------------------------------------------------
//--  REST API support
//------------------------------------------------

// Register endpoints
if ( !function_exists( 'trx_addons_widget_instagram_rest_register_endpoints' ) ) {
	add_action( 'rest_api_init', 'trx_addons_widget_instagram_rest_register_endpoints');
	function trx_addons_widget_instagram_rest_register_endpoints() {
		// Get access token from Instagram
		register_rest_route( 'trx_addons/v1', '/widget_instagram/get_access', array(
			'methods' => 'GET,POST',
			'callback' => 'trx_addons_widget_instagram_rest_get_access'
			));
	}
}


// Return redirect url for Instagram API
if ( !function_exists( 'trx_addons_widget_instagram_rest_get_redirect_uri' ) ) {
	function trx_addons_widget_instagram_rest_get_redirect_uri() {
		$nonce = get_transient('trx_addons_instagram_nonce');
		if (empty($nonce)) {
			$nonce = md5(mt_rand());
			set_transient('trx_addons_instagram_nonce', $nonce, 60*60);
		}
		$url = trailingslashit(home_url()) . "wp-json/trx_addons/v1/widget_instagram/get_access/?nonce={$nonce}";
		if (trx_addons_get_option('api_instagram_client_id') != '') {
			return $url;
		} else {
			return "//cb.themerex.net/instagram?return_uri={$url}";
		}
	}
}

// Callback: Get authorization code from Instagram
if ( !function_exists( 'trx_addons_widget_instagram_rest_get_access' ) && class_exists( 'WP_REST_Request' ) ) {
	function trx_addons_widget_instagram_rest_get_access(WP_REST_Request $request) {

		// Get response code
		$params = $request->get_params();
		$nonce = get_transient('trx_addons_instagram_nonce');
		if (empty($params['error']) && !empty($params['nonce']) && !empty($nonce) && $params['nonce']==$nonce) {
			
			$code = !empty($params['code']) ? $params['code'] : '';
			$access_token = !empty($params['access_token']) ? $params['access_token'] : '';
			
			// Receive authorization code - request for access token
			if (empty($access_token) && !empty($code)) {
				$client_id = trx_addons_widget_instagram_get_client_id();
				$client_secret = trx_addons_widget_instagram_get_client_secret();
				// Request for access token
				$resp = trx_addons_remote_post('https://api.instagram.com/oauth/access_token',
											array(
													'client_id' => $client_id,
													'client_secret' => $client_secret,
													'grant_type' => 'authorization_code',
													'code' => $code,
													'response_type' => 'code',
													'redirect_uri' => trx_addons_widget_instagram_rest_get_redirect_uri()
												)
										);
				if (substr($resp, 0, 1) == '{') {
					$resp = json_decode($resp, true);
					if (!empty($resp['access_token'])) $access_token = $resp['access_token'];
				}
			}
			
			// Save access token
			if (!empty($access_token) ) {
				$options = get_option('trx_addons_options');
				$options['api_instagram_access_token'] = $access_token;
				update_option('trx_addons_options', $options);
			}
		}		
		
		// Redirect to the options page
		wp_redirect(get_admin_url(null, 'admin.php?page=trx_addons_options#trx_addons_options_section_api_section'));
		die();
	}
}


//------------------------------------------------
//--  Alternative way: Parse Instagram html output
//------------------------------------------------

if( !function_exists( 'trx_addons_parse_instagram_output' ) ) {
	function trx_addons_parse_instagram_output( $args ) {
		$username = ! empty( $args['username'] ) ? strtolower( $args['username'] ) : '';
		$hashtag  = ! empty( $args['hashtag'] ) ? str_replace( '#', '', $args['hashtag'] ) : '';
		$output = trx_addons_fgc( 'https://instagram.com/'
									. ( ! empty( $hashtag )
										? 'explore/tags/' . trim( $hashtag )	// Get output by hashtag
										: trim( $username )						// Get output by username
										)
								);
		if ( empty( $output ) ) return false;

		$data = explode( 'window._sharedData = ', $output );
		$json = explode( ';</script>', $data[1] );
		$images_list = json_decode( $json[0], true );

		if ( ! $images_list ) return false;

		if ( isset( $images_list['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
			$images = $images_list['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		} elseif( isset( $images_list['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
			$images = $images_list['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		} else {
			return false;
		}

		if ( ! is_array( $images ) ) {
			return false;
		}

		$instagram = array();

		foreach ( $images as $image ) {
			$image = $image['node'];

			$thumbs = array(
				'standard_resolution'	=> array(
												'url'    => preg_replace( "/^https:/i", "", $image['thumbnail_src'] ),
												'width'  => ! empty( $image['dimensions']['width'] ) ? $image['dimensions']['width'] : '',
												'height' => ! empty( $image['dimensions']['height'] ) ? $image['dimensions']['height'] : '',
												),
				'small_resolution'		=> array(
												'url'    => preg_replace( "/^https:/i", "", $image['thumbnail_resources'][0]['src'] ),
												'width'  => ! empty( $image['thumbnail_resources'][0]['config_width'] ) ? $image['thumbnail_resources'][0]['config_width'] : '',
												'height' => ! empty( $image['thumbnail_resources'][0]['config_height'] ) ? $image['thumbnail_resources'][0]['config_height'] : '',
												),
				'medium_resolution'		=> array(
												'url'    => preg_replace( "/^https:/i", "", $image['thumbnail_resources'][2]['src'] ),
												'width'  => ! empty( $image['thumbnail_resources'][2]['config_width'] ) ? $image['thumbnail_resources'][2]['config_width'] : '',
												'height' => ! empty( $image['thumbnail_resources'][2]['config_height'] ) ? $image['thumbnail_resources'][2]['config_height'] : '',
												),
				'large_resolution'		=> array(
												'url'    => preg_replace( "/^https:/i", "", $image['thumbnail_resources'][4]['src'] ),
												'width'  => ! empty( $image['thumbnail_resources'][4]['config_width'] ) ? $image['thumbnail_resources'][4]['config_width'] : '',
												'height' => ! empty( $image['thumbnail_resources'][4]['config_height'] ) ? $image['thumbnail_resources'][4]['config_height'] : '',
												),
			);

			$type = ( $image['is_video'] ) ? 'video' : 'image';

			$instagram[] = array(
				'type'			=> $type,
				'link'			=> '//instagram.com/p/' . $image['shortcode'],
				'caption'		=> array(
										'text' => ! empty( $image['edge_media_to_caption']['edges'][0]['node']['text'] )
													? $image['edge_media_to_caption']['edges'][0]['node']['text']
													: esc_html__( 'Instagram Image', 'trx_addons' )
										),
				'user'			=> array(
										'username'	=> ! empty( $image['owner']['username'] ) ? $image['owner']['username'] : '',
										'id' 		=> ! empty( $image['owner']['id'] ) ? $image['owner']['id'] : '',
										),
				'comments'		=> array( 'count' => $image['edge_media_to_comment']['count'] ),
				'likes'			=> array( 'count' => $image['edge_liked_by']['count'] ),
				( $type == 'image' ? 'images' : 'videos' ) => $thumbs,
			);

			if (count($instagram) >= $args['count']) {
				break;
			}
		}

		return ! empty( $instagram ) ? $instagram : false;
	}
}
