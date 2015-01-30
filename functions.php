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

function wpse_allowedtags() {
    // Add custom tags to this string
        return '<style>,<br>,<em>,<i>,<ul>,<ol>,<li>,<p>'; 
    }

if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) : 

    function wpse_custom_wp_trim_excerpt($wpse_excerpt) {
    $raw_excerpt = $wpse_excerpt;
        if ( '' == $wpse_excerpt ) {

            $wpse_excerpt = get_the_content('');
            $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
            $wpse_excerpt = strip_tags($wpse_excerpt, wpse_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = 110;
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

                foreach ($tokens[0] as $token) { 

                    if ($count >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) { 
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));

                $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '">' . '&nbsp;&raquo;&nbsp;' . sprintf(__( 'Keep Reading: %s &nbsp;&raquo;', 'wpse' ), get_the_title()) . '</a>'; 
                $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 

                //$pos = strrpos($wpse_excerpt, '</');
                //if ($pos !== false)
                // Inside last HTML tag
                //$wpse_excerpt = substr_replace($wpse_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
                //else
                // After the content
                $wpse_excerpt .= $excerpt_more; /*Add read more in new paragraph */

            return $wpse_excerpt;   

        }
        return apply_filters('wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt'); 


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