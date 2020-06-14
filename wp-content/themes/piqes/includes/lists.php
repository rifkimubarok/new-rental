<?php
/**
 * Theme lists
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }



// Return numbers range
if ( ! function_exists( 'piqes_get_list_range' ) ) {
	function piqes_get_list_range( $from = 1, $to = 2, $prepend_inherit = false ) {
		$list = array();
		for ( $i = $from; $i <= $to; $i++ ) {
			$list[ $i ] = $i;
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}



// Return styles list
if ( ! function_exists( 'piqes_get_list_styles' ) ) {
	function piqes_get_list_styles( $from = 1, $to = 2, $prepend_inherit = false ) {
		$list = array();
		for ( $i = $from; $i <= $to; $i++ ) {
			// Translators: Add number to the style name 'Style 1', 'Style 2' ...
			$list[ $i ] = sprintf( esc_html__( 'Style %d', 'piqes' ), $i );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( ! function_exists( 'piqes_get_list_yesno' ) ) {
	function piqes_get_list_yesno( $prepend_inherit = false ) {
		$list = array(
			'yes' => esc_html__( 'Yes', 'piqes' ),
			'no'  => esc_html__( 'No', 'piqes' ),
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return list with 'Yes' and 'No' items for checkboxes: 'Yes' -> 1, 'No' -> 0
if ( ! function_exists( 'piqes_get_list_checkbox_values' ) ) {
	function piqes_get_list_checkbox_values( $prepend_inherit = false ) {
		$list = apply_filters(
			'piqes_filter_list_checkbox_values', array(
				1         => esc_html__( 'Yes', 'piqes' ),
				0         => esc_html__( 'No', 'piqes' ),
			)
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( ! function_exists( 'piqes_get_list_onoff' ) ) {
	function piqes_get_list_onoff( $prepend_inherit = false ) {
		$list = array(
			'on'  => esc_html__( 'On', 'piqes' ),
			'off' => esc_html__( 'Off', 'piqes' ),
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( ! function_exists( 'piqes_get_list_showhide' ) ) {
	function piqes_get_list_showhide( $prepend_inherit = false ) {
		$list = array(
			'show' => esc_html__( 'Show', 'piqes' ),
			'hide' => esc_html__( 'Hide', 'piqes' ),
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( ! function_exists( 'piqes_get_list_directions' ) ) {
	function piqes_get_list_directions( $prepend_inherit = false ) {
		$list = array(
			'horizontal' => esc_html__( 'Horizontal', 'piqes' ),
			'vertical'   => esc_html__( 'Vertical', 'piqes' ),
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return list with paddings sizes
if ( ! function_exists( 'piqes_get_list_paddings' ) ) {
	function piqes_get_list_paddings( $prepend_inherit = false ) {
		$list = apply_filters(
			'piqes_filter_list_paddings', array(
				'none'   => esc_html__( 'None', 'piqes' ),
				'small'  => esc_html__( 'Small', 'piqes' ),
				'medium' => esc_html__( 'Medium', 'piqes' ),
				'large'  => esc_html__( 'Large', 'piqes' ),
			)
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return list with image's hovers
if ( ! function_exists( 'piqes_get_list_hovers' ) ) {
	function piqes_get_list_hovers( $prepend_inherit = false ) {
		$list = apply_filters(
			'piqes_filter_list_hovers', array(
//				'dots'   => esc_html__( 'Dots', 'piqes' ),
//				'icon'   => esc_html__( 'Icon', 'piqes' ),
//				'icons'  => esc_html__( 'Icons', 'piqes' ),
//				'zoom'   => esc_html__( 'Zoom', 'piqes' ),
//				'fade'   => esc_html__( 'Fade', 'piqes' ),
//				'slide'  => esc_html__( 'Slide', 'piqes' ),
//				'pull'   => esc_html__( 'Pull', 'piqes' ),
//				'border' => esc_html__( 'Border', 'piqes' ),
                'scale'  => esc_html__( 'Scale', 'piqes' ),
			)
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( ! function_exists( 'piqes_get_list_sidebars' ) ) {
	function piqes_get_list_sidebars( $prepend_inherit = false, $add_hide = false ) {
		$list = piqes_storage_get( 'list_sidebars' );
		if ( '' == $list ) {
			global $wp_registered_sidebars;
			$list = array();
			if ( is_array( $wp_registered_sidebars ) ) {
				foreach ( $wp_registered_sidebars as $k => $v ) {
					$list[ $v['id'] ] = $v['name'];
				}
			}
			piqes_storage_set( 'list_sidebars', $list );
		}
		if ( $add_hide ) {
			$list = piqes_array_merge( array( 'hide' => esc_html__( '- Select widgets -', 'piqes' ) ), $list );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return sidebars positions
if ( ! function_exists( 'piqes_get_list_sidebars_positions' ) ) {
	function piqes_get_list_sidebars_positions( $prepend_inherit = false ) {
		$list = apply_filters(
			'piqes_filter_list_sidebars_positions', array(
				'hide'  => esc_html__( 'Hide', 'piqes' ),
				'left'  => esc_html__( 'Left', 'piqes' ),
				'right' => esc_html__( 'Right', 'piqes' ),
			)
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return sidebars positions on the small screen
if ( ! function_exists( 'piqes_get_list_sidebars_positions_ss' ) ) {
	function piqes_get_list_sidebars_positions_ss( $prepend_inherit = false ) {
		$list = apply_filters(
			'piqes_filter_list_sidebars_positions_ss', array(
				'above' => esc_html__( 'Above the content', 'piqes' ),
				'below' => esc_html__( 'Below the content', 'piqes' ),
				'float' => esc_html__( 'Floating bar', 'piqes' ),
			)
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return header/footer types
if ( ! function_exists( 'piqes_get_list_header_footer_types' ) ) {
	function piqes_get_list_header_footer_types( $prepend_inherit = false ) {
		$list = apply_filters(
			'piqes_filter_list_header_footer_types', array(
				'default' => esc_html__( 'Default', 'piqes' ),
			)
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return header styles
if ( ! function_exists( 'piqes_get_list_header_styles' ) ) {
	function piqes_get_list_header_styles( $prepend_inherit = false ) {
		static $list = false;
		if ( ! $list ) {
			$list = apply_filters( 'piqes_filter_list_header_styles', array() );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return header positions
if ( ! function_exists( 'piqes_get_list_header_positions' ) ) {
	function piqes_get_list_header_positions( $prepend_inherit = false ) {
		$list = array(
			'default' => esc_html__( 'Default', 'piqes' ),
			'over'    => esc_html__( 'Over', 'piqes' ),
			'under'   => esc_html__( 'Under', 'piqes' ),
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return footer styles
if ( ! function_exists( 'piqes_get_list_footer_styles' ) ) {
	function piqes_get_list_footer_styles( $prepend_inherit = false ) {
		static $list = false;
		if ( ! $list ) {
			$list = apply_filters( 'piqes_filter_list_footer_styles', array() );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return body styles list, prepended inherit
if ( ! function_exists( 'piqes_get_list_body_styles' ) ) {
	function piqes_get_list_body_styles( $prepend_inherit = false, $force_fullscreen = false ) {
		$list = array(
			'boxed' => esc_html__( 'Boxed', 'piqes' ),
			'wide'  => esc_html__( 'Wide', 'piqes' ),
		);
		if ( apply_filters( 'piqes_filter_allow_fullscreen', piqes_get_theme_setting( 'allow_fullscreen' ) || $force_fullscreen || piqes_get_edited_post_type() == 'page' ) ) {
			$list['fullwide']   = esc_html__( 'Fullwidth', 'piqes' );
			$list['fullscreen'] = esc_html__( 'Fullscreen', 'piqes' );
		}
		$list = apply_filters( 'piqes_filter_list_body_styles', $list );
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return meta parts list
if ( ! function_exists( 'piqes_get_list_meta_parts' ) ) {
	function piqes_get_list_meta_parts( $prepend_inherit = false ) {
		$list = apply_filters(
			'piqes_filter_list_meta_parts',
			array(
				'author'     => esc_html__( 'Post author', 'piqes' ),
				'date'       => esc_html__( 'Post date', 'piqes' ),
				'views'      => esc_html__( 'Views', 'piqes' ),
				'likes'      => esc_html__( 'Likes', 'piqes' ),
				'comments'   => esc_html__( 'Comments', 'piqes' ),
				'share'      => esc_html__( 'Share links', 'piqes' ),
				'categories' => esc_html__( 'Categories', 'piqes' ),
				'edit'       => esc_html__( 'Edit link', 'piqes' ),
			)
		);
		// Reorder meta_parts with last user's choise
		if ( piqes_storage_isset( 'options', 'meta_parts', 'val' ) ) {
			$parts = explode( '|', piqes_get_theme_option( 'meta_parts' ) );
			$list_new = array();
			foreach( $parts as $part ) {
				$part = explode( '=', $part );
				if ( isset( $list[ $part[0] ] ) ) {
					$list_new[ $part[0] ] = $list[ $part[0] ];
					unset( $list[ $part[0] ] );
				}
			}
			$list = count( $list ) > 0 ? array_merge( $list_new, $list ) : $list_new;
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return blog styles list, prepended inherit
if ( ! function_exists( 'piqes_get_list_blog_styles' ) ) {
	function piqes_get_list_blog_styles( $prepend_inherit = false, $filter = 'arh' ) {
		$list   = array();
		$styles = piqes_storage_get( 'blog_styles' );
		if ( is_array( $styles ) ) {
			foreach ( $styles as $k => $v ) {
				if ( empty( $filter ) || empty( $v[ "{$filter}_allowed" ] ) || $v[ "{$filter}_allowed" ] ) {
					if ( 'arh' == $filter && isset( $v['columns'] ) && is_array( $v['columns'] ) ) {
						foreach ( $v['columns'] as $col ) {
							// Translators: Make blog style title: "Layout name /X columns/"
							$list[ "{$k}_{$col}" ] = sprintf( ' ' . _n( '%1$s /%2$d column/', '%1$s /%2$d columns/', $col, 'piqes' ), $v['title'], $col );
						}
					} else {
						$list[ $k ] = $v['title'];
					}
				}
			}
		}
		$list = apply_filters( 'piqes_filter_list_blog_styles', $list, $filter );
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}


// Return list of categories
if ( ! function_exists( 'piqes_get_list_categories' ) ) {
	function piqes_get_list_categories( $prepend_inherit = false ) {
		$list = piqes_storage_get( 'list_categories' );
		if ( '' == $list ) {
			$list       = array();
			$taxonomies = get_categories(
				array(
					'type'         => 'post',
					'orderby'      => 'name',
					'order'        => 'ASC',
					'hide_empty'   => 0,
					'hierarchical' => 1,
					'taxonomy'     => 'category',
					'pad_counts'   => false,
				)
			);
			if ( is_array( $taxonomies ) && count( $taxonomies ) > 0 ) {
				foreach ( $taxonomies as $cat ) {
					$list[ $cat->term_id ] = apply_filters( 'piqes_filter_term_name', $cat->name, $cat );
				}
			}
			piqes_storage_set( 'list_categories', $list );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}


// Return list of taxonomies
if ( ! function_exists( 'piqes_get_list_terms' ) ) {
	function piqes_get_list_terms( $prepend_inherit = false, $taxonomy = 'category' ) {
		$list = piqes_storage_get( 'list_taxonomies_' . ( $taxonomy ) );
		if ( '' == $list ) {
			$list       = array();
			$taxonomies = get_terms(
				$taxonomy, array(
					'orderby'      => 'name',
					'order'        => 'ASC',
					'hide_empty'   => 0,
					'hierarchical' => 1,
					'taxonomy'     => $taxonomy,
					'pad_counts'   => false,
				)
			);
			if ( is_array( $taxonomies ) && count( $taxonomies ) > 0 ) {
				foreach ( $taxonomies as $cat ) {
					$list[ $cat->term_id ] = apply_filters( 'piqes_filter_term_name', $cat->name, $cat );  // . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
			piqes_storage_set( 'list_taxonomies_' . ( $taxonomy ), $list );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return list of post's types
if ( ! function_exists( 'piqes_get_list_posts_types' ) ) {
	function piqes_get_list_posts_types( $prepend_inherit = false ) {
		$list = piqes_storage_get( 'list_posts_types' );
		if ( '' == $list ) {
			$list = apply_filters(
				'piqes_filter_list_posts_types', array(
					'post' => esc_html__( 'Post', 'piqes' ),
				)
			);
			piqes_storage_set( 'list_posts_types', $list );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( ! function_exists( 'piqes_get_list_posts' ) ) {
	function piqes_get_list_posts( $prepend_inherit = false, $opt = array() ) {
		$opt = array_merge(
			array(
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'post_parent'      => '',
				'taxonomy'         => 'category',
				'taxonomy_value'   => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'meta_compare'     => '',
				'suppress_filters' => false,  // Need to compatibility with WPML, because default value is true in the get_posts()
				'posts_per_page'   => -1,
				'orderby'          => 'post_date',
				'order'            => 'desc',
				'not_selected'     => true,
				'return'           => 'id',
			), is_array( $opt ) ? $opt : array( 'post_type' => $opt )
		);

		$hash = 'list_posts'
				. '_' . ( is_array( $opt['post_type'] ) ? join( '_', $opt['post_type'] ) : $opt['post_type'] )
				. '_' . ( is_array( $opt['post_parent'] ) ? join( '_', $opt['post_parent'] ) : $opt['post_parent'] )
				. '_' . ( $opt['taxonomy'] )
				. '_' . ( is_array( $opt['taxonomy_value'] ) ? join( '_', $opt['taxonomy_value'] ) : $opt['taxonomy_value'] )
				. '_' . ( $opt['meta_key'] )
				. '_' . ( $opt['meta_compare'] )
				. '_' . ( $opt['meta_value'] )
				. '_' . ( $opt['orderby'] )
				. '_' . ( $opt['order'] )
				. '_' . ( $opt['return'] )
				. '_' . ( $opt['posts_per_page'] );
		$list = piqes_storage_get( $hash );
		if ( '' == $list ) {
			$list = array();
			if ( false !== $opt['not_selected'] ) {
				$list['none'] = true === $opt['not_selected'] ? esc_html__( '- Not selected -', 'piqes' ) : $opt['not_selected'];
			}
			$args = array(
				'post_type'           => $opt['post_type'],
				'post_status'         => $opt['post_status'],
				'posts_per_page'      => -1 == $opt['posts_per_page'] ? 1000 : $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'             => $opt['orderby'],
				'order'               => $opt['order'],
			);
			if ( ! empty( $opt['post_parent'] ) ) {
				if ( is_array( $opt['post_parent'] ) ) {
					$args['post_parent__in'] = $opt['post_parent'];
				} else {
					$args['post_parent'] = $opt['post_parent'];
				}
			}
			if ( ! empty( $opt['taxonomy_value'] ) ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field'    => is_array( $opt['taxonomy_value'] )
										? ( (int) $opt['taxonomy_value'][0] > 0 ? 'term_taxonomy_id' : 'slug' )
										: ( (int) $opt['taxonomy_value'] > 0 ? 'term_taxonomy_id' : 'slug' ),
						'terms'    => is_array( $opt['taxonomy_value'] )
										? $opt['taxonomy_value']
										: ( (int) $opt['taxonomy_value'] > 0 ? (int) $opt['taxonomy_value'] : $opt['taxonomy_value'] ),
					),
				);
			}
			if ( ! empty( $opt['meta_key'] ) ) {
				$args['meta_key'] = $opt['meta_key'];
			}
			if ( ! empty( $opt['meta_value'] ) ) {
				$args['meta_value'] = $opt['meta_value'];
			}
			if ( ! empty( $opt['meta_compare'] ) ) {
				$args['meta_compare'] = $opt['meta_compare'];
			}
			$posts = get_posts( $args );
			if ( is_array( $posts ) && count( $posts ) > 0 ) {
				foreach ( $posts as $post ) {
					$list[ 'id' == $opt['return'] ? $post->ID : $post->post_title ] = $post->post_title;
				}
			}
			piqes_storage_set( $hash, $list );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}


// Return list of registered users
if ( ! function_exists( 'piqes_get_list_users' ) ) {
	function piqes_get_list_users( $prepend_inherit = false, $roles = array( 'administrator', 'editor', 'author', 'contributor', 'shop_manager' ) ) {
		$list = piqes_storage_get( 'list_users' );
		if ( '' == $list ) {
			$list         = array();
			$list['none'] = esc_html__( '- Not selected -', 'piqes' );
			$users        = get_users(
				array(
					'orderby' => 'display_name',
					'order'   => 'ASC',
				)
			);
			if ( is_array( $users ) && count( $users ) > 0 ) {
				foreach ( $users as $user ) {
					$accept = true;
					if ( is_array( $user->roles ) ) {
						if ( is_array( $user->roles ) && count( $user->roles ) > 0 ) {
							$accept = false;
							foreach ( $user->roles as $role ) {
								if ( in_array( $role, $roles ) ) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ( $accept ) {
						$list[ $user->user_login ] = $user->display_name;
					}
				}
			}
			piqes_storage_set( 'list_users', $list );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return menus list, prepended inherit
if ( ! function_exists( 'piqes_get_list_menus' ) ) {
	function piqes_get_list_menus( $prepend_inherit = false ) {
		$list = piqes_storage_get( 'list_menus' );
		if ( '' == $list ) {
			$list            = array();
			$list['default'] = esc_html__( 'Default', 'piqes' );
			$menus           = wp_get_nav_menus();
			if ( is_array( $menus ) && count( $menus ) > 0 ) {
				foreach ( $menus as $menu ) {
					$list[ $menu->slug ] = $menu->name;
				}
			}
			piqes_storage_set( 'list_menus', $list );
		}
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}


// Return list of the specified icons (font icons, svg icons or png icons)
if ( ! function_exists( 'piqes_get_list_icons' ) ) {
	function piqes_get_list_icons( $style ) {
		$lists = get_transient( 'piqes_list_icons' );
		if ( ! is_array( $lists ) || ! isset( $lists[ $style ] ) || ! is_array( $lists[ $style ] ) || count( $lists[ $style ] ) < 2 ) {
			if ( 'icons' == $style ) {
				$lists[ $style ] = piqes_array_from_list( piqes_get_list_icons_classes() );
			} elseif ( 'images' == $style ) {
				$lists[ $style ] = piqes_get_list_images();
			} else { //if ( 'svg' == $style )
				$lists[ $style ] = piqes_get_list_images( false, 'svg' );
			}
			if ( is_admin() && is_array( $lists[ $style ] ) && count( $lists[ $style ] ) > 1 ) {
				set_transient( 'piqes_list_icons', $lists, 12 * 60 * 60 );       // Store to the cache for 12 hours
			}
		}
		return $lists[ $style ];
	}
}

// Return iconed classes list
if ( ! function_exists( 'piqes_get_list_icons_classes' ) ) {
	function piqes_get_list_icons_classes( $prepend_inherit = false ) {
		static $list = false;
		if ( ! is_array( $list ) ) {
			$list = ! is_admin() ? array() : piqes_parse_icons_classes( piqes_get_file_dir( 'css/font-icons/css/fontello-codes.css' ) );
		}
		$list = piqes_array_merge( array( 'none' => 'none' ), $list );
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}

// Return images list
if ( ! function_exists( 'piqes_get_list_images' ) ) {
	function piqes_get_list_images( $prepend_inherit = false, $type = 'png' ) {
		$list = function_exists( 'trx_addons_get_list_files' )
				? trx_addons_get_list_files( "css/icons.{$type}", $type )
				: array();
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}


// Additional attributes for VC and SOW
//----------------------------------------------------
if ( ! function_exists( 'piqes_get_list_sc_color_styles' ) ) {
	function piqes_get_list_sc_color_styles( $prepend_inherit = false ) {
		$list = apply_filters(
			'piqes_filter_get_list_sc_color_styles', array(
				'default' => esc_html__( 'Default', 'piqes' ),
				'link2'   => esc_html__( 'Link 2', 'piqes' ),
				'link3'   => esc_html__( 'Link 3', 'piqes' ),
				'dark'    => esc_html__( 'Dark', 'piqes' ),
			)
		);
		return $prepend_inherit ? piqes_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'piqes' ) ), $list ) : $list;
	}
}
