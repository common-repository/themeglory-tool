<?php

/**
 * Metaboxes for page / post / cpt
 *
 * @package    	Themeglory_Tool
 * @link        https://themeglory.com/
 * Author:      Themeglory
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class Themeglory_Tool_cpt_common_metabox {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
        $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);
       
		add_meta_box(
			'themeglorytool_featured_metabox'
			,__( 'Featured Post', 'themeglory-tool' )
			,array( $this, 'render_meta_box_content_featured' )
			,array('page', 'post','services' , 'team' , 'testimonials' , 'events' , 'projects' , 'clients' , 'pricing_tables' )
			,'side'
			,'high'
		);

		 if ( $pageTemplate != 'template-home.php' ){
        	add_meta_box(
				'themeglorytool_sidebar_metabox'
				,__( 'Sidebar', 'themeglory-tool' )
				,array( $this, 'render_meta_box_content_sidebar' )
				,array( 'page' )
				,'side'
				,'high'
			);
        }
			
		
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['tgc_common_nonce'] ) )
			return $post_id;

		$nonce = $_POST['tgc_common_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'tgc_common' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'clients' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$featured 	= isset( $_POST['tgc_is_featured'] ) ? sanitize_text_field($_POST['tgc_is_featured']) : false;
		$sidebar_pos = isset( $_POST['tgc_sidebar_pos'] ) ? sanitize_text_field($_POST['tgc_sidebar_pos']) : false;
		$sidebar_id = isset( $_POST['tgc_sidebar_id'] ) ? sanitize_text_field($_POST['tgc_sidebar_id']) : false;
		update_post_meta( $post_id, 'tg-is-featured', $featured );
		update_post_meta( $post_id, 'tg-sidebar-pos', $sidebar_pos );
		update_post_meta( $post_id, 'tg-sidebar-id', $sidebar_id );

	}

	public function render_meta_box_content_featured( $post ) {
		wp_nonce_field( 'tgc_common', 'tgc_common_nonce' );

		$is_featured = esc_attr( get_post_meta( $post->ID, 'tgis-featured', true ) );
		
		$pro_theme = Themeglory_Tool::checkPro();
	?>
		
		<p><input <?php echo $is_featured?'checked':'';?> type="checkbox" class="widefat" id="tgc_is_featured" 
		name="tgc_is_featured" value="1" <?php echo $pro_theme?'':'disabled';?>> <?php _e('Feature this post', 'themeglory-tool'); ?></p>	

	<?php
	}

	public function render_meta_box_content_sidebar( $post ) {
		wp_nonce_field( 'tgc_common', 'tgc_common_nonce' );
		 global $wp_registered_sidebars; 
		$sidebar_pos = esc_attr( get_post_meta( $post->ID, 'tg-sidebar-pos', true ) );
		$sidebar_id = esc_attr( get_post_meta( $post->ID, 'tg-sidebar-id', true ) );
		$pro_theme = Themeglory_Tool::checkPro();
	?>

		<p><?php _e('Sidebar for this page. It overwrites customizer\'s global sidebar setting.', 'themeglory-tool'); ?></p>	
        <p><input type="radio" name="tgc_sidebar_pos" value="right" <?php echo $pro_theme?'':'disabled';?> <?php echo $sidebar_pos=='right'?'checked':'';?>> <span><?php _e('Right sidebar' , 'themeglory-tool' );?></span></p>
        <p><input type="radio" name="tgc_sidebar_pos" value="left" <?php echo $pro_theme?'':'disabled';?> <?php echo $sidebar_pos=='left'?'checked':'';?>> <span><?php _e('Left sidebar' , 'themeglory-tool' );?></span></p>
        <p><input type="radio" name="tgc_sidebar_pos" value="none" <?php echo $pro_theme?'':'disabled';?> <?php echo $sidebar_pos=='none'?'checked':'';?>> <span><?php _e('No sidebar' , 'themeglory-tool' );?></span></p>

        <p><strong><?php _e('Select Sidebar' , 'themeglory-tool' ); ?></strong></p>
        <p><?php _e('Works when either \'Left\' or \'Right\' sidebar is checked. It overwrites customizer\'s global sidebar setting.' , 'themeglory-tool')?></p>
         	<?php
		    	if( !empty( $wp_registered_sidebars ) && is_array($wp_registered_sidebars) ){
		    		foreach( $wp_registered_sidebars as $sidebar ): 
		    			$checked = $sidebar_id == $sidebar['id']?'checked':'';
		    	 ?>
		    	 	<p><input type="radio" value="<?php echo $sidebar['id'];?>" name="tgc_sidebar_id" <?php echo $checked; ?> <?php echo $pro_theme?'':'disabled';?>> <?php echo $sidebar['name'];?></p>
		    	<?php
		    	 	endforeach;
		    	}
		    	?>
	<?php
	}
}


function Themeglory_Tool_common_metabox() {
    new Themeglory_Tool_cpt_common_metabox();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'Themeglory_Tool_common_metabox' );
    add_action( 'load-post-new.php', 'Themeglory_Tool_common_metabox' );
}
