<?php
/**
 *
 * @link              https://themeglory.com/
 * @since             1.0
 * @package           Themeglory_Tool
 *
 * @wordpress-plugin
 * Plugin Name:       Themeglory Tool
 * Description:       Registers custom post types,taxonomies and meta fields
 * Version:           1.0
 * Author:            Themeglory
 * Author URI:        https://themeglory.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       themeglory-tools
 * Domain Path:       /languages
 */

// Restrict direct access 
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin setup and initialization
 */
class Themeglory_Tool {

	private static $instance;

	/**
	 * Actions setup
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'constants' ), 2 );
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 3 );
		add_action( 'plugins_loaded', array( $this, 'includes' ), 4 );
		add_action( 'admin_notices', array( $this, 'admin_notice' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'backend_enqueue' ), 6 );
		add_action( 'admin_menu' , array( $this, 'tgc_menu' )  , 7 );
	}


	/**
	 * Define plugin constants
	 */
	function constants() {

		define( 'TG_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'TG_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
	}

	/**
	 * Include required files
	 */
	function includes() {

		//Register custom post types
		require_once( TG_DIR . 'inc/post-types.php' );


		// Plugin setting options
		require_once( TG_DIR . 'inc/settings/cpt.php' );
		
		//Metaboxes for respective custom post types
		require_once( TG_DIR . 'inc/metaboxes/common.php' );
		require_once( TG_DIR . 'inc/metaboxes/services.php' );	
		require_once( TG_DIR . 'inc/metaboxes/team.php' );	
		require_once( TG_DIR . 'inc/metaboxes/testimonials.php' );
		require_once( TG_DIR . 'inc/metaboxes/clients.php' );
		require_once( TG_DIR . 'inc/metaboxes/projects.php' );
		require_once( TG_DIR . 'inc/metaboxes/pricing.php' );

	}

	/**
	 * String translations
	 */
	function i18n() {
		load_plugin_textdomain( 'themeglory-tool', false, 'themeglory-tools/languages' );
	}

	/**
	 * Admin notice / error messages
	 */
	function admin_notice() {
		$valid_theme     = self::checkValidTheme();
		$pro_theme = self::checkPro();
		$pro_screen = self::checkProScreen();

		if( ! $valid_theme ){
			  echo '<div class="notice notice-error">';
		      echo 	'<p>' ;
		      echo  __('Please note that <strong> Themeglory Tool </strong> plugin is meant to be used by following themes.', 'themeglory-tool');
		      echo 	 __('<ol><li>Latido</li> <li>Latido Pro</li></ol>', 'themeglory-tool');
		      echo '</p>';
		      echo '</div>';
		}
		if( $pro_screen  && ! $pro_theme ){
			
				 echo '<div class="notice notice-error">';
			     echo 	'<p>' . __('Please note that this screen features are only available on <strong> theme pro </strong> version.</p>', 'themeglory-tool');
			     echo '</div>';
			
		}
	}

	/**
     * loads javscript and css files in admin section.
     */
	function backend_enqueue(){

		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');	
	     
	     wp_register_style( 'themeglory-tools-style', TG_URI.'css/style.css','', 1.0 , 'all' );
	     wp_enqueue_style( 'themeglory-tools-style' );

	     wp_register_script( 'themeglory-tools-script', TG_URI.'js/scripts.js','', 1.0 , 'all' );
	     wp_enqueue_script( 'themeglory-tools-script' );
	 
	     
	    }


	/**
     * Adds menu on wordpress admin panel
     */
	function tgc_menu(){
	
	 	add_submenu_page( 'options-general.php','Themeglory Tool', 'Themeglory Tool' , 'edit_theme_options', 'Themeglory-CPT' , 'tgc_cpt_form_callback');
	 	
	 }

	/**
	 * Returns the instance.
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

	/* 
	 * Checks either active theme is free or pro version of  greenturtlelab theme
	 */
	public static function checkPro(){
		$theme  = wp_get_theme();
		$parent = wp_get_theme()->parent();
		if ( 			
			( $theme == 'Latido Pro' ) ||
			( $parent == 'Latido Pro' ) 
			){
	      return true;
		}
		return false;
	}

	/* 
	 * Checks if the theme is valid
	 */
	public static function checkValidTheme(){
		$theme  = wp_get_theme();
		$parent = wp_get_theme()->parent();
		if (

			  $theme  == 'Latido' || 
			  $theme  == 'Latido Pro' ||
			  $parent == 'Latido' ||
			  $parent == 'Latido Pro'

			){

			 	return true;
			}
	     
		return false;
	}

  	/* 
	 * Checks if current screen features are available in active theme
	 */
	public static function checkProScreen(){
		$screen = get_current_screen(); 
		$post_type = '';
		$taxonomy = '';
		if( isset( $screen->post_type ) ){
		 $post_type = $screen->post_type;
		}

		if( isset( $screen->taxonomy ) ){
		 $taxonomy = $screen->taxonomy;
		}

		if(
			$post_type == 'faqs' || 
			$post_type == 'events' || 
			$post_type == 'clients' || 
			$post_type == 'projects' ||
			$post_type == 'pricing_tables' ||
			$taxonomy == 'service-category' ||
			$taxonomy == 'team-category' ||
			$taxonomy == 'testimonial-category'||
			$taxonomy == 'pricing-category'
			){
			return true;

		}
			return false;
		
		}
	}

	function Themeglory_Tool_plugin_load() {

		return Themeglory_Tool::get_instance();
			
	}
	add_action('plugins_loaded', 'Themeglory_Tool_plugin_load', 1 );