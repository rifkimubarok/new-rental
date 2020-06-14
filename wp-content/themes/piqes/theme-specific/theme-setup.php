<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.22
 */

// If this theme is a free version of premium theme
if ( ! defined( 'PIQES_THEME_FREE' ) ) {
	define( 'PIQES_THEME_FREE', false );
}
if ( ! defined( 'PIQES_THEME_FREE_WP' ) ) {
	define( 'PIQES_THEME_FREE_WP', false );
}

// If this theme is a part of Envato Elements
if ( ! defined( 'PIQES_THEME_IN_ENVATO_ELEMENTS' ) ) {
	define( 'PIQES_THEME_IN_ENVATO_ELEMENTS', false );
}

// If this theme uses multiple skins
if ( ! defined( 'PIQES_ALLOW_SKINS' ) ) {
	define( 'PIQES_ALLOW_SKINS', false );
}
if ( ! defined( 'PIQES_DEFAULT_SKIN' ) ) {
	define( 'PIQES_DEFAULT_SKIN', 'default' );
}



// Theme storage
// Attention! Must be in the global namespace to compatibility with WP CLI
//-------------------------------------------------------------------------
$GLOBALS['PIQES_STORAGE'] = array(

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'       => 'env-ancora',

	// Generate Personal token from Envato to automatic upgrade theme
	'upgrade_token_url'   => '//build.envato.com/create-token/?default=t&purchase:download=t&purchase:list=t',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'      => '//piqes.ancorathemes.com',
	'theme_doc_url'       => '//piqes.ancorathemes.com/doc',

	'theme_upgrade_url'   => '//upgrade.themerex.net/',

	'theme_demofiles_url' => '//demofiles.ancorathemes.com/piqes/',
	
	'theme_rate_url'      => '//themeforest.net/download',

	'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

	'theme_download_url'  => '//themeforest.net/user/ancorathemes/portfolio',        // Ancora

	'theme_support_url'   => '//ancorathemes.ticksy.com/',                           // Ancora

	'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   // Ancora

	'theme_privacy_url'   => '//ancorathemes.com/privacy-policy/',                   // Ancora

	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'    => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'          => array(
		// By size
		'xxl'        => array( 'max' => 1679 ),
		'xl'         => array( 'max' => 1439 ),
		'lg'         => array( 'max' => 1279 ),
		'md_over'    => array( 'min' => 1024 ),
		'md'         => array( 'max' => 1023 ),
		'sm'         => array( 'max' => 767 ),
		'sm_wp'      => array( 'max' => 600 ),
		'xs'         => array( 'max' => 479 ),
		// By device
		'wide'       => array(
			'min' => 2160
		),
		'desktop'    => array(
			'min' => 1680,
			'max' => 2159,
		),
		'notebook'   => array(
			'min' => 1280,
			'max' => 1679,
		),
		'tablet'     => array(
			'min' => 768,
			'max' => 1279,
		),
		'not_mobile' => array(
			'min' => 768
		),
		'mobile'     => array(
			'max' => 767
		),
	),
);


//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'piqes_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'piqes_importer_set_options', 9 );
	function piqes_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Allow import/export functionality
			$options['allow_import'] = true;
			$options['allow_export'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url( piqes_get_protocol() . ':' . piqes_storage_get( 'theme_demofiles_url' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( piqes_storage_get( 'required_plugins' ) );
			// Set number of thumbnails (usually 3 - 5) to regenerate at once when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 0;
			// Default demo
			$options['files']['default']['title']       = esc_html__( 'Piqes Demo', 'piqes' );
			$options['files']['default']['domain_dev']  = '';                     // Developers domain
			$options['files']['default']['domain_demo'] = esc_url( piqes_get_protocol() . ':' . piqes_storage_get( 'theme_demo_url' ) );   // Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// For example:
			// 		$options['files']['dark_demo'] = $options['files']['default'];
			// 		$options['files']['dark_demo']['title'] = esc_html__('Dark Demo', 'piqes');
			
			// The array with theme-specific banners, displayed during demo-content import.
			// If array with banners is empty - the banners are uploaded directly from demo-content server.
			$options['banners'] = array();
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'piqes_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'piqes_ocdi_set_options', 9 );
	function piqes_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Prepare demo data
			$options['demo_url'] = esc_url( piqes_get_protocol() . ':' . piqes_storage_get( '//piqes.ancorathemes.com' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( piqes_storage_get( 'required_plugins' ) );
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Piqes OCDI Demo', 'piqes' );
			$options['files']['ocdi']['domain_demo'] = esc_url( piqes_get_protocol() . ':' . piqes_storage_get( 'theme_demo_url' ) );
			// If theme need more demo - just copy 'default' and change required parameter
			// For example:
			//$options['files']['dota']['title'] = esc_html__('Dota Paradise Demo', 'piqes');
			//$options['files']['dota']['domain_demo'] = esc_url(piqes_get_protocol().'://dota.themerex.net');
		}
		return $options;
	}
}



// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$piqes_theme_required_plugins_group = esc_html__( 'Core', 'piqes' );
$piqes_theme_required_plugins = array(
	// Section: "CORE" (required plugins)
	// DON'T COMMENT OR REMOVE NEXT LINES!
	'trx_addons'         => array(
								'title'       => esc_html__( 'ThemeREX Addons', 'piqes' ),
								'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'piqes' ),
								'required'    => true,
								'logo'        => 'logo.png',
								'group'       => $piqes_theme_required_plugins_group,
							),
);

// Section: "PAGE BUILDERS"
$piqes_theme_required_plugins_group = esc_html__( 'Page Builders', 'piqes' );
$piqes_theme_required_plugins['elementor'] = array(
	'title'       => esc_html__( 'Elementor', 'piqes' ),
	'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'piqes' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $piqes_theme_required_plugins_group,
);
$piqes_theme_required_plugins['gutenberg'] = array(
	'title'       => esc_html__( 'Gutenberg', 'piqes' ),
	'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'piqes' ),
	'required'    => false,
	'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
	'logo'        => 'logo.png',
	'group'       => $piqes_theme_required_plugins_group,
);
if ( ! PIQES_THEME_FREE ) {
	$piqes_theme_required_plugins['js_composer']          = array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'piqes' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'piqes' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'logo.jpg',
		'group'       => $piqes_theme_required_plugins_group,
	);
}


// Section: "SOCIALS & COMMUNITIES"
$piqes_theme_required_plugins_group = esc_html__( 'Socials and Communities', 'piqes' );
$piqes_theme_required_plugins['mailchimp-for-wp'] = array(
	'title'       => esc_html__( 'MailChimp for WP', 'piqes' ),
	'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'piqes' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $piqes_theme_required_plugins_group,
);

// Section: "CONTENT"
$piqes_theme_required_plugins_group = esc_html__( 'Content', 'piqes' );
$piqes_theme_required_plugins['contact-form-7'] = array(
	'title'       => esc_html__( 'Contact Form 7', 'piqes' ),
	'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'piqes' ),
	'required'    => false,
	'logo'        => 'logo.jpg',
	'group'       => $piqes_theme_required_plugins_group,
);
if ( ! PIQES_THEME_FREE ) {
	$piqes_theme_required_plugins['essential-grid']             = array(
		'title'       => esc_html__( 'Essential Grid', 'piqes' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $piqes_theme_required_plugins_group,
	);
	$piqes_theme_required_plugins['sitepress-multilingual-cms'] = array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'piqes' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'piqes' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'logo.png',
		'group'       => $piqes_theme_required_plugins_group,
	);
}

// Section: "OTHER"
$piqes_theme_required_plugins_group = esc_html__( 'Other', 'piqes' );
$piqes_theme_required_plugins['wp-gdpr-compliance'] = array(
	'title'       => esc_html__( 'WP GDPR Compliance', 'piqes' ),
	'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'piqes' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $piqes_theme_required_plugins_group,
);

// Add plugins list to the global storage
$GLOBALS['PIQES_STORAGE']['required_plugins'] = $piqes_theme_required_plugins;



// THEME-SPECIFIC BLOG LAYOUTS
//----------------------------------------------
$piqes_theme_blog_styles = array(
	'excerpt' => array(
		'title'   => esc_html__( 'Standard', 'piqes' ),
		'archive' => 'index-excerpt',
		'item'    => 'content-excerpt',
		'styles'  => 'excerpt',
	),
	'classic' => array(
		'title'   => esc_html__( 'Classic', 'piqes' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'classic',
	),
);
if ( ! PIQES_THEME_FREE ) {
	$piqes_theme_blog_styles['masonry']   = array(
		'title'   => esc_html__( 'Masonry', 'piqes' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'masonry',
	);
	$piqes_theme_blog_styles['portfolio'] = array(
		'title'   => esc_html__( 'Portfolio', 'piqes' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio',
		'columns' => array( 2, 3, 4 ),
		'styles'  => 'portfolio',
	);
	$piqes_theme_blog_styles['gallery']   = array(
		'title'   => esc_html__( 'Gallery', 'piqes' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio-gallery',
		'columns' => array( 2, 3, 4 ),
		'styles'  => array( 'portfolio', 'gallery' ),
	);
	$piqes_theme_blog_styles['chess']     = array(
		'title'   => esc_html__( 'Chess', 'piqes' ),
		'archive' => 'index-chess',
		'item'    => 'content-chess',
		'columns' => array( 1, 2, 3 ),
		'styles'  => 'chess',
	);
}

// Add list of blog styles to the global storage
$GLOBALS['PIQES_STORAGE']['blog_styles'] = $piqes_theme_blog_styles;


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'piqes_customizer_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'piqes_customizer_theme_setup1', 1 );
	function piqes_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		piqes_storage_set(
			'settings', array(

				'duplicate_options'      => 'child',                    // none  - use separate options for the main and the child-theme
																		// child - duplicate theme options from the main theme to the child-theme only
																		// both  - sinchronize changes in the theme options between main and child themes

				'customize_refresh'      => 'auto',                     // Refresh method for preview area in the Appearance - Customize:
																		// auto - refresh preview area on change each field with Theme Options
																		// manual - refresh only obn press button 'Refresh' at the top of Customize frame

				'max_load_fonts'         => 5,                          // Max fonts number to load from Google fonts or from uploaded fonts

				'comment_after_name'     => true,                       // Place 'comment' field after the 'name' and 'email'

				'show_author_avatar'     => true,                       // Display author's avatar in the post meta

				'icons_selector'         => 'internal',                 // Icons selector in the shortcodes:
																		// vc (default) - standard VC (very slow) or Elementor's icons selector (not support images and svg)
																		// internal - internal popup with plugin's or theme's icons list (fast and support images and svg)

				'icons_type'             => 'icons',                    // Type of icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present icons
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'socials_type'           => 'icons',                    // Type of socials icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present social networks
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'check_min_version'      => true,                       // Check if exists a .min version of .css and .js and return path to it
																		// instead the path to the original file
																		// (if debug_mode is on and modification time of the original file < time of the .min file)

				'autoselect_menu'        => false,                      // Show any menu if no menu selected in the location 'main_menu'
																		// (for example, the theme is just activated)

				'disable_jquery_ui'      => false,                      // Prevent loading custom jQuery UI libraries in the third-party plugins

				'use_mediaelements'      => true,                       // Load script "Media Elements" to play video and audio

				'tgmpa_upload'           => false,                      // Allow upload not pre-packaged plugins via TGMPA

				'allow_no_image'         => false,                      // Allow to use theme-specific image placeholder if no image present in the blog, related posts, post navigation, etc.

				'separate_schemes'       => true,                       // Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

				'allow_fullscreen'       => false,                      // Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
																		// In the Page Options this styles are present always
																		// (can be removed if filter 'piqes_filter_allow_fullscreen' return false)

				'attachments_navigation' => false,                      // Add arrows on the single attachment page to navigate to the prev/next attachment

				'gutenberg_safe_mode'    => array(),                    // 'vc', 'elementor' - Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)

				'gutenberg_add_context'  => false,                      // Add context to the Gutenberg editor styles with our method (if true - use if any problem with editor styles) or use native Gutenberg way via add_editor_style() (if false - used by default)

				'allow_gutenberg_blocks' => true,                       // Allow our shortcodes and widgets as blocks in the Gutenberg (not ready yet - in the development now)

				'subtitle_above_title'   => true,                       // Put subtitle above the title in the shortcodes

				'add_hide_on_xxx'        => 'replace',                  // Add our breakpoints to the Responsive section of each element
																		// 'add' - add our breakpoints after Elementor's
																		// 'replace' - add our breakpoints instead Elementor's
																		// 'none' - don't add our breakpoints (using only Elementor's)
			)
		);

		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------

		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		piqes_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Ubuntu',
					'family' => 'sans-serif',
					'styles' => '300,300italic,400,400italic,500,500italic,700,700italic',     // Parameter 'style' used only for the Google fonts
				),
                array(
                    'name'   => 'Rubik',
                    'family' => 'sans-serif',
                    'styles' => '300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',     // Parameter 'style' used only for the Google fonts
                ),
//				// Font-face packed with theme
//				array(
//					'name'   => 'Montserrat',
//					'family' => 'sans-serif',
//				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		piqes_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		// For example:	'font-family' => '"Roboto",sans-serif'	- is correct
		// 				'font-family' => '"Roboto", sans-serif'	- is incorrect
		// 				'font-family' => 'Roboto,sans-serif'	- is incorrect

		piqes_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'piqes' ),
					'description'     => esc_html__( 'Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'piqes' ),
					'font-family'     => '"Rubik",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5625em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.9em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'piqes' ),
					'font-family'     => '"Ubuntu",sans-serif',
					'font-size'       => '2.5rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.02em',
					'margin-top'      => '2.15em',
					'margin-bottom'   => '0.92em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'piqes' ),
					'font-family'     => '"Ubuntu",sans-serif',
					'font-size'       => '2.125rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.117em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.02em',
					'margin-top'      => '1.6em',
					'margin-bottom'   => '0.99em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'piqes' ),
					'font-family'     => '"Ubuntu",sans-serif',
					'font-size'       => '1.687rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.149em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.02em',
					'margin-top'      => '1.95em',
					'margin-bottom'   => '0.83em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'piqes' ),
					'font-family'     => '"Ubuntu",sans-serif',
					'font-size'       => '1.375em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.28em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '2.13em',
					'margin-bottom'   => '1.3em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'piqes' ),
					'font-family'     => '"Ubuntu",sans-serif',
					'font-size'       => '1.251em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.3em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '2.3em',
					'margin-bottom'   => '1.3em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'piqes' ),
					'font-family'     => '"Rubik",sans-serif',
					'font-size'       => '1.062rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.362em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '2.15em',
					'margin-bottom'   => '1.34em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'piqes' ),
					'description'     => esc_html__( 'Font settings of the text case of the logo', 'piqes' ),
					'font-family'     => '"Ubuntu",sans-serif',
					'font-size'       => '2rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '-0.02em',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'piqes' ),
					'font-family'     => '"Ubuntu",sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '22px',
					'text-decoration' => 'none',
					'text-transform'  => 'capitalize',
					'letter-spacing'  => '0',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'piqes' ),
					'description'     => esc_html__( 'Font settings of the input fields, dropdowns and textareas', 'piqes' ),
					'font-family'     => 'Rubik',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em', // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'piqes' ),
					'description'     => esc_html__( 'Font settings of the post meta: date, counters, share, etc.', 'piqes' ),
					'font-family'     => 'Rubik',
					'font-size'       => '0.875rem',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.6em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'piqes' ),
					'description'     => esc_html__( 'Font settings of the main menu items', 'piqes' ),
					'font-family'     => '"Ubuntu",sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '20px',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'piqes' ),
					'description'     => esc_html__( 'Font settings of the dropdown menu items', 'piqes' ),
					'font-family'     => '"Rubik",sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
			)
		);

		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		piqes_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => __( 'Main', 'piqes' ),
					'description' => __( 'Colors of the main content area', 'piqes' ),
				),
				'alter'   => array(
					'title'       => __( 'Alter', 'piqes' ),
					'description' => __( 'Colors of the alternative blocks (sidebars, etc.)', 'piqes' ),
				),
				'extra'   => array(
					'title'       => __( 'Extra', 'piqes' ),
					'description' => __( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'piqes' ),
				),
				'inverse' => array(
					'title'       => __( 'Inverse', 'piqes' ),
					'description' => __( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'piqes' ),
				),
				'input'   => array(
					'title'       => __( 'Input', 'piqes' ),
					'description' => __( 'Colors of the form fields (text field, textarea, select, etc.)', 'piqes' ),
				),
			)
		);
		piqes_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => __( 'Background color', 'piqes' ),
					'description' => __( 'Background color of this block in the normal state', 'piqes' ),
				),
				'bg_hover'    => array(
					'title'       => __( 'Background hover', 'piqes' ),
					'description' => __( 'Background color of this block in the hovered state', 'piqes' ),
				),
				'bd_color'    => array(
					'title'       => __( 'Border color', 'piqes' ),
					'description' => __( 'Border color of this block in the normal state', 'piqes' ),
				),
				'bd_hover'    => array(
					'title'       => __( 'Border hover', 'piqes' ),
					'description' => __( 'Border color of this block in the hovered state', 'piqes' ),
				),
				'text'        => array(
					'title'       => __( 'Text', 'piqes' ),
					'description' => __( 'Color of the plain text inside this block', 'piqes' ),
				),
				'text_dark'   => array(
					'title'       => __( 'Text dark', 'piqes' ),
					'description' => __( 'Color of the dark text (bold, header, etc.) inside this block', 'piqes' ),
				),
				'text_light'  => array(
					'title'       => __( 'Text light', 'piqes' ),
					'description' => __( 'Color of the light text (post meta, etc.) inside this block', 'piqes' ),
				),
				'text_link'   => array(
					'title'       => __( 'Link', 'piqes' ),
					'description' => __( 'Color of the links inside this block', 'piqes' ),
				),
				'text_hover'  => array(
					'title'       => __( 'Link hover', 'piqes' ),
					'description' => __( 'Color of the hovered state of links inside this block', 'piqes' ),
				),
				'text_link2'  => array(
					'title'       => __( 'Link 2', 'piqes' ),
					'description' => __( 'Color of the accented texts (areas) inside this block', 'piqes' ),
				),
				'text_hover2' => array(
					'title'       => __( 'Link 2 hover', 'piqes' ),
					'description' => __( 'Color of the hovered state of accented texts (areas) inside this block', 'piqes' ),
				),
				'text_link3'  => array(
					'title'       => __( 'Link 3', 'piqes' ),
					'description' => __( 'Color of the other accented texts (buttons) inside this block', 'piqes' ),
				),
				'text_hover3' => array(
					'title'       => __( 'Link 3 hover', 'piqes' ),
					'description' => __( 'Color of the hovered state of other accented texts (buttons) inside this block', 'piqes' ),
				),
			)
		);
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'piqes' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff',//
					'bd_color'         => '#ebebeb',//

					// Text and links colors
					'text'             => '#7e7b8a',//
					'text_light'       => '#9693a2',//
					'text_dark'        => '#160742',//
					'text_link'        => '#7154f8',//
					'text_hover'       => '#6146dd',//
					'text_link2'       => '#73c32f',//
					'text_hover2'      => '#5eb315',//
					'text_link3'       => '#362682',//
					'text_hover3'      => '#2b1e6b',//

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#f8f7fa',//
					'alter_bg_hover'   => '#fcfcfc',//
					'alter_bd_color'   => '#ebebeb',//
					'alter_bd_hover'   => '#ffffff',//
					'alter_text'       => '#7e7b8a',//
					'alter_light'      => '#9693a2',//
					'alter_dark'       => '#160742',//
					'alter_link'       => '#7154f8',//
					'alter_hover'      => '#6146dd',//
					'alter_link2'      => '#73c32f',//
					'alter_hover2'     => '#5eb315',//
					'alter_link3'      => '#362682',//
					'alter_hover3'     => '#2b1e6b',//

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#160742',//
					'extra_bg_hover'   => '#28272e',
					'extra_bd_color'   => '#26323f',//
					'extra_bd_hover'   => '#ebebeb',//
					'extra_text'       => '#b8b6bb',//
					'extra_light'      => '#888f96',//
					'extra_dark'       => '#b8b6bb',//
					'extra_link'       => '#73c32f',//
					'extra_hover'      => '#fe7259',
					'extra_link2'      => '#160742',//
					'extra_hover2'     => '#5eb315',//
					'extra_link3'      => '#7e7b8a',//
					'extra_hover3'     => '#ffffff',//

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#ffffff',//
					'input_bg_hover'   => '#ffffff',//
					'input_bd_color'   => '#e4e3e6',//
					'input_bd_hover'   => '#d7d7d9',//
					'input_text'       => '#9693a2',//
					'input_light'      => '#e3e9ee',//
					'input_dark'       => '#7e7b8a',//

					// Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bg_color' => '#ffffff',//
                    'inverse_bg_hover' => '#000000',//
					'inverse_bd_color' => '#160742',//
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#ffffff',//
					'inverse_light'    => '#bcc3e1',//
					'inverse_dark'     => '#29313a',//
					'inverse_link'     => '#ffffff',//
					'inverse_hover'    => '#ffffff',//
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'piqes' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#160742',//
					'bd_color'         => '#2c1d58',//

					// Text and links colors
					'text'             => '#b8b6bb',//
					'text_light'       => '#e5e1e8',//
					'text_dark'        => '#ffffff',//
					'text_link'        => '#73c32f',//
					'text_hover'       => '#5eb315',//
					'text_link2'       => '#7154f8',//
					'text_hover2'      => '#6146dd',//
					'text_link3'       => '#362682',//
					'text_hover3'      => '#2b1e6b',//

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0d0426',//
					'alter_bg_hover'   => '#140a30',//
					'alter_bd_color'   => '#2c1d58',//
					'alter_bd_hover'   => '#1e0c54',//
					'alter_text'       => '#b8b6bb',//
					'alter_light'      => '#e5e1e8',//
					'alter_dark'       => '#ffffff',//
					'alter_link'       => '#73c32f',//
					'alter_hover'      => '#5eb315',//
					'alter_link2'      => '#7154f8',//
					'alter_hover2'     => '#6146dd',//
					'alter_link3'      => '#362682',//
					'alter_hover3'     => '#2b1e6b',//

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#ffffff',//
					'extra_bg_hover'   => '#f3f5f7',//
					'extra_bd_color'   => '#ebebeb',//
					'extra_bd_hover'   => '#362682',//
					'extra_text'       => '#7e7b8a',//
					'extra_light'      => '#9693a2',//
					'extra_dark'       => '#7e7b8a',//
					'extra_link'       => '#73c32f',//
					'extra_hover'      => '#fe7259',
					'extra_link2'      => '#160742',//
					'extra_hover2'     => '#5eb315',//
					'extra_link3'      => '#ffffff',//
					'extra_hover3'     => '#160742',//

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#160742',//
					'input_bg_hover'   => '#160742',//
					'input_bd_color'   => '#3b2f60',//
					'input_bd_hover'   => '#524773',//
					'input_text'       => '#b8b6bb',//
					'input_light'      => '#6f6f6f',
					'input_dark'       => '#ffffff',//

					// Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bg_color' => '#0d0426',//
                    'inverse_bg_hover' => '#ffffff',//
					'inverse_bd_color' => '#ffffff',//
					'inverse_bd_hover' => '#333860',//
					'inverse_text'     => '#f4f4f4',//
					'inverse_light'    => '#a8aec3',//
					'inverse_dark'     => '#000000',
					'inverse_link'     => '#ffffff',//
					'inverse_hover'    => '#ffffff',//
				),
			),
		);
		piqes_storage_set( 'schemes', $schemes );
		piqes_storage_set( 'schemes_original', $schemes );
		
		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		piqes_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		piqes_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
                'extra_bg_color_013' => array(
                    'color' => 'extra_bg_color',
                    'alpha' => 0.13,
                ),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
				'text_link_07'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.7,
                ),
                'text_link3_02'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.2,
                ),
                'inverse_bd_color_012'      => array(
                    'color' => 'inverse_bd_color',
                    'alpha' => 0.12,
                ),
                'inverse_bd_color_006'      => array(
                    'color' => 'inverse_bg_hover',
                    'alpha' => 0.06,
                ),
                'inverse_bd_color_008'      => array(
                    'color' => 'inverse_bg_hover',
                    'alpha' => 0.08,
                ),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Parameters to set order of schemes in the css
		piqes_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		piqes_storage_set(
			'theme_thumbs', apply_filters(
				'piqes_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'piqes-thumb-huge'        => array(
						'size'  => array( 1170, 658, true ),
						'title' => esc_html__( 'Huge image', 'piqes' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'piqes-thumb-big'         => array(
						'size'  => array( 912, 536, true ),
						'title' => esc_html__( 'Large image', 'piqes' ),
						'subst' => 'trx_addons-thumb-big',
					),

					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'piqes-thumb-med'         => array(
						'size'  => array( 370, 258, true ),
						'title' => esc_html__( 'Medium image', 'piqes' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'piqes-thumb-tiny'        => array(
						'size'  => array( 90, 90, true ),
						'title' => esc_html__( 'Small square avatar', 'piqes' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'piqes-thumb-masonry-big' => array(
						'size'  => array( 760, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'piqes' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'piqes-thumb-masonry'     => array(
						'size'  => array( 370, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'piqes' ),
						'subst' => 'trx_addons-thumb-masonry',
					),

                    // Height is fixed
                    'piqes-thumb-square-med'         => array(
                        'size'  => array( 370, 370, true ),
                        'title' => esc_html__( 'Square Medium image', 'piqes' ),
                        'subst' => 'trx_addons-thumb-square-medium',
                    ),

                    // Height is fixed
                    'piqes-thumb-med-related'         => array(
                        'size'  => array( 444, 310, true ),
                        'title' => esc_html__( 'Medium image', 'piqes' ),
                        'subst' => 'trx_addons-thumb-medium-related',
                    ),
				)
			)
		);
	}
}


// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if ( ! function_exists( 'piqes_create_theme_options' ) ) {

	function piqes_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'piqes' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( piqes_storage_get( 'schemes' ) ) < 2;

		piqes_storage_set(

			'options', array(

				// 'Logo & Site Identity'
				//---------------------------------------------
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'piqes' ),
					'desc'     => '',
					'priority' => 10,
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'piqes' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'piqes' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'piqes' ) ),
					'class'    => 'piqes_column-1_2 piqes_new_row',
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'piqes' ),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'piqes' ) ),
					'class'    => 'piqes_column-1_2',
					'priority' => 40,
					'refresh'  => false,
					'std'      => 0,
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_zoom'                     => array(
					'title'   => esc_html__( 'Logo zoom', 'piqes' ),
					'desc'    => wp_kses_post(
									__( 'Zoom the logo (set 1 to leave original size).', 'piqes' )
									. ' <br>'
									. __( 'Attention! For this parameter to affect images, their max-height should be specified in "em" instead of "px" when creating a header.', 'piqes' )
									. ' <br>'
									. __( 'In this case maximum size of logo depends on the actual size of the picture.', 'piqes' )
								),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => PIQES_THEME_FREE ? 'hidden' : 'slider',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'piqes' ) ),
					'class'      => 'piqes_column-1_2',
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'piqes' ) ),
					'class' => 'piqes_column-1_2 piqes_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'piqes' ) ),
					'class'      => 'piqes_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'piqes' ) ),
					'class' => 'piqes_column-1_2 piqes_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'piqes' ) ),
					'class'      => 'piqes_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_side'                     => array(
					'title' => esc_html__( 'Logo for the side menu', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu', 'piqes' ) ),
					'class' => 'piqes_column-1_2 piqes_new_row',
					'std'   => '',
					'type'  => 'hidden',
				),
				'logo_side_retina'              => array(
					'title'      => esc_html__( 'Logo for the side menu on Retina', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'piqes' ) ),
					'class'      => 'piqes_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'hidden',
				),



				// 'General settings'
				//---------------------------------------------
				'general'                       => array(
					'title'    => esc_html__( 'General', 'piqes' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'piqes' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'piqes' ),
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'qsetup'   => esc_html__( 'General', 'piqes' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => piqes_get_list_body_styles( false ),
					'type'     => 'select',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'piqes' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => 1170,
					'min'        => 1000,
					'max'        => 1600,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page',               // SASS variable's name to preview changes 'on fly'
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'slider',
				),
				'page_boxed_extra'             => array(
					'title'      => esc_html__( 'Boxed page extra spaces', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Width of the extra side space on boxed pages', 'piqes' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'std'        => 60,
					'min'        => 0,
					'max'        => 150,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page_boxed_extra',   // SASS variable's name to preview changes 'on fly'
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'piqes' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'piqes' ),
					//'hidden'     => true,
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Remove margins', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Remove margins above and below the content area', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'type'     => 'checkbox',
				),

				'general_sidebar_info'          => array(
					'title' => esc_html__( 'Sidebar', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'piqes' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_position_ss'       => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'piqes' ),
					'desc'     => wp_kses_data( __( "Select position to move sidebar (if it's not hidden) on the small screen - above or below the content", 'piqes' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_ss_single'
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'below',
					'qsetup'   => esc_html__( 'General', 'piqes' ),
					'options'  => array(),
					'type'     => 'hidden',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_widgets_single'
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'piqes' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width', 'piqes' ) ),
					'std'        => 370,
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'sidebar',      // SASS variable's name to preview changes 'on fly'
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'piqes' ) ),
					'std'        => 40,
					'min'        => 0,
					'max'        => 100,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'gap',          // SASS variable's name to preview changes 'on fly'
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'slider',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Expand content', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'piqes' ) ),
					'refresh' => false,
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'std'     => 1,
					'type'    => 'checkbox',
				),

				'general_widgets_info'          => array(
					'title' => esc_html__( 'Additional widgets', 'piqes' ),
					'desc'  => '',
					'hidden' => true,
					'type'  => PIQES_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page'            => array(
					'title'    => esc_html__( 'Widgets at the top of the page', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'hidden',
				),
				'widgets_above_content'         => array(
					'title'    => esc_html__( 'Widgets above the content', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'hidden',
				),
				'widgets_below_content'         => array(
					'title'    => esc_html__( 'Widgets below the content', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'hidden',
				),
				'widgets_below_page'            => array(
					'title'    => esc_html__( 'Widgets at the bottom of the page', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'hidden',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'piqes' ) ),
					'std'        => 0,
					'min'        => 0,
					'max'        => 20,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'type'       => 'hidden',
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'piqes' ),
					'desc'  => '',
					'type'  => PIQES_THEME_FREE ? 'hidden' : 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'piqes' ) ),
					'std'   => 0,
					'type'  => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'privacy_text' => array(
					"title" => esc_html__("Text with Privacy Policy link", 'piqes'),
					"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'piqes') ),
					"std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'piqes') ),
					"type"  => "hidden"
				),



				// 'Header'
				//---------------------------------------------
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'piqes' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'std'      => 'default',
					'options'  => piqes_get_list_header_footer_types(),
					'type'     => PIQES_THEME_FREE || ! piqes_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'piqes' ),
					'desc'       => wp_kses_post( __( 'Select custom header from Layouts Builder', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => 'header-custom-elementor-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'type'     => 'hidden',
				),
				'header_fullheight'             => array(
					'title'    => esc_html__( 'Header fullheight', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill the whole screen. Used only if the header has a background image', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'std'      => 0,
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_wide'                   => array(
					'title'      => esc_html__( 'Header fullwidth', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'hidden',
				),
				'header_zoom'                   => array(
					'title'   => esc_html__( 'Header zoom', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Zoom the header title. 1 - original size', 'piqes' ) ),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => PIQES_THEME_FREE ? 'hidden' : 'slider',
				),

				'header_widgets_info'           => array(
					'title' => esc_html__( 'Header widgets', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Here you can place a widget slider, advertising banners, etc.', 'piqes' ) ),
                    'hidden' => true,
					'type'  => 'info',
				),
				'header_widgets'                => array(
					'title'    => esc_html__( 'Header widgets', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select set of widgets to show in the header on each page', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
						'desc'    => wp_kses_data( __( 'Select set of widgets to show in the header on this page', 'piqes' ) ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'hidden',
				),
				'header_columns'                => array(
					'title'      => esc_html__( 'Header columns', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'dependency' => array(
						'header_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => piqes_get_list_range( 0, 6 ),
					'type'       => 'hidden',
				),

				'menu_info'                     => array(
					'title' => esc_html__( 'Main menu', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select main menu style, position and other parameters', 'piqes' ) ),
					'type'  => PIQES_THEME_FREE ? 'hidden' : 'info',
				),
				'menu_style'                    => array(
					'title'    => esc_html__( 'Menu position', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position of the main menu', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'std'      => 'top',
					'options'  => array(
						'top'   => esc_html__( 'Top', 'piqes' ),
						'left'  => esc_html__( 'Left', 'piqes' ),
						'right' => esc_html__( 'Right', 'piqes' ),
					),
					'type'     => 'hidden',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 0,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'piqes' ) ),
					'std'   => 1,
					'type'  => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'piqes' ),
					'desc'  => '',
					'type'  => PIQES_THEME_FREE ? 'hidden' : 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'piqes' ),
					'desc'     => wp_kses_data( __( "Allow override the header image with the page's/post's/product's/etc. featured image", 'piqes' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'std'      => 0,
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'piqes' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'piqes' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'piqes' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'piqes' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'piqes' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'piqes' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'piqes' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'piqes' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),



				// 'Footer'
				//---------------------------------------------
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'piqes' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'piqes' ),
					),
					'std'      => 'default',
					'options'  => piqes_get_list_header_footer_types(),
					'type'     => PIQES_THEME_FREE || ! piqes_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'piqes' ),
					'desc'       => wp_kses_post( __( 'Select custom footer from Layouts Builder', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'piqes' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => 'footer-custom-elementor-footer-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'piqes' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'piqes' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => piqes_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'piqes' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'piqes' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'piqes' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'piqes' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'piqes' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ! piqes_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'piqes' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'Copyright &copy; {Y} by AncoraThemes. All rights reserved.', 'piqes' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),



				// 'Mobile version'
				//---------------------------------------------
				'mobile'                        => array(
					'title'    => esc_html__( 'Mobile', 'piqes' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 55,
					'type'     => 'section',
				),

				'mobile_header_info'            => array(
					'title' => esc_html__( 'Header on the mobile device', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_mobile'            => array(
					'title'    => esc_html__( 'Header style', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => piqes_get_list_header_footer_types( true ),
					'type'     => PIQES_THEME_FREE || ! piqes_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_mobile'           => array(
					'title'      => esc_html__( 'Select custom layout', 'piqes' ),
					'desc'       => wp_kses_post( __( 'Select custom header from Layouts Builder', 'piqes' ) ),
					'dependency' => array(
						'header_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_mobile'        => array(
					'title'    => esc_html__( 'Header position', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),

				'mobile_sidebar_info'           => array(
					'title' => esc_html__( 'Sidebar on the mobile device', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_mobile'       => array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_mobile'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on mobile devices', 'piqes' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_mobile'         => array(
					'title'   => esc_html__( 'Expand content', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden on mobile devices', 'piqes' ) ),
					'refresh' => false,
					'dependency' => array(
						'sidebar_position_mobile' => array( 'hide', 'inherit' ),
					),
					'std'     => 'inherit',
					'options'  => piqes_get_list_checkbox_values( true ),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),

				'mobile_footer_info'           => array(
					'title' => esc_html__( 'Footer on the mobile device', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'footer_type_mobile'           => array(
					'title'    => esc_html__( 'Footer style', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => piqes_get_list_header_footer_types( true ),
					'type'     => PIQES_THEME_FREE || ! piqes_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'piqes' ),
					'desc'       => wp_kses_post( __( 'Select custom footer from Layouts Builder', 'piqes' ) ),
					'dependency' => array(
						'footer_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets_mobile'        => array(
					'title'      => esc_html__( 'Footer widgets', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'piqes' ) ),
					'dependency' => array(
						'footer_type_mobile' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns_mobile'        => array(
					'title'      => esc_html__( 'Footer columns', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'piqes' ) ),
					'dependency' => array(
						'footer_type_mobile'    => array( 'default' ),
						'footer_widgets_mobile' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => piqes_get_list_range( 0, 6 ),
					'type'       => 'select',
				),



				// 'Blog'
				//---------------------------------------------
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'piqes' ) ),
					'priority' => 70,
					'type'     => 'panel',
				),


				// Blog - Posts page
				//---------------------------------------------
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'piqes' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'piqes' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'piqes' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'piqes' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'piqes' ),
					'options'    => array(),
					'type'       => 'select',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'First post large', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'piqes' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => array(
						'excerpt'  => esc_html__( 'Excerpt', 'piqes' ),
						'fullpost' => esc_html__( 'Full post', 'piqes' ),
					),
					'type'       => 'switch',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'piqes' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'std'        => 22,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'piqes' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'piqes' ) ),
					'std'     => 2,
					'options' => piqes_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'piqes' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'piqes' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'options'    => array(
						'pages'    => esc_html__( 'Page numbers', 'piqes' ),
						'links'    => esc_html__( 'Older/Newest', 'piqes' ),
						'more'     => esc_html__( 'Load more', 'piqes' ),
						'infinite' => esc_html__( 'Infinite scroll', 'piqes' ),
					),
					'type'       => 'select',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Post animation', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'none',
					'options'    => array(),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'select',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style'     => array( 'portfolio', 'gallery' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'open_full_post_in_blog'        => array(
					'title'      => esc_html__( 'Open full post in blog', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Allow to open the full version of the post directly in the blog feed. Attention! Applies only to 1 column layouts!', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'std'        => 0,
					'type'       => 'hidden',
				),

				'blog_header_info'              => array(
					'title' => esc_html__( 'Header', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_blog'              => array(
					'title'    => esc_html__( 'Header style', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => piqes_get_list_header_footer_types( true ),
					'type'     => PIQES_THEME_FREE || ! piqes_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_blog'             => array(
					'title'      => esc_html__( 'Select custom layout', 'piqes' ),
					'desc'       => wp_kses_post( __( 'Select custom header from Layouts Builder', 'piqes' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_blog'          => array(
					'title'    => esc_html__( 'Header position', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight_blog'        => array(
					'title'    => esc_html__( 'Header fullheight', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => piqes_get_list_checkbox_values( true ),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_wide_blog'              => array(
					'title'      => esc_html__( 'Header fullwidth', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'piqes' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => piqes_get_list_checkbox_values( true ),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_blog'         => array(
					'title'   => esc_html__( 'Sidebar position', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'piqes' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'qsetup'     => esc_html__( 'General', 'piqes' ),
					'type'    => 'switch',
				),
				'sidebar_position_ss_blog'  => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'piqes' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'inherit',
                    'hidden' => true,
					'qsetup'   => esc_html__( 'General', 'piqes' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'piqes' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'piqes' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Expand content', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'piqes' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options'  => piqes_get_list_checkbox_values( true ),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_widgets_info'             => array(
					'title' => esc_html__( 'Additional widgets', 'piqes' ),
					'desc'  => '',
					'type'  => PIQES_THEME_FREE ? 'hidden' : 'info',
                    'hidden' => true,
				),
				'widgets_above_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'piqes' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => PIQES_THEME_FREE ? 'hidden' : 'select',
                    'hidden' => true,
				),
				'widgets_above_content_blog'    => array(
					'title'   => esc_html__( 'Widgets above the content', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'piqes' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => PIQES_THEME_FREE ? 'hidden' : 'select',
                    'hidden' => true,
				),
				'widgets_below_content_blog'    => array(
					'title'   => esc_html__( 'Widgets below the content', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'piqes' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => PIQES_THEME_FREE ? 'hidden' : 'select',
                    'hidden' => true,
				),
				'widgets_below_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'piqes' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => PIQES_THEME_FREE ? 'hidden' : 'select',
                    'hidden' => true,
				),

				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'piqes' ),
					'desc'  => wp_kses_data( __( "Select or upload an image used as placeholder for posts without a featured image. Placeholder is used on the blog stream page only (no placeholder in single post), and only in those styles of it where non-using featured image doesn't seem appropriate.", 'piqes' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy Readable Date Format', 'piqes' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'piqes' ) ),
					'std'   => 5,
					'type'  => 'text',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'piqes' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'piqes' ),
						'columns' => esc_html__( 'Mini-cards', 'piqes' ),
					),
					'type'    => PIQES_THEME_FREE ? 'hidden' : 'select',
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'piqes' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'piqes' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|author=1|date=1|comments=1|likes=1|share=1|views=0|edit=0',
					'options'    => piqes_get_list_meta_parts(),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checklist',
				),


				// Blog - Single posts
				//---------------------------------------------
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'piqes' ) ),
					'type'  => 'section',
				),

				'blog_single_header_info'       => array(
					'title' => esc_html__( 'Header', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_single'            => array(
					'title'    => esc_html__( 'Header style', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => piqes_get_list_header_footer_types( true ),
					'type'     => PIQES_THEME_FREE || ! piqes_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_single'           => array(
					'title'      => esc_html__( 'Select custom layout', 'piqes' ),
					'desc'       => wp_kses_post( __( 'Select custom header from Layouts Builder', 'piqes' ) ),
					'dependency' => array(
						'header_type_single' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_single'        => array(
					'title'    => esc_html__( 'Header position', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight_single'      => array(
					'title'    => esc_html__( 'Header fullheight', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'piqes' ) ),
					'std'      => 'inherit',
					'options'  => piqes_get_list_checkbox_values( true ),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_wide_single'            => array(
					'title'      => esc_html__( 'Header fullwidth', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'piqes' ) ),
					'dependency' => array(
						'header_type_single' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => piqes_get_list_checkbox_values( true ),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_single_sidebar_info'      => array(
					'title' => esc_html__( 'Sidebar', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_single'       => array(
					'title'   => esc_html__( 'Sidebar position', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar on the single posts', 'piqes' ) ),
					'std'     => 'right',
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'options' => array(),
					'type'    => 'switch',
				),
				'sidebar_position_ss_single'=> array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the single posts on the small screen - above or below the content', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'below',
                    'hidden' => true,
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_single'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on the single posts', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'piqes' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_single'           => array(
					'title'   => esc_html__( 'Expand content', 'piqes' ),
					'desc'    => wp_kses_data( __( 'Expand the content width on the single posts if the sidebar is hidden', 'piqes' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options'  => piqes_get_list_checkbox_values( true ),
					'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_single_title_info'      => array(
					'title' => esc_html__( 'Featured image and title', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'hide_featured_on_single'       => array(
					'title'    => esc_html__( 'Hide featured image on the single post', 'piqes' ),
					'desc'     => wp_kses_data( __( "Hide featured image on the single post's pages", 'piqes' ) ),
					'override' => array(
						'mode'    => 'page,post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'std'      => 0,
					'type'     => 'checkbox',
				),
				'post_thumbnail_type'      => array(
					'title'      => esc_html__( 'Type of post thumbnail', 'piqes' ),
					'desc'       => wp_kses_data( __( "Select type of post thumbnail on the single post's pages", 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 'is_empty', 0 ),
					),
					'std'        => 'default',
					'options'    => array(
						'fullwidth'   => esc_html__( 'Fullwidth', 'piqes' ),
						'boxed'       => esc_html__( 'Boxed', 'piqes' ),
						'default'     => esc_html__( 'Default', 'piqes' ),
					),
					'type'       => 'hidden',
				),
				'post_header_position'          => array(
					'title'      => esc_html__( 'Post header position', 'piqes' ),
					'desc'       => wp_kses_data( __( "Select post header position on the single post's pages", 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 'is_empty', 0 )
					),
					'std'        => 'under',
					'options'    => array(
						'above'      => esc_html__( 'Above the post thumbnail', 'piqes' ),
						'under'      => esc_html__( 'Under the post thumbnail', 'piqes' ),
						'on_thumb'   => esc_html__( 'On the post thumbnail', 'piqes' ),
						'default'    => esc_html__( 'Default', 'piqes' ),
					),
					'type'       => 'hidden',
				),
				'post_header_align'             => array(
					'title'      => esc_html__( 'Align of the post header', 'piqes' ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'post_header_position' => array( 'on_thumb' ),
					),
					'std'        => 'mc',
					'options'    => array(
						'ts' => esc_html__('Top Stick Out', 'piqes'),
						'tl' => esc_html__('Top Left', 'piqes'),
						'tc' => esc_html__('Top Center', 'piqes'),
						'tr' => esc_html__('Top Right', 'piqes'),
						'ml' => esc_html__('Middle Left', 'piqes'),
						'mc' => esc_html__('Middle Center', 'piqes'),
						'mr' => esc_html__('Middle Right', 'piqes'),
						'bl' => esc_html__('Bottom Left', 'piqes'),
						'bc' => esc_html__('Bottom Center', 'piqes'),
						'br' => esc_html__('Bottom Right', 'piqes'),
						'bs' => esc_html__('Bottom Stick Out', 'piqes'),
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'select',
				),
				'post_subtitle'                 => array(
					'title' => esc_html__( 'Post subtitle', 'piqes' ),
					'desc'  => wp_kses_data( __( "Specify post subtitle to display it under the post title.", 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'piqes' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'piqes' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),
				'meta_parts_single'             => array(
					'title'      => esc_html__( 'Post meta', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'piqes' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'piqes' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|author=1|date=1|comments=1|likes=1|share=1|views=0|edit=0',
					'options'    => piqes_get_list_meta_parts(),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checklist',
				),
				'show_share_links'              => array(
					'title' => esc_html__( 'Show share links', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Display share links on the single post', 'piqes' ) ),
					'std'   => 0,
					'type'  => ! piqes_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'piqes' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'piqes' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),

				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'piqes' ),
					'desc'     => wp_kses_data( __( "Show section 'Related posts' on the single post's pages", 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'std'      => 1,
					'type'     => 'checkbox',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select style of the related posts output', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'classic',
					'options'    => array(
						'modern'  => esc_html__( 'Modern', 'piqes' ),
						'classic' => esc_html__( 'Classic', 'piqes' ),
						'wide'    => esc_html__( 'Wide', 'piqes' ),
						'list'    => esc_html__( 'List', 'piqes' ),
						'short'   => esc_html__( 'Short', 'piqes' ),
					),
					'type'       => 'hidden',
				),
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'inside'        => esc_html__( 'Inside the content (fullwidth)', 'piqes' ),
						'inside_left'   => esc_html__( 'At left side of the content', 'piqes' ),
						'inside_right'  => esc_html__( 'At right side of the content', 'piqes' ),
						'below_content' => esc_html__( 'After the content', 'piqes' ),
						'below_page'    => esc_html__( 'After the content & sidebar', 'piqes' ),
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'select',
				),
				'related_position_inside'       => array(
					'title'      => esc_html__( 'Before # paragraph', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Before what paragraph should related posts appear? If 0 - randomly.', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'inside_left', 'inside_right' ),
					),
					'std'        => 2,
					'options'    => piqes_get_list_range( 0, 9 ),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'select',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'piqes' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'min'        => 1,
					'max'        => 9,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'slider',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'piqes' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts in the single page?', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'below_content', 'below_page' ),
					),
					'std'        => 2,
					'options'    => piqes_get_list_range( 1, 6 ),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider'                => array(
					'title'      => esc_html__( 'Use slider layout', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Use slider layout in case related posts count is more than columns count', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 0,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'related_slider_controls'       => array(
					'title'      => esc_html__( 'Slider controls', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Show arrows in the slider', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'none',
					'options'    => array(
						'none'    => esc_html__('None', 'piqes'),
						'side'    => esc_html__('Side', 'piqes'),
						'outside' => esc_html__('Outside', 'piqes'),
						'top'     => esc_html__('Top', 'piqes'),
						'bottom'  => esc_html__('Bottom', 'piqes')
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'select',
				),
				'related_slider_pagination'       => array(
					'title'      => esc_html__( 'Slider pagination', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Show bullets after the slider', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'bottom',
					'options'    => array(
						'none'    => esc_html__('None', 'piqes'),
						'bottom'  => esc_html__('Bottom', 'piqes')
					),
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider_space'          => array(
					'title'      => esc_html__( 'Space', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Space between slides', 'piqes' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'piqes' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 30,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'text',
				),
				'posts_navigation_info'      => array(
					'title' => esc_html__( 'Posts navigation', 'piqes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'posts_navigation'           => array(
					'title'   => esc_html__( 'Show posts navigation', 'piqes' ),
					'desc'    => wp_kses_data( __( "Show posts navigation on the single post's pages", 'piqes' ) ),
					'std'     => 'links',
					'options' => array(
						'none'   => esc_html__('None', 'piqes'),
						'links'  => esc_html__('Prev/Next links', 'piqes'),
						'scroll' => esc_html__('Infinite scroll', 'piqes')
					),
					'type'    => PIQES_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_fixed'     => array(
					'title'      => esc_html__( 'Fixed posts navigation', 'piqes' ),
					'desc'       => wp_kses_data( __( "Make posts navigation fixed position. Display it when the content of the article is inside the window.", 'piqes' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'links' ),
					),
					'std'        => 0,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_navigation_scroll_hide_author'  => array(
					'title'      => esc_html__( 'Hide author bio', 'piqes' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when infinite scroll is used.", 'piqes' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_navigation_scroll_hide_related'  => array(
					'title'      => esc_html__( 'Hide related posts', 'piqes' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when infinite scroll is used.", 'piqes' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_navigation_scroll_hide_comments' => array(
					'title'      => esc_html__( 'Hide comments', 'piqes' ),
					'desc'       => wp_kses_data( __( "Hide comments after post content when infinite scroll is used.", 'piqes' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 1,
					'type'       => PIQES_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_banners_info'      => array(
					'title' => esc_html__( 'Posts banners', 'piqes' ),
					'desc'  => '',
					'hidden' => true,
					'type'  => 'info',
				),
				'header_banner_link'     => array(
					'title' => esc_html__( 'Header banner link', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'header_banner_img'     => array(
					'title' => esc_html__( 'Header banner image', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'type'       => 'hidden',
				),
				'header_banner_height'  => array(
					'title' => esc_html__( 'Header banner height', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Specify minimal height of the banner (in "px" or "em"). For example: 15em', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'type'       => 'hidden',
				),
				'header_banner_code'     => array(
					'title'      => esc_html__( 'Header banner code', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'hidden',
				),
				'footer_banner_link'     => array(
					'title' => esc_html__( 'Footer banner link', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'footer_banner_img'     => array(
					'title' => esc_html__( 'Footer banner image', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'type'       => 'hidden',
				),
				'footer_banner_height'  => array(
					'title' => esc_html__( 'Footer banner height', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Specify minimal height of the banner (in "px" or "em"). For example: 15em', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'type'       => 'hidden',
				),
				'footer_banner_code'     => array(
					'title'      => esc_html__( 'Footer banner code', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'hidden',
				),
				'sidebar_banner_link'     => array(
					'title' => esc_html__( 'Sidebar banner link', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'sidebar_banner_img'     => array(
					'title' => esc_html__( 'Sidebar banner image', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'type'       => 'hidden',
				),
				'sidebar_banner_code'     => array(
					'title'      => esc_html__( 'Sidebar banner code', 'piqes' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'hidden',
				),
				'background_banner_link'     => array(
					'title' => esc_html__( "Post's background banner link", 'piqes' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'background_banner_img'     => array(
					'title' => esc_html__( "Post's background banner image", 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'type'       => 'hidden',
				),
				'background_banner_code'     => array(
					'title'      => esc_html__( "Post's background banner code", 'piqes' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'piqes' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'piqes' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'hidden',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),



				// 'Colors'
				//---------------------------------------------
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'piqes' ),
					'desc'     => '',
					'priority' => 300,
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'piqes' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'piqes' ) ),
					'hidden' => $hide_schemes,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'piqes' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'piqes' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'piqes' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'piqes' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'menu_scheme'                   => array(
					'title'    => esc_html__( 'Sidemenu Color Scheme', 'piqes' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'piqes' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => 'hidden',
				),
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'piqes' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'piqes' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'piqes' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'piqes' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'piqes' ),
					'desc'  => wp_kses_data( __( 'Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'piqes' ) ),
					'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'piqes' ),
					'desc'        => '',
					'std'         => '$piqes_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'tiny',
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Use huge priority to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'type'  => 'hidden',
				),

			)
		);



		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			//---------------------------------------------
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'piqes' ),
				'desc'     => '',
				'priority' => 200,
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'piqes' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'piqes' ) )
						. '<br>'
						. wp_kses_data( __( 'Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'piqes' ) ),
				'type'  => 'section',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Specify comma separated list of the subsets which will be load from Google fonts', 'piqes' ) )
						. '<br>'
						. wp_kses_data( __( 'Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'piqes' ) ),
				'class'   => 'piqes_column-1_3 piqes_new_row',
				'refresh' => false,
				'std'     => '$piqes_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= piqes_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( piqes_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( __( 'Font %s', 'piqes' ), $i ) ),
					'desc'  => '',
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'piqes' ),
				'desc'    => '',
				'class'   => 'piqes_column-1_3 piqes_new_row',
				'refresh' => false,
				'std'     => '$piqes_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'piqes' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select font family to use it if font above is not available', 'piqes' ) )
							: '',
				'class'   => 'piqes_column-1_3',
				'refresh' => false,
				'std'     => '$piqes_get_load_fonts_option',
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'piqes' ),
					'serif'      => esc_html__( 'serif', 'piqes' ),
					'sans-serif' => esc_html__( 'sans-serif', 'piqes' ),
					'monospace'  => esc_html__( 'monospace', 'piqes' ),
					'cursive'    => esc_html__( 'cursive', 'piqes' ),
					'fantasy'    => esc_html__( 'fantasy', 'piqes' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'piqes' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'piqes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style increase download size! Specify only used weights and styles.', 'piqes' ) )
							: '',
				'class'   => 'piqes_column-1_3',
				'refresh' => false,
				'std'     => '$piqes_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = piqes_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'piqes' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf( __( 'Font settings of the "%s" tag.', 'piqes' ), $tag ) ),
				'type'  => 'section',
			);

			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				// Skip property 'text-decoration' for the main text
				if ( 'text-decoration' == $css_prop && 'p' == $tag ) {
					continue;
				}

				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'piqes' ),
						'100'     => esc_html__( '100 (Light)', 'piqes' ),
						'200'     => esc_html__( '200 (Light)', 'piqes' ),
						'300'     => esc_html__( '300 (Thin)', 'piqes' ),
						'400'     => esc_html__( '400 (Normal)', 'piqes' ),
						'500'     => esc_html__( '500 (Semibold)', 'piqes' ),
						'600'     => esc_html__( '600 (Semibold)', 'piqes' ),
						'700'     => esc_html__( '700 (Bold)', 'piqes' ),
						'800'     => esc_html__( '800 (Black)', 'piqes' ),
						'900'     => esc_html__( '900 (Black)', 'piqes' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'piqes' ),
						'normal'  => esc_html__( 'Normal', 'piqes' ),
						'italic'  => esc_html__( 'Italic', 'piqes' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'piqes' ),
						'none'         => esc_html__( 'None', 'piqes' ),
						'underline'    => esc_html__( 'Underline', 'piqes' ),
						'overline'     => esc_html__( 'Overline', 'piqes' ),
						'line-through' => esc_html__( 'Line-through', 'piqes' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'piqes' ),
						'none'       => esc_html__( 'None', 'piqes' ),
						'uppercase'  => esc_html__( 'Uppercase', 'piqes' ),
						'lowercase'  => esc_html__( 'Lowercase', 'piqes' ),
						'capitalize' => esc_html__( 'Capitalize', 'piqes' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'class'      => 'piqes_column-1_5',
					'refresh'    => false,
					'load_order' => $load_order,
					'std'        => '$piqes_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		piqes_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			piqes_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'piqes' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'piqes' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! piqes_check_url( 'customize.php' ) ) {
			piqes_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'piqes' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'piqes' ) ),
					'class'    => 'piqes_column-1_2 piqes_new_row',
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'piqes' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'piqes_options_get_list_cpt_options' ) ) {
	function piqes_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return array(
			"content_info_{$cpt}"           => array(
				'title' => esc_html__( 'Content', 'piqes' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"body_style_{$cpt}"             => array(
				'title'    => esc_html__( 'Body style', 'piqes' ),
				'desc'     => wp_kses_data( __( 'Select width of the body content', 'piqes' ) ),
				'std'      => 'inherit',
				'options'  => piqes_get_list_body_styles( true ),
				'type'     => 'select',
			),
			"boxed_bg_image_{$cpt}"         => array(
				'title'      => esc_html__( 'Boxed bg image', 'piqes' ),
				'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'piqes' ) ),
				'dependency' => array(
					"body_style_{$cpt}" => array( 'boxed' ),
				),
				'std'        => 'inherit',
				'type'       => 'image',
			),
			"header_info_{$cpt}"            => array(
				'title' => esc_html__( 'Header', 'piqes' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"header_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Header style', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'piqes' ) ),
				'std'     => 'inherit',
				'options' => piqes_get_list_header_footer_types( true ),
				'type'    => PIQES_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'piqes' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select custom layout to display the site header on the %s pages', 'piqes' ), $title ) ),
				'dependency' => array(
					"header_type_{$cpt}" => array( 'custom' ),
				),
				'std'        => 'inherit',
				'options'    => array(),
				'type'       => PIQES_THEME_FREE ? 'hidden' : 'select',
			),
			"header_position_{$cpt}"        => array(
				'title'   => esc_html__( 'Header position', 'piqes' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to display the site header on the %s pages', 'piqes' ), $title ) ),
				'std'     => 'inherit',
				'options' => array(),
				'type'    => PIQES_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_image_override_{$cpt}"  => array(
				'title'   => esc_html__( 'Header image override', 'piqes' ),
				'desc'    => wp_kses_data( __( "Allow override the header image with the post's featured image", 'piqes' ) ),
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'piqes' ),
					1         => esc_html__( 'Yes', 'piqes' ),
					0         => esc_html__( 'No', 'piqes' ),
				),
				'type'    => PIQES_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_widgets_{$cpt}"         => array(
				'title'   => esc_html__( 'Header widgets', 'piqes' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select set of widgets to show in the header on the %s pages', 'piqes' ), $title ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => 'select',
			),

			"sidebar_info_{$cpt}"           => array(
				'title' => esc_html__( 'Sidebar', 'piqes' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"sidebar_position_{$cpt}"       => array(
				'title'   => sprintf( __( 'Sidebar position on the %s list', 'piqes' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the %s list', 'piqes' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_ss_{$cpt}"=> array(
				'title'    => sprintf( __( 'Sidebar position on the %s list on the small screen', 'piqes' ), $title ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'piqes' ) ),
				'std'      => 'below',
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_widgets_{$cpt}"        => array(
				'title'      => sprintf( __( 'Sidebar widgets on the %s list', 'piqes' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select sidebar to show on the %s list', 'piqes' ), $title ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_position_single_{$cpt}"       => array(
				'title'   => sprintf( __( 'Sidebar position on the single post', 'piqes' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the single posts of the %s', 'piqes' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_ss_single_{$cpt}"=> array(
				'title'    => esc_html__( 'Sidebar position on the single post on the small screen', 'piqes' ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'piqes' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'below',
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_widgets_single_{$cpt}"        => array(
				'title'      => sprintf( __( 'Sidebar widgets on the single post', 'piqes' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select widgets to show in the sidebar on the single posts of the %s', 'piqes' ), $title ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"expand_content_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'piqes' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options'  => piqes_get_list_checkbox_values( true ),
				'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
			),
			"expand_content_single_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content on the single post', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Expand the content width on the single post if the sidebar is hidden', 'piqes' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options'  => piqes_get_list_checkbox_values( true ),
				'type'     => PIQES_THEME_FREE ? 'hidden' : 'switch',
			),

			"footer_info_{$cpt}"            => array(
				'title' => esc_html__( 'Footer', 'piqes' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"footer_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Footer style', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'piqes' ) ),
				'std'     => 'inherit',
				'options' => piqes_get_list_header_footer_types( true ),
				'type'    => PIQES_THEME_FREE ? 'hidden' : 'switch',
			),
			"footer_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'piqes' ),
				'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'piqes' ) ),
				'std'        => 'inherit',
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'custom' ),
				),
				'options'    => array(),
				'type'       => PIQES_THEME_FREE ? 'hidden' : 'select',
			),
			"footer_widgets_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer widgets', 'piqes' ),
				'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'piqes' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 'footer_widgets',
				'options'    => array(),
				'type'       => 'select',
			),
			"footer_columns_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer columns', 'piqes' ),
				'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'piqes' ) ),
				'dependency' => array(
					"footer_type_{$cpt}"    => array( 'default' ),
					"footer_widgets_{$cpt}" => array( '^hide' ),
				),
				'std'        => 0,
				'options'    => piqes_get_list_range( 0, 6 ),
				'type'       => 'select',
			),
			"footer_wide_{$cpt}"            => array(
				'title'      => esc_html__( 'Footer fullwidth', 'piqes' ),
				'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'piqes' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 0,
				'type'       => 'checkbox',
			),

			"widgets_info_{$cpt}"           => array(
				'title' => esc_html__( 'Additional panels', 'piqes' ),
				'desc'  => '',
				'type'  => PIQES_THEME_FREE ? 'hidden' : 'info',
                'hidden' => true,
			),
			"widgets_above_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the top of the page', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'piqes' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => 'hidden',
			),
			"widgets_above_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets above the content', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'piqes' ) ),
				'std'     => 'hide',
				'options' => array(),
                'type'    => 'hidden',
			),
			"widgets_below_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets below the content', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'piqes' ) ),
				'std'     => 'hide',
				'options' => array(),
                'type'    => 'hidden',
			),
			"widgets_below_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the bottom of the page', 'piqes' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'piqes' ) ),
				'std'     => 'hide',
				'options' => array(),
                'type'    => 'hidden',
			),
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'piqes_options_get_list_choises' ) ) {
	add_filter( 'piqes_filter_options_get_list_choises', 'piqes_options_get_list_choises', 10, 2 );
	function piqes_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = piqes_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = piqes_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = piqes_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = piqes_get_list_schemes( 'color_scheme' != $id );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = piqes_get_list_sidebars( 'sidebar_widgets_single' != $id && ( strpos( $id, 'sidebar_widgets_' ) === 0 || strpos( $id, 'sidebar_widgets_single_' ) === 0 ), true );
			} elseif ( strpos( $id, 'sidebar_position_ss' ) === 0 ) {
				$list = piqes_get_list_sidebars_positions_ss( strpos( $id, 'sidebar_position_ss_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = piqes_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = piqes_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = piqes_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = piqes_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = piqes_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = piqes_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = piqes_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = piqes_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = piqes_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = piqes_array_merge( array( 0 => esc_html__( '- Select category -', 'piqes' ) ), piqes_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = piqes_get_list_animations_in();
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = piqes_get_list_schemes();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = piqes_get_list_load_fonts( true );
			}
		}
		return $list;
	}
}

if ( ! function_exists( 'piqes_filter_get_list_menu_hover' ) ) {
    add_filter( 'trx_addons_filter_get_list_menu_hover', 'piqes_filter_get_list_menu_hover' );
    function piqes_filter_get_list_menu_hover( $list ) {
        unset( $list['fade_box'] );
        unset( $list['slide_line'] );
        unset( $list['slide_box'] );
        unset( $list['zoom_line'] );
        unset( $list['path_line'] );
        unset( $list['roll_down'] );
        unset( $list['color_line'] );
        return $list;
    }
}

if ( ! function_exists( 'piqes_filter_get_list_input_hover' ) ) {
    add_filter( 'trx_addons_filter_get_list_input_hover', 'piqes_filter_get_list_input_hover' );
    function piqes_filter_get_list_input_hover( $list ) {
        unset( $list['accent'] );
        unset( $list['path'] );
        unset( $list['jump'] );
        unset( $list['underline'] );
        unset( $list['iconed'] );
        return $list;
    }
}