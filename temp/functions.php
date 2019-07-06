<?php

/*==================================================
=            Starter Theme Introduction            =
==================================================*/

/**
 *
 * About Starter
 * --------------
 * Starter is a project by Calvin Koepke to create a starter theme for Genesis Framework developers that doesn't over-bloat
 * their starting base. It includes commonly used templates, codes, and styles, along with optional SCSS and Gulp tasking.
 *
 * Credits and Licensing
 * --------------
 * Starter was created by Calvin Koepke, and is under GPL 2.0+.
 *
 * Find me on Twitter: @cjkoepke
 *
 */


/*============================================
=            Begin Functions File            =
============================================*/

/**
 *
 * Define Child Theme Constants
 *
 * @since 1.0.0
 *
 */
define( 'CHILD_THEME_NAME', 'vias' );
define( 'CHILD_THEME_AUTHOR', '' );
define( 'CHILD_THEME_AUTHOR_URL', '' );
define( 'CHILD_THEME_URL', '' );
define( 'CHILD_THEME_VERSION', '1.1.0' );
define( 'TEXT_DOMAIN', 'vias' );

/**
 *
 * Start the engine
 *
 * @since 1.0.0
 *
 */
include_once( get_template_directory() . '/lib/init.php');

/**
 *
 * Load files in the /assets/ directory
 *
 * @since 1.0.0
 *
 */
add_action( 'wp_enqueue_scripts', 'startertheme_load_assets' );
function startertheme_load_assets() {

	// Load fonts.
	wp_enqueue_style( 'startertheme-fonts', '//fonts.googleapis.com/css?family=Lato:400,700,700italic', array(), CHILD_THEME_VERSION );

	// Load JS.
	wp_enqueue_script( 'startertheme-global', get_stylesheet_directory_uri() . '/build/js/global.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Load default icons.
	wp_enqueue_style( 'dashicons' );

	// Load responsive menu.
	$suffix = defined( SCRIPT_DEBUG ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'startertheme-responsive-menu', get_stylesheet_directory_uri() . '/build/js/responsive-menus' . $suffix . '.js', array( 'jquery', 'startertheme-global' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'startertheme-responsive-menu',
		'genesis_responsive_menu',
	 	starter_get_responsive_menu_args()
	);

}

/**
 * Set the responsive menu arguments.
 *
 * @return array Array of menu arguments.
 *
 * @since 1.1.0
 */
function starter_get_responsive_menu_args() {

	$args = array(
		'mainMenu'         => __( 'Menu', TEXT_DOMAIN ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Menu', TEXT_DOMAIN ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
				'.nav-secondary',
			),
			'others'  => array(
				'.nav-footer',
				'.nav-sidebar',
			),
		),
	);

	return $args;

}

/**
 *
 * Add theme supports
 *
 * @since 1.0.0
 *
 */
add_theme_support( 'genesis-responsive-viewport' ); /* Enable Viewport Meta Tag for Mobile Devices */
add_theme_support( 'html5',  array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) ); /* HTML5 */
add_theme_support( 'genesis-accessibility', array( 'skip-links', 'search-form', 'drop-down-menu', 'headings' ) ); /* Accessibility */
add_theme_support( 'genesis-after-entry-widget-area' ); /* After Entry Widget Area */
add_theme_support( 'genesis-footer-widgets', 3 ); /* Add Footer Widgets Markup for 3 */


/**
 *
 * Apply custom body classes
 *
 * @since 1.0.0
 * @uses /lib/classes.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/classes.php' );

/**
 *
 * Apply Starter Theme defaults (overrides default Genesis settings)
 *
 * @since 1.0.0
 * @uses /lib/defaults.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/defaults.php' );

/**
 *
 * Apply Starter Theme default attributes
 *
 * @since 1.0.0
 * @uses /lib/attributes.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/attributes.php' );


//----------------------------------------------------------------------

// Admin css
add_action('admin_enqueue_scripts', 'admin_styles');
function admin_styles() {
    wp_enqueue_style('backend-admin', get_stylesheet_directory_uri() . '/admin.css');
}

// Move the primary menu to ther header 
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 10);

// Add new image sizes
add_image_size( 'square-image', 650, 650, true ); // width, height, crop
add_image_size( 'deep-banner', 1276, 850, true ); // width, height, crop
add_image_size( 'shallow-banner', 1276, 745, true ); // width, height, crop

// Enable font sizes in WYSIWYG
function scanwp_buttons( $buttons ) {
    array_unshift( $buttons, 'fontsizeselect' ); 
    return $buttons;
  }
add_filter( 'mce_buttons_2', 'scanwp_buttons' );


// --------------------------------- Add icon to header -------------
add_action('genesis_header', 'header_9', 9 );
function header_9(){

		echo '<a class="site-header__headphones" href="https://www.browsealoud.com" target="_blank" title="Download Browsealoud. Link opens in new tab or window.">Download Browsealoud.</a>';

}

//* ------------------------------ Output Homepage ---------------------

add_action('genesis_entry_content', 'homepage_10', 10 );
function homepage_10(){
	if ( is_page_template('page-home.php') ) {
		/*
		echo '<div class="row row--home-intro"><style> .row__home-inner {background-image: url("' . types_render_field( 'home-main-header-image', array('url' => 'true') ) . '")}</style><div class="row__home-inner">';
			echo '<div class="row--home-intro__cta-1"><p><a href="#contact-us">' . types_render_field('home-mission-statement', array() ) . '</a></p></div></div>';

		echo '</div>';

		*/
		echo '<div class="row row--2 row--home-intro hint-red">' . types_render_field( 'home-main-header-image', array('size' => 'deep-image') ) . '<a class="row--home-intro__cta-1" href="#contact-us">' . types_render_field('home-mission-statement', array() ) . '<span class="row--home-intro__cta-1__icon"></span></a></div>';
	}
}

add_action('genesis_entry_content', 'homepage_11', 11 );
function homepage_11(){
	if ( is_page_template('page-home.php') ) {
		echo '<div class="row row--pt0 brand-1"><div class="wrap"><div id="home-intro-txt" class="block block--1 block--plr5 txt-3 hint-red">' . types_render_field('home-intro-text', array() ) . '</div></div></div>';
	}
}

add_action('genesis_entry_content', 'homepage_12', 12 );
function homepage_12(){
	if ( is_page_template('page-home.php') ) {
		echo '<div class="row row--bg-13"><div class="wrap hint-red">' . do_shortcode('[wpv-view name="home-square-blocks"]') . '</div></div>';
	}
}

add_action('genesis_entry_content', 'homepage_13', 13 );
function homepage_13(){
	if ( is_page_template('page-home.php') ) {
		echo '<div class="row row--bg-1 row--ptb2"><div class="wrap-5"><div class="block block-project hint-blue">';
			echo '<h2 class="block-project__header">' . types_render_field('home-projects-header', array() ) . '</h2>';
			echo '<p>' . types_render_field('home-projects-text', array() ) . '</p>';
			echo '<p class="tar"><a class="more-cta" href="' . types_render_field('home-projects-link', array('output' => 'raw') ) . '">Find out more</a></p>';

		echo '</div></div></div>';
	}
}

add_action('genesis_entry_content', 'homepage_14', 14 );
function homepage_14(){
	if ( is_page_template('page-home.php') ) {

		/*
		echo '<div class="row row--home-bottom"><style> .row--home-bottom {background-image: url("' . types_render_field( 'home-bottom-image', array('url' => 'true') ) . '")}</style>';
			echo '<div><p><a href="'. types_render_field('home-links-to-bottom', array('output' => 'raw') )  . '">' . types_render_field('home-text-bott-image', array() ) . '</a></p></div>';

		echo '</div>';

		*/
	echo '<div class="row row--2"><div class="block-case-studies hint-lime">' . types_render_field( 'home-bottom-image', array('size' => 'shallow-banner') ) . '<p class="block-case-studies__p"><a class="block-case-studies__cta" href="'. types_render_field('home-links-to-bottom', array('output' => 'raw') )  . '">' . types_render_field('home-text-bott-image', array() ) . '<span class="block-case-studies__cta__icon"></span></a></p></div></div>';
	}
}

add_action('genesis_entry_content', 'homepage_15', 15 );
function homepage_15(){
	if ( is_page_template('page-home.php') ) {
		echo '<div class="row row--bg-13 row--p8m8" id="contact-us"><div class="wrap txt-4 tac hint-yellow">'. types_render_field('home-bottom-text', array() )  . '</div></div>';
	}
}

//* ------------------------------ Output Consultancy---------------------

// Header image
add_action('genesis_entry_content', 'consultancy_10', 10 );
function consultancy_10(){
	if ( is_page_template('page-consultancy.php') ) {
		echo '<div class="row row--2 row--training-intro hint-red">' . types_render_field( 'training-header-image', array('size' => 'shallow-banner') ) . '</div>';
	}
}

// Row 1
add_action('genesis_entry_content', 'consultancy_11', 11 );
function consultancy_11(){
	if ( is_page_template('page-consultancy.php') ) {
		echo '<div class="row row--2 row--bg-5"><div class="wrap"><div class="block block--1 hint-red"><div class="wrap-4">' . types_render_field('training-intro-text', array() ) . '<div class="cta-internal"><a href="#contact-us" class="cta-internal__lnk">Get in touch</a></div></div></div></div></div>';
	}
}

// Row 2 
add_action('genesis_entry_content', 'consultancy_12', 12 );
function consultancy_12(){
	if ( is_page_template('page-consultancy.php') ) {
		echo '<div class="row row--bg-4 row--c-1"><div class="wrap"><div class="block block--2 hint-blue"><h2>' . types_render_field('c-t-qc-2nd-header', array() ) . '</h2>' . types_render_field('c-t-qc-2nd-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf', array("output" => "raw") ) . '" target="_blank" class="more-cta more-cta--white">Download PDF to find out more</a></p></div></div></div>';
	}
}

// Row 3
add_action('genesis_entry_content', 'consultancy_13', 13 );
function consultancy_13(){
	if ( is_page_template('page-consultancy.php') ) {
		echo '<div class="row row--bg-3 row--bg-13"><div class="wrap"><div class="block block--halves"><div class="wrap-3 hint-lime"><h2>' . types_render_field('c-t-qc-3rd-header', array() ) . '</h2>' . types_render_field('copyc-t-qc-3rd-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf-third', array("output" => "raw") ) . '" target="_blank" class="more-cta">Download PDF find out more</a></p></div></div></div></div>';
	}
}

// Row 4
add_action('genesis_entry_content', 'consultancy_14', 14 );
function consultancy_14(){
	if ( is_page_template('page-consultancy.php') ) {
		echo '<div class="row row--bg-5"><div class="wrap"><div class="block block--2 hint-yellow"><h2>' . types_render_field('c-t-qc-4th-header', array() ) . '</h2>' . types_render_field('c-t-qt-fourth2-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf-fourth', array("output" => "raw") ) . '" target="_blank" class="more-cta">Download PDF to find out more</a></p></div></div></div>';
	}
}

// Row 5
add_action('genesis_entry_content', 'consultancy_15', 15 );
function consultancy_15(){
	if ( is_page_template('page-consultancy.php') ) {
		echo '<div id="contact-us" class="row row--1 row--bg-6 row--ptb3"><div class="wrap"><div class="block block--3 block--5 tac txt-4 txt-4--1 hint-fuchsia">' . types_render_field('c-t-qc-5th-copy2', array() ) . '</div></div></div>';
	}
}

//* ------------------------------ Output Training---------------------

// Header image
add_action('genesis_entry_content', 'training_10', 10 );
function training_10(){
	if ( is_page_template('page-training.php') ) {
		echo '<div class="row row--2 row--training-intro hint-red">' . types_render_field( 'training-header-image', array('size' => 'shallow-banner') ) . '</div>';
	}
}

// Row 1
add_action('genesis_entry_content', 'training_11', 11 );
function training_11(){
	if ( is_page_template('page-training.php') ) {
		echo '<div class="row row--2 row--bg-5"><div class="wrap"><div class="block block--1 hint-red"><div class="wrap-4">' . types_render_field('training-intro-text', array() ) . '<div class="cta-internal"><a href="#contact-us" class="cta-internal__lnk cta-internal__lnk--training">Get in touch</a></div></div></div></div></div>';
	}
}

// Row 2 
add_action('genesis_entry_content', 'training_12', 12 );
function training_12(){
	if ( is_page_template('page-training.php') ) {
		echo '<div class="row row--bg-8 row--c-1"><div class="wrap"><div class="block block--2 hint-blue"><h2>' . types_render_field('c-t-qc-2nd-header', array() ) . '</h2>' . types_render_field('c-t-qc-2nd-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf', array("output" => "raw") ) . '" target="_blank" class="more-cta more-cta--white">Download PDF to find out more</a></p></div></div></div>';
	}
}

// Row 3
add_action('genesis_entry_content', 'training_13', 13 );
function training_13(){
	if ( is_page_template('page-training.php') ) {
		echo '<div class="row row--bg-13 row--bg-3"><div class="wrap"><div class="block block--halves"><div class="wrap-3 hint-lime"><h2>' . types_render_field('c-t-qc-3rd-header', array() ) . '</h2>' . types_render_field('copyc-t-qc-3rd-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf-third', array("output" => "raw") ) . '" target="_blank" class="more-cta">Download PDF find out more</a></p></div></div></div></div>';
	}
}

// Row 4
add_action('genesis_entry_content', 'training_14', 14 );
function training_14(){
	if ( is_page_template('page-training.php') ) {
		echo '<div class="row row--bg-5"><div class="wrap"><div class="block block--2 hint-yellow"><h2>' . types_render_field('c-t-qc-4th-header', array() ) . '</h2>' . types_render_field('c-t-qt-fourth2-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf-fourth', array("output" => "raw") ) . '" target="_blank" class="more-cta">Download PDF to find out more</a></p></div></div></div>';
	}
}

// Row 5
add_action('genesis_entry_content', 'training_15', 15 );
function training_15(){
	if ( is_page_template('page-training.php') ) {
		echo '<div class="row row--bg-13 row--ptb2"><div class="wrap"><div class="block block--2 hint-fuchsia"><h2>' . types_render_field('c-t-qc-5th-header', array() ) . '</h2>' . types_render_field('c-t-qc-5th-copy2', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf-5th', array("output" => "raw") ) . '" target="_blank" class="more-cta">Download PDF to find out more</a></p></div></div></div>';
	}
}

// Row 6
add_action('genesis_entry_content', 'training_16', 16 );
function training_16(){
	if ( is_page_template('page-training.php') ) {
		echo '<div id="contact-us" class="row row--1 row--bg-6 row--ptb3"><div class="wrap"><div class="block block--3 block--5 tac txt-4 txt-4--1 hint-aqua">' . types_render_field('t-qc-6th-copy2', array() ) . '</div></div></div>';
	}
}

//* ------------------------------ Output Quality Checking---------------------

// Header image
add_action('genesis_entry_content', 'quality_checking_10', 10 );
function quality_checking_10(){
	if ( is_page_template('page-quality-checking.php') ) {
		echo '<div class="row row--2 row--training-intro hint-red">' . types_render_field( 'training-header-image', array('size' => 'shallow-banner') ) . '</div>';
	}
}

// Row 1
add_action('genesis_entry_content', 'quality_checking_11', 11 );
function quality_checking_11(){
	if ( is_page_template('page-quality-checking.php') ) {
		echo '<div class="row row--2 row--bg-5"><div class="wrap"><div class="block block--1 hint-red"><div class="wrap-4">' . types_render_field('training-intro-text', array() ) . '<div class="cta-internal"><a href="#contact-us" class="cta-internal__lnk cta-internal__lnk--quality">Get in touch</a></div></div></div></div></div>';
	}
}

// Row 2 
add_action('genesis_entry_content', 'quality_checking_12', 12 );
function quality_checking_12(){
	if ( is_page_template('page-quality-checking.php') ) {
		echo '<div class="row row--bg-9"><div class="wrap hint-blue"><div class="block block--2"><h2>' . types_render_field('c-t-qc-2nd-header', array() ) . '</h2>' . types_render_field('c-t-qc-2nd-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf', array("output" => "raw") ) . '" target="_blank" class="more-cta">Download PDF to find out more</a></p></div></div></div>';
	}
}

// Row 3
add_action('genesis_entry_content', 'quality_checking_13', 13 );
function quality_checking_13(){
	if ( is_page_template('page-quality-checking.php') ) {
		echo '<div class="row row--bg-3 row--bg-13"><div class="wrap"><div class="block block--halves"><div class="wrap-3  hint-lime"><h2>' . types_render_field('c-t-qc-3rd-header', array() ) . '</h2>' . types_render_field('copyc-t-qc-3rd-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf-third', array("output" => "raw") ) . '" target="_blank" class="more-cta">Download PDF find out more</a></p></div></div></div></div>';
	}
}

// Row 4
add_action('genesis_entry_content', 'quality_checking_14', 14 );
function quality_checking_14(){
	if ( is_page_template('page-quality-checking.php') ) {
		echo '<div class="row row--bg-5 row--ptb2"><div class="wrap hint-yellow"><div class="block block--2"><h2>' . types_render_field('c-t-qc-4th-header', array() ) . '</h2>' . types_render_field('c-t-qt-fourth2-copy', array() ) . '<p class="block__download"><a href="' . types_render_field('link-to-pdf-fourth', array("output" => "raw") ) . '" target="_blank" class="more-cta">Download PDF to find out more</a></p></div></div></div>';
	}
}

// Row 5
add_action('genesis_entry_content', 'quality_checking_15', 15 );
function quality_checking_15(){
	if ( is_page_template('page-quality-checking.php') ) {
		echo '<div id="contact-us" class="row row--1 row--bg-6 row--ptb3"><div class="wrap hint-fuchsia"><div"><div class="block block--5 tac txt-4 txt-4--1">' . types_render_field('c-t-qc-5th-copy2', array() ) . '</div></div></div>';
	}
}

//----------------------- Output Case Studies ---------------------------------------
// Header image
add_action('genesis_entry_content', 'case_studies_10', 10 );
function case_studies_10(){
	if ( is_page_template('page-case-studies.php') ) {
		echo '<div class="row row--2 row--training-intro hint-red">' . types_render_field( 'case-studies-image', array('size' => 'shallow-banner') ) . '</div>';
	}
}

add_action('genesis_entry_content', 'case_studies_11', 11 );
function case_studies_11(){
	if ( is_page_template('page-case-studies.php') ) {
		echo '<div class="row row--projects row--2 row--bg-5"><div class="wrap"><div class="block block--1 hint-blue"><div class="wrap-4"><h2>' . types_render_field('cases-header-row-1', array() ) . '</h2>' . types_render_field('cases-copy-row-1', array() ) . '</div></div></div></div>';
	}
}

// Row 2 
add_action('genesis_entry_content', 'case_studies_12', 12 );
function case_studies_12(){
	if ( is_page_template('page-case-studies.php') ) {
		echo '<div class="row row--bg-12 row--c-1"><div class="wrap"><div class="block block--2 hint-lime"><h2>' . types_render_field('cases-header-row-2', array() ) . '</h2>' . types_render_field('cases-copy-row-2', array() ) . '</div></div></div>';
	}
}

// Row 3
add_action('genesis_entry_content', 'case_studies_13', 13 );
function case_studies_13(){
	if ( is_page_template('page-case-studies.php') ) {
		echo '<div class="row row--2 row--bg-13"><div class="wrap dflex hint-yellow">
				<div class="block block--halves block--6 txt-6" style="padding: 15% 5%;">
					<div class="">' . types_render_field('cases-copy-row-3', array() ) . '</div>
				</div>
				<div class="block block--halves block--img-1">
					<style>.block--img-1 {background-image: url("' . types_render_field( 'cases-img-row-3', array('url' => 'true') ) . '")}</style>
				</div>
			  </div></div>';
	}
}

// Row 4 
add_action('genesis_entry_content', 'case_studies_14', 14 );
function case_studies_14(){
	if ( is_page_template('page-case-studies.php') ) {
		echo '<div class="row row--bg-5"><div class="wrap"><div class="block block--2 block--7 hint-fuchsia"><h2>' . types_render_field('cases-header-row-4', array() ) . '</h2>' . types_render_field('cases-copy-row-4', array() ) . '</div></div></div>';
	}
}

// Row 5 
add_action('genesis_entry_content', 'case_studies_15', 15 );
function case_studies_15(){
	if ( is_page_template('page-case-studies.php') ) {
		echo '<div class="row row--bg-13 row--ptb2"><div class="wrap"><div class="block block--2 tac txt-2"><p>“Working has given him a great sense
of pride and has increased his self-confidence.”</p></div></div></div>';
	}
}

// Row 6
add_action('genesis_entry_content', 'case_studies_16', 16 );
function case_studies_16(){
	if ( is_page_template('page-case-studies.php') ) {
		//echo '<div class="row row--1 row--bg-5"><div class="wrap"><div class="block block--3 block--5 tac">Whatever your story, we’d love to chat. Call us on 0141 212 3395</div></div></div>';

		echo '<div class="row row--1 row--ptb2"><div class="wrap"><div class="block block--3 block--5 tac txt-4 hint-aqua">' . types_render_field('case-study-bottom-copy', array() ) . '</div></div></div>';
	}
}

//----------------------- Output Projects ---------------------------------------

add_action('genesis_entry_content', 'projects_10', 10 );
function projects_10(){
	if ( is_page_template('page-projects.php') ) {
		echo '<div class="row row--2 row--training-intro hint-red">' . types_render_field( 'projects-image', array('size' => 'shallow-banner') ) . '</div>';
	}
}

add_action('genesis_entry_content', 'projects_11', 11 );
function projects_11(){
	if ( is_page_template('page-projects.php') ) {
		echo '<div class="hint-blue"' . do_shortcode('[wpv-view name="projects"]') . '</div>';
	}
}

add_action('genesis_entry_content', 'projects_12', 12 );
function projects_12(){
	if ( is_page_template('page-projects.php') ) {
		echo '<div class="row row--1 row--ptb2"><div class="wrap"><div class="block block--3 block--5 tac txt-4 hint-lime">' . types_render_field( 'projects-bottom-copy', array() ) . '</div></div></div>';
	}
}

// -------------------------Output Contact page ------------------------------

add_action('genesis_entry_content', 'contact_10', 10 );
function contact_10(){
	if ( is_page_template('page-contact.php') ) {
		echo '<div class="row brand-2"><div class="wrap"><div class="block block--1 hint-red" style="margin-top: 12rem;"><div class="wrap-4 txt-5">' . types_render_field( 'contact-copy', array() ) . '<div class="txt-3" style="text-align:center;"><p>' . types_render_field('footer-email-address', array("id" => "5") ) . '</p>' . types_render_field('postal-address', array("id" => "5") ) . '</div></div></div></div></div>';
	}
}

// Row 2 
add_action('genesis_entry_content', 'contact_11', 11 );
function contact_11(){
	if ( is_page_template('page-contact.php') ) {
		echo '<div class="row row--bg-11"><div class="wrap"><div class="block block--2"><h2>Contact</h2>' . do_shortcode('[contact-form-7 id="85" title="Contact form 1"]') . '</div></div></div>';
	}
}

// Row 3
add_action('genesis_entry_content', 'contact_12', 12 );
function contact_12(){
	if ( is_page_template('page-contact.php') ) {
		echo '<div class="row row--1 row--bg-13 row--ptb2-2"><div class="wrap"><div class="block block--3 block--5 tac txt-4 hint-blue">' . types_render_field('contact-bottom-copy', array() ) . '</div></div></div>';
	}
}

// -------------------------Output Generic page ------------------------------

add_action('genesis_entry_content', 'generic_10', 10 );
function generic_10(){
	if ( is_page_template('page-generic.php') ) {
		echo '<div class="row row--plr"><div class="wrap">' . types_render_field( 'generic-copy', array() ) . '</div></div>';
	}
}


// ------------------------- Details footer ----------------------------------
// 
add_action('genesis_before_footer', 'footer_details' );
function footer_details(){
	
	if ( is_page_template('page-projects.php') ) {

		echo '<div class="row row--bg-10 row--mt2 row--p1">';

	} else if ( is_page_template('page-home.php') ) {

		echo '<div class="row row--bg-7 row--p1">';

	} else {
		
		echo '<div class="row row--bg-7 row--mt2 row--p1">';
	}

	echo '<div class="wrap dflex dflex--space-between contact-block hint-orange"><div class="block block--4 txt-1 contact-block__1">' . types_render_field('footer-left', array("id" => "5") ) . types_render_field('postal-address', array("id" => "5") ) . '<a class="block__social-media-cta block__social-media-cta--fb" href="' . types_render_field('facebook-page-address', array("id" => "5", "output" => "raw") ) . '" title="Visit us on Facebook (Link opens in a new tab or window)" target="_blank">Facebook</a><a class="block__social-media-cta block__social-media-cta--twitter" href="' . types_render_field('twitter-account-address', array("id" => "5", "output" => "raw") ) . '" title="Visit us on Twitter (Link opens in a new tab or window)" target="_blank">Twitter</a></div><div class="block block--4 txt-2 contact-block__2"><p>' . types_render_field('footer-phone-number', array("id" => "5") ) . '</p><p>' . types_render_field('footer-email-address', array("id" => "5") ) . '</p></div></div></div>';

}

//------------------------- Change the footer copyright etc text--------------

add_filter( 'genesis_footer_creds_text', 'wpb_footer_creds_text' );
function wpb_footer_creds_text () {
	$copyright = '';
    return $copyright;
}


add_filter('genesis_footer', 'designed_by', 10);
function designed_by() {
	echo '<p class="designed-by">Designed by <a href="https://orbit.scot" target="_blank">Orbit Communications</a>.</p><p class="copyright-privacy">All site content Copyright VIA Scotland '  . do_shortcode('[footer_copyright]') . ' <span>|</span> <a href="' . home_url() . '/privacy-policy">Privacy Policy</a></p>';
}

// Output back to top cta
add_action('genesis_footer', 'back_to_top', 13 );
function back_to_top() {
	echo '<a id="back-to-top" class="back-to-top" href="#" title="Back to top">Back to top</a>';
}
