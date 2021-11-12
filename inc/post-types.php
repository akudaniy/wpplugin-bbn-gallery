<?php 
/**
 * File: post-types.php
 * Version: 1
 * Last Edit: 8:17 pm  19 Oktober 2015
 */


/**
 * Add custom post types
 *
 */
add_action( 'init', 'bbn_custom_post_types' );
function bbn_custom_post_types() {

  $labels = array(
    'name'               => _x( 'Galleries', 'post type general name' ),
    'singular_name'      => _x( 'Gallery', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Gallery' ),
    'edit_item'          => __( 'Edit Gallery' ),
    'new_item'           => __( 'New Gallery' ),
    'all_items'          => __( 'All Galleries' ),
    'view_item'          => __( 'View Gallery' ),
    'search_items'       => __( 'Search Galleries' ),
    'not_found'          => __( 'No galleries found' ),
    'not_found_in_trash' => __( 'No galleries found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Galleries'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our gallery specific data',
    'public'        => true,
    'show_ui'       => true,
    'menu_position' => 5,
    'rewrite'       => array( 'slug' => 'gallery' ),
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
    'has_archive'   => true,
    'hierarchical'  => true,
  );
  register_post_type( 'bbn_gallery', $args );
  flush_rewrite_rules();
  
}


/*
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 *
add_action( 'init', 'bbn_custom_taxonomies', 0 );
function bbn_custom_taxonomies() {


  //----- Add new "language" taxonomy to Post Type -----//
  $labels = array(
    'name'                        => _x( 'Languages', 'taxonomy general name' ),
    'singular_name'               => _x( 'Language', 'taxonomy singular name' ),
    'search_items'                => __( 'Search languages' ),
    'popular_items'               => __( 'Popular languages' ),
    'all_items'                   => __( 'All languages' ),
    'parent_item'                 => null,
    'parent_item_colon'           => null,
    'edit_item'                   => __( 'Edit language' ), 
    'update_item'                 => __( 'Update language' ),
    'add_new_item'                => __( 'Add New language' ),
    'new_item_name'               => __( 'New language Name' ),
    'separate_items_with_commas'  => __( 'Separate languages' ),
    'add_or_remove_items'         => __( 'Add or remove language' ),
    'choose_from_most_used'       => __( 'Choose from the most used languages' ),
    'menu_name'                   => __( 'Languages' ),
  ); 
  register_taxonomy('languages', 'post' ,array(
    'hierarchical'          => false,
    'labels'                => $labels,
    'show_ui'               => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'lang' ),
  ));

}

*/