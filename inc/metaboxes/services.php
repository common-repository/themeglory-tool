<?php
/**
 * Metaboxes for the services custom post type
 *
 * @package    	Themeglory_Tool
 * @link        https://themeglory.com/
 * Author:      Themeglory
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


class Themeglory_Tool_Services {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'themeglorytool_services_metabox'
			,__( 'Service info', 'themeglory-tool' )
			,array( $this, 'render_meta_box_content' )
			,'services'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['tgc_services_nonce'] ) )
			return $post_id;

		$nonce = $_POST['tgc_services_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'tgc_services' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'services' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$icon 		= isset( $_POST['tgc_service_icon'] ) ? sanitize_text_field($_POST['tgc_service_icon']) : false;
		$color 		= isset( $_POST['tgc_service_icon_color'] ) ? sanitize_text_field($_POST['tgc_service_icon_color']) : false;
		$thumb 		= isset( $_POST['tgc_thumbnail'] ) ? sanitize_text_field($_POST['tgc_thumbnail']) : false;
		$link 		= isset( $_POST['tgc_service_url'] ) ? esc_url_raw($_POST['tgc_service_url']) : false;
		$new_tab 	= isset( $_POST['tgc_new_tab'] ) ? sanitize_text_field($_POST['tgc_new_tab']) : false;
		$single 	= isset( $_POST['tgc_enable_single'] ) ? sanitize_text_field($_POST['tgc_enable_single']) : false;
		

		update_post_meta( $post_id, 'tg-service-icon', $icon );
		update_post_meta( $post_id, 'tg-service-icon-color', $color );
		update_post_meta( $post_id, 'tg-service-icon-thumbnail', $thumb );	
		update_post_meta( $post_id, 'tg-service-url', $link );
		update_post_meta( $post_id, 'tg-service-new-tab', $new_tab );
		update_post_meta( $post_id, 'tg-enable-service-single', $single );	
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'tgc_services', 'tgc_services_nonce' ) ;
		$icon 		= esc_attr( get_post_meta( $post->ID, 'tg-service-icon', true ) ); 
		$color 		= esc_attr( get_post_meta( $post->ID, 'tg-service-icon-color', true ) ); 
		$thumbnail  = esc_attr( get_post_meta( $post->ID, 'tg-service-icon-thumbnail', true ) );
		$link 	    = esc_url( get_post_meta( $post->ID, 'tg-service-url', true ) );
		$new_tab    = esc_attr( get_post_meta( $post->ID, 'tg-service-new-tab', true ) );
		$pro_theme = Themeglory_Tool::checkPro();
	?>
		
		<div class="bellakit input-group">
			<p><strong><label for="tgc_service_icon"><?php _e( 'Service icon', 'themeglory-tool' ); ?></label></strong></p>
			<p><em><?php echo __('Enter Font Awesome icon class. e.g.: <strong>fa fa-ambulance </strong>. Click <a href="https://fontawesome.com/icons/" target="_blank">here</a> to view full list of icons'); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_service_icon" name="tgc_service_icon" value="<?php echo $icon; ?>" ></p>
			
			<p><em><?php echo __('Icon color'); ?></em></p>
			<p><input type="text" class="color-field" id="tgc_service_icon_color" name="tgc_service_icon_color" value="<?php echo $color; ?>" <?php echo $pro_theme?'':'disabled';?>></p>	

			
		</div>


		<div class="bellakit input-group">
			<p><strong><label><?php _e( 'URL', 'themeglory-tool' ); ?></label></strong></p>
			<p><em><?php _e('Enter external/internal url', 'themeglory-tool'); ?></em></p>
			<p><input type="text" class="widefat" id="tgc_service_url" name="tgc_service_url" value="<?php echo esc_url($link); ?>" <?php echo $pro_theme?'':'disabled';?>></p>
	        <p><input value="1" type="checkbox" name="tgc_new_tab" <?php echo  $new_tab?'checked':'';?> <?php echo $pro_theme?'':'disabled';?>> <?php _e( 'Open new tab', 'themeglory-tool' ); ?></p>
		</div>
		
	<?php
	}
}



function Themeglory_Tool_services_metabox() {
    new Themeglory_Tool_Services();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'Themeglory_Tool_services_metabox' );
    add_action( 'load-post-new.php', 'Themeglory_Tool_services_metabox' );
}