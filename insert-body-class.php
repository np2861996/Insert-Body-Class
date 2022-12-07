<?php
/**
 * Plugin Name: Insert Body Class
 * Plugin URI: https://github.com/np2861996/Insert-Body-Class
 * Description: Quick, easy, advance plugin for add body class. 
 * Author: BeyondN
 * Text Domain: Insert_Body_Class
 * Version: 1.0.0
 *
 * @package Wing_Forms
 * @author BeyondN
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Add Custom meta box
function add_custom_body_class_post_meta_boxes() {
	$screens = get_post_types();
	foreach ( $screens as $screen ) {
		add_meta_box('add_custom_body_class_box', 'Insert Body Class', 'add_custom_body_class_box', $screen, 'side', 'default');
	}
}
add_action( "admin_init", "add_custom_body_class_post_meta_boxes" );

function save_custom_body_class_post_meta_boxes(){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( get_post_status( $post->ID ) === 'auto-draft' ) {
        return;
    }
    update_post_meta( $post->ID, "add_custom_body_class", sanitize_text_field( $_POST[ "add_custom_body_class" ] ) );
}
add_action( 'save_post', 'save_custom_body_class_post_meta_boxes' );

function add_custom_body_class_box(){
	global $post;
   	$get_class_value = get_post_custom( $post->ID );
	$add_custom_body_class = !empty($get_class_value[ "add_custom_body_class" ][ 0 ]) ? $get_class_value[ "add_custom_body_class" ][ 0 ] : ''; ?>
    <input type="text" id="add_custom_body_class" name="add_custom_body_class" value="<?php echo $add_custom_body_class; ?>">
    <?php    
}

// dispaly body class function
add_filter('body_class','add_custom_field_body_class');
function add_custom_field_body_class( $classes ) {
	$show_body_class = get_post_meta(get_the_ID(),'add_custom_body_class', true);
	if($show_body_class){		
		$classes[] = $show_body_class;		
	}	
	// return the $classes array
	return $classes;
}