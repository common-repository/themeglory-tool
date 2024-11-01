<?php
/**
 * Enables/Disables custom post type and respective custom taxonomy
 *
 * @package    	Themeglory_Tool
 * @link        https://themeglory.com/
 * Author:      Themeglory
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

function tgc_cpt_settings(){

/* CPT Setting Section */
add_settings_section( 
    'tgc_cpt',
    __('Custom Post Type Setting' , 'themeglory-tool'),
    'tgc_cpt_setting_callback',
    'tgc_enable_cpt'
);

/* CPT settings fields */
add_settings_field(  
    'tgc_enable_cpt',                      
    __('Enable Custom post types' , 'themeglory-tool'),               
    'tgc_enable_cpts_callback',   
    'tgc_enable_cpt',                     
    'tgc_cpt',
   array('services' =>'service-category','team'=>'team-category','testimonials'=>'testimonial-category','projects'=>'project-category','clients'=>'client-category', 'pricing_tables' => 'pricing_table-category')
);

register_setting('tgc_enable_cpt', 'tgc_enable_cpt');

}

function tgc_cpt_setting_callback() { 
   
  echo __('<p> Please enable  <strong>Custom Post Types</strong> according to your requirement. </p>' , 'themeglory-tool');
    
}

function tgc_enable_cpts_callback( $args ){
	$options = get_option('tgc_enable_cpt');
		
	foreach( $args as $cpt=>$tax):
    $cpt_checked = '';
    $cat_checked = '';
    $tax_checked = '';
    $arch_checked = '';
    $style = 'style="display:none;"';
	if( isset( $options[$cpt])){
		$cpt_checked = 'checked';
        $style = '';

	}
    if( isset( $options['category'][$cpt])){
        $cat_checked = 'checked';
    }
    if( isset( $options['taxonomy'][$cpt])){
        $tax_checked = 'checked';
    }

    echo '<div class="bellakit input-group">';
	   echo '<p><input '.$cpt_checked.' type="checkbox" name="tgc_enable_cpt['.$cpt.']" value="1" class="tggrouped"> <strong>'.ucfirst( implode(' ' , explode('_', $cpt) )  ).'</strong></p>';

    echo '</div>';
   endforeach;
}

function tgc_cpt_form_callback() {
?>
<form method="post" action="options.php">  
            <?php 
           
                settings_fields( 'tgc_enable_cpt' );
                do_settings_sections( 'tgc_enable_cpt' );               

            ?>             
            <?php submit_button(); ?>  
        </form> 
 <?php 

    }

add_action('admin_init' , 'tgc_cpt_settings');