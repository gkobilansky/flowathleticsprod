<?php
/*
function my_deregister_javascript() {
	wp_deregister_script( 'thickbox' ); 
}

add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );
*/
//======Heading=========================//


function custom_inner_container () {
 
 	 echo "<div id='heading_wrapper'><div class='inner'></div></div>";
}  

add_action( 'woo_content_before', 'custom_inner_container' );

 


//======breadcrumb=========================//


function remove_breadcrumb() { 
    remove_action('woo_loop_before','woo_breadcrumbs'); 
} 

add_action('init', 'remove_breadcrumb'); 


function custom_breadcrumb() {  
    $args = array(  
    'separator' => '/', 
    //'before' => '<span class="breadcrumb-title">' . __( 'You are here:', 'woothemes' ) . '</span>', 
    'after' => false, 
    'front_page' => false, 
    'show_home' => __( 'FlowAthletics', 'woothemes' ),  
    'echo' => false,  
    'show_posts_page' => false 
    );
 woo_breadcrumbs( $args );  
} 

add_action('woo_loop_before', 'custom_breadcrumb'); 


function my_scripts_method() {
	wp_enqueue_script(
		'custom-script',
		get_stylesheet_directory_uri() . '/script.js',
		array('jquery')
	); 
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' ); 

//======excerpt=========================//

function custom_excerpt_length( $length ) {
	return 75;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/*-----------------------------------------------------------------------------------*/
/* Post More  */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_post_more' ) ) {
function woo_post_more() {
	if ( get_option( 'woo_disable_post_more' ) != 'true' ) {

	$html = '';

	if ( get_option('woo_post_content') == 'excerpt' ) { $html .= '[view_full_article] '; }

	$html = apply_filters( 'woo_post_more', $html );

		if ( $html != '' ) {
?>
	<div class="post-more">
		<?php
			echo $html;
		?>
	</div>
<?php
		}
	}
} // End woo_post_more()
}
 
?>