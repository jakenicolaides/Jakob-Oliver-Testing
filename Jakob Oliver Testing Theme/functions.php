<?php

//enqueing my personal scripts
function jakob_script_enqueue() {
  wp_enqueue_style('customstyle', get_template_directory_uri().'/css/jakob.css', false, '1.0.0', 'all');
  wp_enqueue_script('customjs-jakob', get_template_directory_uri().'/js/jakob.js', array(), '1.0.0', true);
  wp_enqueue_script('customjs-contact', get_template_directory_uri().'/js/contact-form.js', array(), '1.0.0', true);
  wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/releases/v5.0.4/js/all.js', array(), '1.0.0', true);
}

add_action( 'wp_enqueue_scripts', 'jakob_script_enqueue');

//creating menu called header menu

function register_header_menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_header_menu' );

//creating menu called footer menu

function register_footer_menu() {
	register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'register_footer_menu');


// The Bootstrap CSS files for your theme
function theme_styles() {
    wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css', array(), '', 'all');
}

// The Bootstrap JavaScript files for your theme
function theme_js() {
    wp_enqueue_script( 'popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js', array(), '', true );
}

add_action( 'wp_enqueue_scripts', 'theme_styles' );
add_action( 'wp_enqueue_scripts', 'theme_js' );


// Bootstrap navigation
function bootstrap_nav()
{
	wp_nav_menu( array(
            'theme_location'    => 'header-menu',
            'depth'             => 2,
            'container'         => 'false',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
    );
}

// Bootstrap navigation for footer
function bootstrap_nav_footer()
{
	wp_nav_menu( array(
            'theme_location'    => 'footer-menu',
            'depth'             => 2,
            'container'         => 'false',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
    );
}

//including all other theme files
require_once ('class-wp-bootstrap-navwalker.php'); //this is the nav walker page include 4v
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/ajax.php';


//enqueing style sheet message-cpt-style to only run when dealing with cpt 'message'
function jakes_message_enqueue_scripts() {

    global $pagenow, $typenow;
    
    if ( $typenow == 'message') {

        wp_enqueue_style('message-cpt-style', get_template_directory_uri().'/css/message-cpt-style.css', false, '1.0.0', 'all');
        wp_enqueue_script('customjs-jakob', get_template_directory_uri().'/js/message-cpt-script.js', array(), '1.0.0', true);

    }
}    

add_action ('admin_enqueue_scripts', 'jakes_message_enqueue_scripts');
