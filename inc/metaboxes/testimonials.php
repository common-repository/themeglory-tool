<?php

/**
 * Metaboxes for the testimonials custom post type
 *
 * @package    	Themeglory_Tool
 * @link        https://themeglory.com/
 * Author:      Themeglory
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


class Themeglory_Tool_Testimonials {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'themeglorytool_testimonials_metabox'
			,__( 'Client info', 'themeglory-tool' )
			,array( $this, 'render_meta_box_content' )
			,'testimonials'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['tgc_testimonials_nonce'] ) )
			return $post_id;

		$nonce = $_POST['tgc_testimonials_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'tgc_testimonials' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'testimonials' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}


		$name 	= isset( $_POST['tgc_client_name'] ) ? sanitize_text_field($_POST['tgc_client_name']) : false;
		$company 	= isset( $_POST['tgc_company_name'] ) ? sanitize_text_field($_POST['tgc_company_name']) : false;
		$designation 	= isset( $_POST['tgc_client_designation'] ) ? sanitize_text_field($_POST['tgc_client_designation']) : false;

		update_post_meta( $post_id, 'tg-name', $name );
		update_post_meta( $post_id, 'tg-company', $company );
		update_post_meta( $post_id, 'tg-designation', $designation );

	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'tgc_testimonials', 'tgc_testimonials_nonce' );

		$name 	 = esc_attr( get_post_meta( $post->ID, 'tg-name', true ) );
		$company = esc_attr( get_post_meta( $post->ID, 'tg-company', true ) );
		$designation = esc_attr( get_post_meta( $post->ID, 'tg-designation', true ) );
		$pro_theme = Themeglory_Tool::checkPro();

	?>
		
		<div class="bellakit input-group">
			<p><strong><label for="tgc_client_name"><?php _e( 'Name', 'themeglory-tool' ); ?></label></strong></p>
			<p><input type="text" class="widefat" id="tgc_client_name" name="tgc_client_name" value="<?php echo $name; ?>" ></p>
			
			<p><strong><label for="tgc_company_name"><?php _e( 'Company name', 'themeglory-tool' ); ?></label></strong></p>
			<p><input type="text" class="widefat" id="tgc_company_name" name="tgc_company_name" value="<?php echo $company; ?>" <?php echo $pro_theme?'':'disabled';?>></p>	
			
			<p><strong><label for="tgc_client_designation"><?php _e( 'Designation', 'themeglory-tool' ); ?></label></strong></p>
			<p><input type="text" class="widefat" id="tgc_client_designation" name="tgc_client_designation" value="<?php echo $designation; ?>" <?php echo $pro_theme?'':'disabled';?>></p>	
		</div>
	<?php
	}
}



function Themeglory_Tool_testimonials_metabox() {
    new Themeglory_Tool_Testimonials();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'Themeglory_Tool_testimonials_metabox' );
    add_action( 'load-post-new.php', 'Themeglory_Tool_testimonials_metabox' );
}
