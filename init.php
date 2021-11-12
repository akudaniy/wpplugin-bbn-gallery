<?php
/*
Plugin Name: BBN Gallery
Version: 1.4
Plugin URI: http://www.murdanieko.com/
Description: Galeri foto untuk BersamaBerbuatNyata
Author: Murdani Eko
Author URI: http://www.murdanieko.com/
Text Domain: bbn
Last Change: 9:43 am 20 Oktober 2015
*/

define('BBN_PLUGIN_TEXTDOMAIN', 'bbn');
define('BBN_PLUGIN_DIR_URL',  plugin_dir_url( __FILE__ ));
define('BBN_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ));

if( !class_exists('DNY_Image_Manager') ) require_once BBN_PLUGIN_DIR_PATH . 'inc/daniy-image-manager/image-manager.php';
require_once BBN_PLUGIN_DIR_PATH . 'inc/class.BBN_Spin.php';
require_once BBN_PLUGIN_DIR_PATH . 'inc/class.BBN_Utils.php';
require_once BBN_PLUGIN_DIR_PATH . 'inc/post-types.php';
require_once BBN_PLUGIN_DIR_PATH . 'inc/shortcodes.php';
require_once BBN_PLUGIN_DIR_PATH . 'admin/settings.php';
require_once BBN_PLUGIN_DIR_PATH . 'cores.php';
require_once BBN_PLUGIN_DIR_PATH . 'hooks.php';



add_action('admin_enqueue_scripts', 'bbn_admin_script');
function bbn_admin_script() {

}



register_activation_hook( __FILE__, 'bbn_plugin_setup' );
function bbn_plugin_setup() {

}



/**
 * Get BBN Gallery options value
 */
function bbn_options_items() {

  $default_items = bbn_options_items_default();

  $bbn_opts = get_option('bbn_options');
  if( ! $bbn_opts ) {
    $bbn_opts = $default_items;
  } else {
    $bbn_opts = array_merge($default_items, $bbn_opts);
  }

  return $bbn_opts;
}



/**
 * Default option values for BBN Gallery
 */
function bbn_options_items_default() {
  return array (
    'bbn_gallery_location'  => 'after',
    'bbn_image_size'        => 'original',
    'bbn_single_amount'     => '30',
    'bbn_randomize'         => '',
    'bbn_show_thumbnail'    => '',
    'bbn_image_link'        => 'source',
    'bbn_custom_css'        => bbn_custom_css_default(),
  );
}



function bbn_custom_css_default() {

  $css = <<<EOF
.bbn-archive-set {margin-bottom: 30px;}
.bbn-container, .bbn-row, .bbn-grid {box-sizing: border-box; position: relative;}
.bbn-container::before, .bbn-container::after, .bbn-archive-set::before, .bbn-archive-set::after, .bbn-row::before, .bbn-row::after {content:" "; display: table;}
.bbn-container::after, .bbn-archive-set::after, .bbn-row::after {clear: both;}
.bbn-image-title {display: none;}
.bbn-image-wrap {display: block; float: left;}
.bbn-image-wrap img {float: left; height: 150px; opacity: 1; padding: 3px; position: relative; width: 150px;}
.bbn-image-thumbnail {}

.bbn-row {margin-left: -15px; margin-right: -15px;}
.bbn-grid {float: left; width: 25%; padding-left: 15px; padding-right: 15px;}

@media (min-width: 481px) and (max-width:799px) {
  .bbn-grid {width: 50%;}
}

@media (max-width:480px) {
  .bbn-grid {float: none; width: 100%;}
}


EOF;

  return $css;

}



function bbn_spin_att_default() {
  $spin  = '{If you are looking for|This article is talking about|Get the latest information about} [title]. ';
  $spin .= 'Check out our gallery attachment of [parent_title] which titled [title] can be ';
  $spin .= 'found on [permalink]. This article is categorized as [cat] posted at [date] by [author]. ';

  return $spin;

}



/* ---=== Changelogs ===---

===================================
     3:09 pm  12 September 2015
===================================


 */