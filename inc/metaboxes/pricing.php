<?php

/**
 * Metaboxes for the Pricing tables custom post type
 *
 * @package    	Themeglory_Tool
 * @link        https://themeglory.com/
 * Author:      Themeglory
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class Themeglory_Tool_pricing_tables {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save' ) );
    }

    public function add_meta_box( $post_type ) {
        add_meta_box(
            'tgc_pricing_metabox'
            ,__( 'Pricing Table Info', 'themeglory-tool' )
            ,array( $this, 'render_meta_box_content' )
            ,'pricing_tables'
            ,'advanced'
            ,'high'
        );
    }

    public function save( $post_id ) {
    
        if ( ! isset( $_POST['tgc_pricing_box'] ) ||
        ! wp_verify_nonce( $_POST['tgc_pricing_box'], 'tgc_pricing_box' ) )
            return;
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;
        
        if (!current_user_can('edit_post', $post_id))
            return;
        

        $price    = isset( $_POST['tgc_pricing_price'] ) ? wp_kses_post($_POST['tgc_pricing_price']) : false;
        $duration = isset( $_POST['tgc_pricing_duration'] ) ? wp_kses_post($_POST['tgc_pricing_duration']) : false;
        $label    = isset( $_POST['tgc_pricing_button_label'] ) ? sanitize_text_field($_POST['tgc_pricing_button_label']) : false;
        $link     = isset( $_POST['tgc_pricing_button_link'] ) ? esc_url_raw($_POST['tgc_pricing_button_link']) : false;
        $type     = isset( $_POST['tgc_pricing_button_type'] ) ? sanitize_text_field($_POST['tgc_pricing_button_type']) : false;
        $currency = isset( $_POST['tgc_pricing_currency'] ) ? sanitize_text_field($_POST['tgc_pricing_currency']) : false;


        update_post_meta( $post_id, 'tg-pricing-price', $price );
        update_post_meta( $post_id, 'tg-pricing-duration', $duration );
        update_post_meta( $post_id, 'tg-pricing-button-label', $label );
        update_post_meta( $post_id, 'tg-pricing-button-link', $link );
        update_post_meta( $post_id, 'tg-pricing-button-type', $type );
        update_post_meta( $post_id, 'tg-pricing-currency', $currency );
        
        
        //Repeatable
        $old = get_post_meta($post_id, 'tg-pricing-features', true);
        $new = array();
        
        $names = $_POST['name'];    
        $count = count( $names );
        
        for ( $i = 0; $i < $count; $i++ ) {
            if ( $names[$i] != '' ) :
                $new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );
            endif;
        }

        if ( !empty( $new ) && $new != $old )
            update_post_meta( $post_id, 'tg-pricing-features', $new );
        elseif ( empty($new) && $old )
            delete_post_meta( $post_id, 'tg-pricing-features', $old );
    }

    public function render_meta_box_content( $post ) {
        global $post;

        $repeatable_fields = get_post_meta($post->ID, 'tg-pricing-features', true);

        wp_nonce_field( 'tgc_pricing_box', 'tgc_pricing_box' );

        $price    = get_post_meta( $post->ID, 'tg-pricing-price', true );
        $duration = get_post_meta( $post->ID, 'tg-pricing-duration', true );
        $text     = get_post_meta( $post->ID, 'tg-pricing-button-label', true );
        $link     = get_post_meta( $post->ID, 'tg-pricing-button-link', true );
        $cta_btn  = get_post_meta( $post->ID, 'tg-pricing-button-type', true );
        $currency = get_post_meta( $post->ID, 'tg-pricing-currency', true );
        $pro_theme = Themeglory_Tool::checkPro();

        ?>
        <div class="bellakit input-group">
            
            
            <p><label for="tgc_pricing_price"><?php _e( 'Price', 'themeglory-tool' ); ?></label></p>
            <p><input type="text" class="widefat" id="tgc_pricing_price" name="tgc_pricing_price" value="<?php echo $price; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
            
            <p><label><?php _e('Pricing Currency' , 'themeglory-tool' )?></label></p>
            <p><input type="text" class="widefat" id="tgc_pricing_currency" name="tgc_pricing_currency" value="<?php echo $currency; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
      
            <p><label for="tgc_pricing_duration"><?php _e( 'Price Duration: e.g. /Mo, /Year', 'themeglory-tool' ); ?></label></p>
            <p><input type="text" class="widefat" id="tgc_pricing_duration" name="tgc_pricing_duration" value="<?php echo $duration; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
            

            <p><label for="tgc_pricing_button_label"><?php _e( 'Button label', 'themeglory-tool' ); ?></label></p>            
            <p><input type="text" class="widefat" id="tgc_pricing_button_label" name="tgc_pricing_button_label" value="<?php echo $text; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
            
            <p><label for="tgc_pricing_button_link"><?php _e( 'Button link', 'themeglory-tool' ); ?></label></p>
            <p><input type="text" class="widefat" id="tgc_pricing_button_link" name="tgc_pricing_button_link" value="<?php echo $link; ?>" <?php echo $pro_theme?'':'disabled';?>></p>
       
            <p>

            <label for="tgc_pricing_button_type"><?php esc_html_e( 'Button Type:', 'themeglory-tool' ); ?></label> 

            <select class="widefat"  name="tgc_pricing_button_type" <?php echo $pro_theme?'':'disabled';?>>
                
                <option value="def-btn" <?php echo $cta_btn=='def-btn'?'selected':'';?>><?php esc_html_e( 'Default Button' , 'themeglory-tool' ); ?></option>

                <option value="primary_btn" <?php echo $cta_btn=='primary_btn'?'selected':'';?>><?php esc_html_e( 'Primary Button' , 'themeglory-tool' ); ?></option>

                <option value="secondary_btn" <?php echo $cta_btn=='secondary_btn'?'selected':'';?>><?php esc_html_e( 'Secondary Button' , 'themeglory-tool' ); ?></option>

                <option value="tertiary_btn" <?php echo $cta_btn=='tertiary_btn'?'selected':'';?>><?php esc_html_e( 'Tertiary Button' , 'themeglory-tool' ); ?></option>

                <option value="quaternary_btn" <?php echo $cta_btn=='quaternary_btn'?'selected':'';?>><?php esc_html_e( 'Quaternary Button' , 'themeglory-tool' ); ?></option>

            </select>

        </p>


        </div>
        
    
       
      
        <table id="repeatable-fieldset" width="100%">
        <thead>
            <tr>
                <th width="40%"><strong><?php _e( 'Features' , 'themeglory-tool' )?></strong></th>
            </tr>
        </thead>
        <tbody>
        <?php
        
        if ( $repeatable_fields ) :
        
        foreach ( $repeatable_fields as $field ) {
        ?>
        <tr>
            <td style="width:100%;"><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" <?php echo $pro_theme?'':'disabled';?> /></td>
                    
            <td><a class="button remove-feature" href="#">X</a></td>
        </tr>
        <?php
        }
        else :
        ?>
        <tr>
            <td style="width:100%;"><input type="text" class="widefat" name="name[]" <?php echo $pro_theme?'':'disabled';?>/></td>
                    
            <td><a class="button remove-feature" href="#">X</a></td>
        </tr>
        <?php endif; ?>
        
        <tr class="empty-feature-row screen-reader-text">
            <td><input type="text" class="widefat" name="name[]" /></td>
                                  
            <td><a class="button remove-feature" href="#">X</a></td>
        </tr>
        </tbody>
        </table>
        
        <p><a id="add-feature" class="button button-primary" href="#" <?php echo $pro_theme?'':'disabled';?>>Add More</a></p>
        <?php
    }

}

function Themeglory_Tool_pricing_metabox() {
    new Themeglory_Tool_pricing_tables();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'Themeglory_Tool_pricing_metabox' );
    add_action( 'load-post-new.php', 'Themeglory_Tool_pricing_metabox' );
}