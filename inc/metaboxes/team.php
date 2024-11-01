<?php

/**
 * Metaboxes for the team custom post type
 *
 * @package    	Themeglory_Tool
 * @link        https://themeglory.com/
 * Author:      Themeglory
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */



class Themeglory_Tool_Team {

	public function __construct() {
	

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'themeglorytool_team_metabox'
			,__( 'Team info', 'themeglory-tool' )
			,array( $this, 'render_meta_box_content' )
			,'team'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['tgc_team_nonce'] ) )
			return $post_id;

		$nonce = $_POST['tgc_team_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'tgc_team' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'team' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}


		$designation= isset( $_POST['tgc_team_position'] ) ? sanitize_text_field($_POST['tgc_team_position']) : false;
		$facebook 	= isset( $_POST['tgc_team_facebook'] ) ? esc_url_raw($_POST['tgc_team_facebook']) : false;
		$twitter 	= isset( $_POST['tgc_team_twitter'] ) ? esc_url_raw($_POST['tgc_team_twitter']) : false;
		$google 	= isset( $_POST['tgc_team_google'] ) ? esc_url_raw($_POST['tgc_team_google']) : false;
		$linkedin 	= isset( $_POST['tgc_team_linkedin'] ) ? esc_url_raw($_POST['tgc_team_linkedin']) : false;
		$instagram 	= isset( $_POST['tgc_team_instagram'] ) ? esc_url_raw($_POST['tgc_team_instagram']) : false;
		$link 		= isset( $_POST['tgc_team_url'] ) ? esc_url_raw($_POST['tgc_team_url']) : false;
		$new_tab 	= isset( $_POST['tgc_new_tab'] ) ? sanitize_text_field($_POST['tgc_new_tab']) : false;
		$enable_single  = isset( $_POST['themeglorytool_enable_team_single'] ) ? sanitize_text_field($_POST['themeglorytool_enable_team_single']) : false;
		
		update_post_meta( $post_id, 'tg-team-designation', $designation );
		update_post_meta( $post_id, 'tg-team-facebook', $facebook );
		update_post_meta( $post_id, 'tg-team-twitter', $twitter );
		update_post_meta( $post_id, 'tg-team-google-plus', $google );
		update_post_meta( $post_id, 'tg-team-linkedin', $linkedin );
		update_post_meta( $post_id, 'tg-team-instagram', $instagram );
		update_post_meta( $post_id, 'tg-team-url', $link );
		update_post_meta( $post_id, 'tg-team-new-tab', $new_tab );
		
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'tgc_team', 'tgc_team_nonce' );

		$designation = esc_attr( get_post_meta( $post->ID, 'tg-team-designation', true ) );
		$facebook    = esc_url( get_post_meta( $post->ID, 'tg-team-facebook', true ) );
		$twitter  	 = esc_url( get_post_meta( $post->ID, 'tg-team-twitter', true ) );
		$google   	 = esc_url( get_post_meta( $post->ID, 'tg-team-google-plus', true ) );
		$linkedin 	 = esc_url( get_post_meta( $post->ID, 'tg-team-linkedin', true ) );
		$instagram   = esc_url( get_post_meta( $post->ID, 'tg-team-instagram', true ) );
		$link        = esc_url( get_post_meta( $post->ID, 'tg-team-url', true ) );
		$new_tab     = esc_attr( get_post_meta( $post->ID, 'tg-team-new-tab', true ) );
			
		$pro_theme = Themeglory_Tool::checkPro();

	?>  
		<div class="bellakit input-group">
			<p><strong><label for="tgc_team_position"><?php _e( 'Designation', 'themeglory-tool' ); ?></label></strong></p>
			<p><input type="text" class="widefat" id="tgc_team_position" name="tgc_team_position" value="<?php echo esc_html($designation); ?>"></p>	
		</div>

		<div class="bellakit input-group">
			<p><strong><label><?php _e( 'Social Media', 'themeglory-tool' ); ?></label></strong></p>
			<p><em><?php _e( 'Please leave unnecessary social media link empty', 'themeglory-tool' ); ?></em></p>

			<p><em><?php _e( 'Facebook', 'themeglory-tool' ); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_team_facebook" name="tgc_team_facebook" value="<?php echo$facebook; ?>" <?php echo $pro_theme?'':'disabled';?>></p>				
			
			<p><em><?php _e( 'Twitter', 'themeglory-tool' ); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_team_twitter" name="tgc_team_twitter" value="<?php echo $twitter; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
			
			<p><em><?php _e( 'Google+', 'themeglory-tool' ); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_team_google" name="tgc_team_google" value="<?php echo $google; ?>" <?php echo $pro_theme?'':'disabled';?>></p>

			<p><em><?php _e( 'Linkedin', 'themeglory-tool' ); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_team_linkedin" name="tgc_team_linkedin" value="<?php echo $linkedin; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
			
			<p><em><?php _e( 'Instagram', 'themeglory-tool' ); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_team_instagram" name="tgc_team_instagram" value="<?php echo $instagram; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
		</div>

		<div class="bellakit input-group">
			<p><strong><label for="tgc_team_url"><?php _e( 'URL', 'themeglory-tool' ); ?></label></strong></p>
			<p><em><?php _e('Enter external/internal url', 'themeglory-tool'); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_team_url" name="tgc_team_url" value="<?php echo $link; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
	        <p><input value="1" type="checkbox" name="tgc_new_tab" <?php echo  $new_tab?'checked':'';?> <?php echo $pro_theme?'':'disabled';?>> <?php _e( 'Open new tab', 'themeglory-tool' ); ?></p>
		</div>
	<?php
	}

	
}


function Themeglory_Tool_employees_metabox() {
    new Themeglory_Tool_Team();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'Themeglory_Tool_employees_metabox' );
    add_action( 'load-post-new.php', 'Themeglory_Tool_employees_metabox' );
}