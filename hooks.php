<?php
/**
 * File: hooks.php
 * Version: 1
 * Last Edit: 3:33 pm  12 September 2015
 */


add_filter('the_content', 'bbn_the_content', 1);
function bbn_the_content( $content ) {
  global $post;
  $options    = bbn_options_items();

  // prepare reusable variables
  $title      = get_the_title();
  $title_attr = htmlspecialchars( get_the_title() );
  
  // concatenate contents with attachment galleries
  if( is_singular( 'bbn_gallery' ) ) {

    // show thumbnail in first post content
    $postthumb  = '';
    if( $options['bbn_show_thumbnail'] )
      $postthumb = imwp_get_thumbnail( 'original', '', array('insert_image_link'=>1) ) . "\n\n";

    $attachment_html = bbn_build_html();
    return $postthumb . $content . $attachment_html;

  }

  return $content;
}



add_action('wp_head', 'bbn_wp_head');
function bbn_wp_head() {
  global $post;
  $options = bbn_options_items();

  // output custom CSS
  echo '<style type="text/css">'. stripslashes( $options['bbn_custom_css'] ) .'</style>';
}


add_action('wp_footer', 'bbn_wp_footer', 999);
function bbn_wp_footer() {

echo '<script type="text/javascript">
      jQuery(document).ready(function(){
        jQuery("a[rel^=\'prettyPhoto\']").prettyPhoto();
      });
      </script>';
}



/**
 * Safely enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'bbn_enqueue_scripts' );
function bbn_enqueue_scripts() {
  wp_register_script( 'prettyphoto', BBN_PLUGIN_DIR_URL . 'inc/prettyPhoto/js/jquery.prettyPhoto.js', 'jquery', '3.1.6', TRUE );
  wp_enqueue_script( 'prettyphoto' );

  wp_enqueue_style( 'prettyphoto', BBN_PLUGIN_DIR_URL . 'inc/prettyPhoto/css/prettyPhoto.css' );
}

