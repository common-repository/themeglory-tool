<?php

/**
 * Metaboxes for the projects custom post type
 *
 * @package    	Themeglory_Tool
 * @link        https://themeglory.com/
 * Author:      Themeglory
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class Themeglory_Tool_Projects {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'themeglorytool_projects_metabox'
			,__( 'Project info', 'themeglory-tool' )
			,array( $this, 'render_meta_box_content' )
			,'projects'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['tgc_projects_nonce'] ) )
			return $post_id;

		$nonce = $_POST['tgc_projects_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'tgc_projects' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'projects' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$link 	= isset( $_POST['tgc_project_url'] ) ? esc_url_raw($_POST['tgc_project_url']) : false;
		$new_tab 	= isset( $_POST['tgc_new_tab'] ) ? sanitize_text_field($_POST['tgc_new_tab']) : false;
		$detail 	= isset( $_POST['tgc_project_detail'] ) ? sanitize_text_field($_POST['tgc_project_detail']) : false;
		update_post_meta( $post_id, 'tg-project-url', $link );
		update_post_meta( $post_id, 'tg-project-new-tab', $new_tab );
	
		

	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'tgc_projects', 'tgc_projects_nonce' );

		$link 	  = esc_url( get_post_meta( $post->ID, 'tg-project-url', true ) );
		$new_tab  = esc_attr( get_post_meta( $post->ID, 'tg-project-new-tab', true ) );
		$pro_theme = Themeglory_Tool::checkPro(); 

	?>
		<div class="bellakit input-group">
			<p><strong><label><?php _e( 'URL', 'themeglory-tool' ); ?></label></strong></p>
			<p><em><?php _e('Enter external/internal url', 'themeglory-tool'); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_project_url" name="tgc_project_url" value="<?php echo $link; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
	        <p><input value="1" type="checkbox" name="tgc_new_tab" <?php echo  $new_tab?'checked':'';?> <?php echo $pro_theme?'':'disabled';?>> <?php _e( 'Open new tab', 'themeglory-tool' ); ?></p>
		</div>
		

		
	<?php
	}
}

function Themeglory_Tool_projects_metabox() {
    new Themeglory_Tool_Projects();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'Themeglory_Tool_projects_metabox' );
    add_action( 'load-post-new.php', 'Themeglory_Tool_projects_metabox' );
}