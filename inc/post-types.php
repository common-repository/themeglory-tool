<?php

/**
 * Registers all required custom post type
 *
 * @package    	Themeglory_Tool
 * @link        https://themeglory.com/
 * Author:      Themeglory
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
global $enable_cpt;
$enable_cpt = get_option('tgc_enable_cpt');
// Register the Services custom post type
if( isset( $enable_cpt['services']) ):
function Themeglorytool_register_services(){ 
	global $enable_cpt;
	$labels = array(
		'name'                  => _x( 'Services', 'Post Type General Name', 'themeglory-tool' ),
		'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'themeglory-tool' ),
		'menu_name'             => __( 'Services', 'themeglory-tool' ),
		'name_admin_bar'        => __( 'Services', 'themeglory-tool' ),
		'archives'              => __( 'Item Archives', 'themeglory-tool' ),
		'parent_item_colon'     => __( 'Parent Item:', 'themeglory-tool' ),
		'all_items'             => __( 'All Services', 'themeglory-tool' ),
		'add_new_item'          => __( 'Add New Service', 'themeglory-tool' ),
		'add_new'               => __( 'Add New Service', 'themeglory-tool' ),
		'new_item'              => __( 'New Service', 'themeglory-tool' ),
		'edit_item'             => __( 'Edit Service', 'themeglory-tool' ),
		'update_item'           => __( 'Update Service', 'themeglory-tool' ),
		'view_item'             => __( 'View Service', 'themeglory-tool' ),
		'search_items'          => __( 'Search Service', 'themeglory-tool' ),
		'not_found'             => __( 'Not found', 'themeglory-tool' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'themeglory-tool' ),
		'featured_image'        => __( 'Featured Image', 'themeglory-tool' ),
		'set_featured_image'    => __( 'Set featured image', 'themeglory-tool' ),
		'remove_featured_image' => __( 'Remove featured image', 'themeglory-tool' ),
		'use_featured_image'    => __( 'Use as featured image', 'themeglory-tool' ),
		'insert_into_item'      => __( 'Insert into item', 'themeglory-tool' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'themeglory-tool' ),
		'items_list'            => __( 'Items list', 'themeglory-tool' ),
		'items_list_navigation' => __( 'Items list navigation', 'themeglory-tool' ),
		'filter_items_list'     => __( 'Filter items list', 'themeglory-tool' ),
	);
	$args = array(
		'label'                 => __( 'Service', 'themeglory-tool' ),
		'description'           => __( 'A post type for your services', 'themeglory-tool' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 26,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' 				=> array( 'slug' => 'services' ),		
	);

	if( isset( $enable_cpt['category']['services'] ) ){
		$args['taxonomies'] = array( 'category' );
   }
   

	register_post_type( 'services', $args );

}
 add_action( 'init', 'Themeglorytool_register_services', 0 );
endif;

// Register the Team custom post type
if( isset( $enable_cpt['team']) ):
function Themeglorytool_register_team() {	
	global $enable_cpt;
	$labels = array(
		'name'                  => _x( 'Team', 'Post Type General Name', 'themeglory-tool' ),
		'singular_name'         => _x( 'Team', 'Post Type Singular Name', 'themeglory-tool' ),
		'menu_name'             => __( 'Team', 'themeglory-tool' ),
		'name_admin_bar'        => __( 'Team', 'themeglory-tool' ),
		'archives'              => __( 'Item Archives', 'themeglory-tool' ),
		'parent_item_colon'     => __( 'Parent Item:', 'themeglory-tool' ),
		'all_items'             => __( 'All Team', 'themeglory-tool' ),
		'add_new_item'          => __( 'Add New Team', 'themeglory-tool' ),
		'add_new'               => __( 'Add New Team', 'themeglory-tool' ),
		'new_item'              => __( 'New Team', 'themeglory-tool' ),
		'edit_item'             => __( 'Edit Team', 'themeglory-tool' ),
		'update_item'           => __( 'Update Team', 'themeglory-tool' ),
		'view_item'             => __( 'View Team', 'themeglory-tool' ),
		'search_items'          => __( 'Search Team', 'themeglory-tool' ),
		'not_found'             => __( 'Not found', 'themeglory-tool' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'themeglory-tool' ),
		'featured_image'        => __( 'Featured Image', 'themeglory-tool' ),
		'set_featured_image'    => __( 'Set featured image', 'themeglory-tool' ),
		'remove_featured_image' => __( 'Remove featured image', 'themeglory-tool' ),
		'use_featured_image'    => __( 'Use as featured image', 'themeglory-tool' ),
		'insert_into_item'      => __( 'Insert into item', 'themeglory-tool' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'themeglory-tool' ),
		'items_list'            => __( 'Items list', 'themeglory-tool' ),
		'items_list_navigation' => __( 'Items list navigation', 'themeglory-tool' ),
		'filter_items_list'     => __( 'Filter items list', 'themeglory-tool' ),
	);
	$args = array(
		'label'                 => __( 'Team', 'themeglory-tool' ),
		'description'           => __( 'A post type for your team', 'themeglory-tool' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 26,
		'menu_icon'             => 'dashicons-businessman',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' 				=> array( 'slug' => 'team' ),		
	);
	if( isset( $enable_cpt['category']['team'] ) ){
		$args['taxonomies'] = array( 'category' );
   }
   
	register_post_type( 'team', $args );

}
add_action( 'init', 'Themeglorytool_register_team', 0 );
endif;


// Register the Testimonials custom post type
if( isset( $enable_cpt['testimonials']) ):
function Themeglorytool_register_testimonials() {

    global $enable_cpt;
	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'themeglory-tool' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'themeglory-tool' ),
		'menu_name'             => __( 'Testimonials', 'themeglory-tool' ),
		'name_admin_bar'        => __( 'Testimonials', 'themeglory-tool' ),
		'archives'              => __( 'Item Archives', 'themeglory-tool' ),
		'parent_item_colon'     => __( 'Parent Item:', 'themeglory-tool' ),
		'all_items'             => __( 'All Testimonials', 'themeglory-tool' ),
		'add_new_item'          => __( 'Add New Testimonial', 'themeglory-tool' ),
		'add_new'               => __( 'Add New Testimonial', 'themeglory-tool' ),
		'new_item'              => __( 'New Testimonial', 'themeglory-tool' ),
		'edit_item'             => __( 'Edit Testimonial', 'themeglory-tool' ),
		'update_item'           => __( 'Update Testimonial', 'themeglory-tool' ),
		'view_item'             => __( 'View Testimonial', 'themeglory-tool' ),
		'search_items'          => __( 'Search Testimonial', 'themeglory-tool' ),
		'not_found'             => __( 'Not found', 'themeglory-tool' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'themeglory-tool' ),
		'featured_image'        => __( 'Featured Image', 'themeglory-tool' ),
		'set_featured_image'    => __( 'Set featured image', 'themeglory-tool' ),
		'remove_featured_image' => __( 'Remove featured image', 'themeglory-tool' ),
		'use_featured_image'    => __( 'Use as featured image', 'themeglory-tool' ),
		'insert_into_item'      => __( 'Insert into item', 'themeglory-tool' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'themeglory-tool' ),
		'items_list'            => __( 'Items list', 'themeglory-tool' ),
		'items_list_navigation' => __( 'Items list navigation', 'themeglory-tool' ),
		'filter_items_list'     => __( 'Filter items list', 'themeglory-tool' ),
	);
	$args = array(
		'label'                 => __( 'Testimonial', 'themeglory-tool' ),
		'description'           => __( 'A post type for your testimonials', 'themeglory-tool' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'taxonomies'            => array( 'testimonial-category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 26,
		'menu_icon'             => 'dashicons-heart',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' 				=> array( 'slug' => 'testimonials' ),
	);

	if( isset( $enable_cpt['category']['testimonials'] ) ){
		$args['taxonomies'] = array( 'category' );
   }
   
	register_post_type( 'testimonials', $args );

}
add_action( 'init', 'Themeglorytool_register_testimonials', 0 );
endif;


// Register the Projects custom post type
if( isset( $enable_cpt['projects']) ):
function Themeglorytool_register_projects() {	
	global $enable_cpt;
	$labels = array(
		'name'                  => _x( 'Projects', 'Post Type General Name', 'themeglory-tool' ),
		'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'themeglory-tool' ),
		'menu_name'             => __( 'Projects', 'themeglory-tool' ),
		'name_admin_bar'        => __( 'Projects', 'themeglory-tool' ),
		'archives'              => __( 'Item Archives', 'themeglory-tool' ),
		'parent_item_colon'     => __( 'Parent Item:', 'themeglory-tool' ),
		'all_items'             => __( 'All Projects', 'themeglory-tool' ),
		'add_new_item'          => __( 'Add New Project', 'themeglory-tool' ),
		'add_new'               => __( 'Add New Project', 'themeglory-tool' ),
		'new_item'              => __( 'New Project', 'themeglory-tool' ),
		'edit_item'             => __( 'Edit Project', 'themeglory-tool' ),
		'update_item'           => __( 'Update Project', 'themeglory-tool' ),
		'view_item'             => __( 'View Project', 'themeglory-tool' ),
		'search_items'          => __( 'Search Project', 'themeglory-tool' ),
		'not_found'             => __( 'Not found', 'themeglory-tool' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'themeglory-tool' ),
		'featured_image'        => __( 'Featured Image', 'themeglory-tool' ),
		'set_featured_image'    => __( 'Set featured image', 'themeglory-tool' ),
		'remove_featured_image' => __( 'Remove featured image', 'themeglory-tool' ),
		'use_featured_image'    => __( 'Use as featured image', 'themeglory-tool' ),
		'insert_into_item'      => __( 'Insert into item', 'themeglory-tool' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'themeglory-tool' ),
		'items_list'            => __( 'Items list', 'themeglory-tool' ),
		'items_list_navigation' => __( 'Items list navigation', 'themeglory-tool' ),
		'filter_items_list'     => __( 'Filter items list', 'themeglory-tool' ),
	);
	$args = array(
		'label'                 => __( 'Project/Portfolio', 'themeglory-tool' ),
		'description'           => __( 'A post type for your projects', 'themeglory-tool' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 26,
		'menu_icon'             => 'dashicons-desktop',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' 				=> array( 'slug' => 'projects' ),		
	);

	if( isset( $enable_cpt['category']['projects'] ) ){
		$args['taxonomies'] = array( 'category' );
   }
   

	register_post_type( 'projects', $args );

}
add_action( 'init', 'Themeglorytool_register_projects', 0 );
endif;






// Register the Clients custom post type
if( isset( $enable_cpt['clients']) ):
function Themeglorytool_register_clients() {
	global $enable_cpt;
	$labels = array(
		'name'                  => _x( 'Clients', 'Post Type General Name', 'themeglory-tool' ),
		'singular_name'         => _x( 'Client', 'Post Type Singular Name', 'themeglory-tool' ),
		'menu_name'             => __( 'Clients', 'themeglory-tool' ),
		'name_admin_bar'        => __( 'Clients', 'themeglory-tool' ),
		'archives'              => __( 'Item Archives', 'themeglory-tool' ),
		'parent_item_colon'     => __( 'Parent Item:', 'themeglory-tool' ),
		'all_items'             => __( 'All Clients', 'themeglory-tool' ),
		'add_new_item'          => __( 'Add New Client', 'themeglory-tool' ),
		'add_new'               => __( 'Add New Client', 'themeglory-tool' ),
		'new_item'              => __( 'New Client', 'themeglory-tool' ),
		'edit_item'             => __( 'Edit Client', 'themeglory-tool' ),
		'update_item'           => __( 'Update Client', 'themeglory-tool' ),
		'view_item'             => __( 'View Client', 'themeglory-tool' ),
		'search_items'          => __( 'Search Client', 'themeglory-tool' ),
		'not_found'             => __( 'Not found', 'themeglory-tool' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'themeglory-tool' ),
		'featured_image'        => __( 'Featured Image', 'themeglory-tool' ),
		'set_featured_image'    => __( 'Set featured image', 'themeglory-tool' ),
		'remove_featured_image' => __( 'Remove featured image', 'themeglory-tool' ),
		'use_featured_image'    => __( 'Use as featured image', 'themeglory-tool' ),
		'insert_into_item'      => __( 'Insert into item', 'themeglory-tool' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'themeglory-tool' ),
		'items_list'            => __( 'Items list', 'themeglory-tool' ),
		'items_list_navigation' => __( 'Items list navigation', 'themeglory-tool' ),
		'filter_items_list'     => __( 'Filter items list', 'themeglory-tool' ),
	);
	$args = array(
		'label'                 => __( 'Client', 'themeglory-tool' ),
		'description'           => __( 'A post type for your clients', 'themeglory-tool' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 26,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' 				=> array( 'slug' => 'clients' ),
	);

	if( isset( $enable_cpt['category']['clients'] ) ){
		$args['taxonomies'] = array( 'category' );
   }
   
	register_post_type( 'clients', $args );

}
add_action( 'init', 'Themeglorytool_register_clients', 0 );
endif;




// Register the  Pricing tables post type
if( isset( $enable_cpt['pricing_tables']) ):
function Themeglorytool_register_pricing_tables() {
	global $enable_cpt;
	$labels = array(
		'name'                  => _x( 'Pricing Tables', 'Post Type General Name', 'themeglory-tool' ),
		'singular_name'         => _x( 'Pricing Table', 'Post Type Singular Name', 'themeglory-tool' ),
		'menu_name'             => __( 'Pricing Tables', 'themeglory-tool' ),
		'name_admin_bar'        => __( 'Pricing Tables', 'themeglory-tool' ),
		'archives'              => __( 'Item Archives', 'themeglory-tool' ),
		'parent_item_colon'     => __( 'Parent Item:', 'themeglory-tool' ),
		'all_items'             => __( 'All Pricing Tables', 'themeglory-tool' ),
		'add_new_item'          => __( 'Add New Pricing Table', 'themeglory-tool' ),
		'add_new'               => __( 'Add New Pricing Table', 'themeglory-tool' ),
		'new_item'              => __( 'New Pricing Table', 'themeglory-tool' ),
		'edit_item'             => __( 'Edit Pricing Table', 'themeglory-tool' ),
		'update_item'           => __( 'Update Pricing Table', 'themeglory-tool' ),
		'view_item'             => __( 'View Pricing Table', 'themeglory-tool' ),
		'search_items'          => __( 'Search Pricing Table', 'themeglory-tool' ),
		'not_found'             => __( 'Not found', 'themeglory-tool' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'themeglory-tool' ),
		'featured_image'        => __( 'Featured Image', 'themeglory-tool' ),
		'set_featured_image'    => __( 'Set featured image', 'themeglory-tool' ),
		'remove_featured_image' => __( 'Remove featured image', 'themeglory-tool' ),
		'use_featured_image'    => __( 'Use as featured image', 'themeglory-tool' ),
		'insert_into_item'      => __( 'Insert into item', 'themeglory-tool' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'themeglory-tool' ),
		'items_list'            => __( 'Items list', 'themeglory-tool' ),
		'items_list_navigation' => __( 'Items list navigation', 'themeglory-tool' ),
		'filter_items_list'     => __( 'Filter items list', 'themeglory-tool' ),
	);
	$args = array(
		'label'                 => __( 'Pricing Tables', 'themeglory-tool' ),
		'description'           => __( 'A post type for your Pricing Tables', 'themeglory-tool' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 26,
		'menu_icon'             => 'dashicons-format-chat',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' 				=> array( 'slug' => 'pricing_tables' ),		
	);

	if( isset( $enable_cpt['category']['pricing_tables'] ) ){
		$args['taxonomies'] = array( 'category' );
   }
   
	register_post_type( 'pricing_tables', $args );

}
add_action( 'init', 'Themeglorytool_register_pricing_tables', 0 );
endif;