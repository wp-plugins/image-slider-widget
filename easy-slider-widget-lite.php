<?php
/*
Plugin Name: Easy Image Slider (Lite)
Plugin URI: http://www.ghozylab.com/plugins/
Description: Easy Image Slider (Lite) - Displaying your image as slider in post/page/widget/sidebar area with very easy.<a href="http://demo.ghozylab.com/plugins/easy-image-slider-plugin/pricing/" target="_blank"><strong> Upgrade to Pro Version Now</strong></a> and get a tons of awesome features.
Author: GhozyLab, Inc.
Version: 1.1.3
Author URI: http://www.ghozylab.com/plugins/
*/

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly!');
}

/*
|--------------------------------------------------------------------------
| Requires Wordpress Version
|--------------------------------------------------------------------------
*/
function ewic_wordpress_version() {
	global $wp_version;
	$plugin = plugin_basename( __FILE__ );

	if ( version_compare( $wp_version, "3.5", "<" ) ) {
		if ( is_plugin_active( $plugin ) ) {
			deactivate_plugins( $plugin );
			wp_die( "This plugin requires WordPress 3.5 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>" );
		}
	}
}
add_action( 'admin_init', 'ewic_wordpress_version' );


/*-------------------------------------------------------------------------------*/
/*   MAIN DEFINES
/*-------------------------------------------------------------------------------*/
if ( !defined( 'EWIC_VERSION' ) ) {
	define( 'EWIC_VERSION', '1.1.3' );
	}

if ( !defined( 'EWIC_NAME' ) ) {
	define( 'EWIC_NAME', 'Easy Image Slider (Lite)' );
	}
	
// Pro Price
if ( !defined( 'EWIC_PRO' ) ) {
	define( 'EWIC_PRO', '20' );
}

// Pro+
if ( !defined( 'EWIC_PROPLUS' ) ) {
	define( 'EWIC_PROPLUS', '33' );
}

// Pro++ Price
if ( !defined( 'EWIC_PROPLUSPLUS' ) ) {
	define( 'EWIC_PROPLUSPLUS', '60' );
}

// Dev Price
if ( !defined( 'EWIC_DEV' ) ) {
	define( 'EWIC_DEV', '99' );
}

// plugin url
if ( ! defined( 'EWIC_URL' ) ) {
	$en_plugin_url = substr(plugin_dir_url(__FILE__), 0, -1);
	define( 'EWIC_URL', $en_plugin_url );
}
	


/*-------------------------------------------------------------------------------*/
/*   Load WP jQuery library
/*-------------------------------------------------------------------------------*/
function ewic_enqueue_scripts() {
	if( !is_admin() )
		{
			wp_enqueue_script( 'jquery' );
			}
}

if ( !is_admin() )
{
  add_action( 'init', 'ewic_enqueue_scripts' );
}


/*-------------------------------------------------------------------------------*/
/*   I18N - LOCALIZATION
/*-------------------------------------------------------------------------------*/
function ewic_lang_init() {
	load_plugin_textdomain( 'easywic', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
add_action( 'init', 'ewic_lang_init' );


/*-------------------------------------------------------------------------------*/
/* Put Admin css file
/*-------------------------------------------------------------------------------*/
function ewic_admin_stylesheet() {
	wp_enqueue_style( 'ewic_admin_styles', plugins_url('inc/css/admin.css' , __FILE__ ) );
	}
add_action( 'admin_print_styles', 'ewic_admin_stylesheet' );	

/*-------------------------------------------------------------------------------*/
/*   Registers custom post type
/*-------------------------------------------------------------------------------*/
function ewic_post_type() {
	$labels = array(
		'name' 				=> _x( 'Easy Slider', 'post type general name' ),
		'singular_name'		=> _x( 'Easy Slider', 'post type singular name' ),
		'add_new' 			=> __( 'Add New Slider', 'easywic' ),
		'add_new_item' 		=> __( 'Easy Slider Item', 'easywic' ),
		'edit_item' 		=> __( 'Edit Slider', 'easywic' ),
		'new_item' 			=> __( 'New Slider', 'easywic' ),
		'view_item' 		=> __( 'View Slider', 'easywic' ),
		'search_items' 		=> __( 'Search Slider', 'easywic' ),
		'not_found' 		=> __( 'No Slider Found', 'easywic' ),
		'not_found_in_trash'=> __( 'No Slider Found In Trash', 'easywic' ),
		'parent_item_colon' => __( 'Parent Slider', 'easywic' ),
		'menu_name'			=> __( 'Easy Slider', 'easywic' )
	);

	$taxonomies = array();
	$supports = array( 'title' );
	
	$post_type_args = array(
		'labels' 			=> $labels,
		'singular_label' 	=> __( 'Easy Slider', 'easywic' ),
		'public' 			=> false,
		'show_ui' 			=> true,
		'publicly_queryable'=> true,
		'query_var'			=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> false,
		'hierarchical' 		=> false,
		'rewrite' 			=> array( 'slug' => 'easyimagesldr', 'with_front' => false ),
		'supports' 			=> $supports,
		'menu_position' 	=> 20,
		'menu_icon' =>  plugins_url( 'inc/images/ewic-cp-icon.png' , __FILE__ ),		
		'taxonomies'		=> $taxonomies
	);

	 register_post_type( 'easyimageslider', $post_type_args );
}
add_action( 'init', 'ewic_post_type' );


/*-------------------------------------------------------------------------------*/
/*  Rename Sub Menu
/*-------------------------------------------------------------------------------*/
function ewic_rename_submenu() {  
    global $submenu;     
	$submenu['edit.php?post_type=easyimageslider'][5][0] = __( 'Overview', 'easywic' );  
}  
add_action( 'admin_menu', 'ewic_rename_submenu' );  


/*-------------------------------------------------------------------------------*/
/*   Executing shortcode inside sidebar/widget
/*-------------------------------------------------------------------------------*/
add_filter( 'widget_text', 'do_shortcode', 11 );


/*-------------------------------------------------------------------------------*/
/*  All Includes
/*-------------------------------------------------------------------------------*/

include_once( 'inc/functions/ewic-functions.php' );
include_once( 'inc/ewic-tinymce.php' );
include_once( 'inc/ewic-metaboxes.php' ); 
include_once( 'inc/ewic-widget.php' ); 
include_once( 'inc/ewic-shortcode.php' ); 

/*-------------------------------------------------------------------------------*/
/*   Featured Plugins Page
/*-------------------------------------------------------------------------------*/
if ( is_admin() ){
	require_once( 'inc/ewic-freeplugins.php' );
	require_once( 'inc/ewic-featured.php' );
	include_once( 'inc/ewic-pricing.php' ); 
	require_once( 'inc/ewic-settings.php' );
	require_once( 'inc/ewic-notice.php' );
	}
	
/*-------------------------------------------------------------------------------*/
/*   Redirect to Pricing Table on Activate
/*-------------------------------------------------------------------------------*/	
function ewic_plugin_activate() {

  add_option( 'activatedewic', 'ewic-activate' );

}
register_activation_hook( __FILE__, 'ewic_plugin_activate' );

function ewic_load_plugin() {

    if ( is_admin() && get_option( 'activatedewic' ) == 'ewic-activate' && !is_network_admin() ) {
		delete_option( 'activatedewic' );
		wp_redirect("edit.php?post_type=easyimageslider&page=ewic_free_plugins");
		
    	}
}
add_action( 'admin_init', 'ewic_load_plugin' );


/*-------------------------------------------------------------------------------*/
/*   Auto Update
/*-------------------------------------------------------------------------------*/	
$ewic_auto_updt = get_option( "ewic-settings-automatic_update" );

switch ( $ewic_auto_updt ) {
	
	case 'active':
		if ( !wp_next_scheduled( "ewic_auto_update" ) ) {
			wp_schedule_event( time(), "daily", "ewic_auto_update" );
			}
		add_action( "ewic_auto_update", "plugin_ewic_auto_update" );
	break;
	
	case 'inactive':
		wp_clear_scheduled_hook( "ewic_auto_update" );
	break;	
	
	case '':
		wp_clear_scheduled_hook( "ewic_auto_update" );
		update_option( "ewic-settings-automatic_update", 'active' );
	break;
					
}

function plugin_ewic_auto_update() {
	try
	{
		require_once( ABSPATH . "wp-admin/includes/class-wp-upgrader.php" );
		require_once( ABSPATH . "wp-admin/includes/misc.php" );
		define( "FS_METHOD", "direct" );
		require_once( ABSPATH . "wp-includes/update.php" );
		require_once( ABSPATH . "wp-admin/includes/file.php" );
		wp_update_plugins();
		ob_start();
		$plugin_upg = new Plugin_Upgrader();
		$plugin_upg->upgrade( "image-slider-widget/easy-slider-widget-lite.php" );
		$output = @ob_get_contents();
		@ob_end_clean();
	}
	catch(Exception $e)
	{
	}
}


?>