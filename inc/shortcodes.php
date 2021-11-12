<?php 

function bbn_gallery_shortcode( $atts ) {

  $return = '';
  $args = array(
    'post_type'       => 'bbn_gallery',
    'posts_per_page'  => -1,
    );
  $galleries = new WP_Query( $args );

  if( $galleries->have_posts() ):

    $return .= '<div class="bbn-row">';
    while( $galleries->have_posts() ): $galleries->the_post();

      $return .= '<div class="bbn-grid">';
      $return .= '<a href="'. get_the_permalink() .'">' . imwp_get_thumbnail() . '</a>';
      $return .= '<p><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></p>';
      $return .= '</div>';

    endwhile; wp_reset_postdata();
    $return .= '</div>';

  endif;

  return $return;
}
add_shortcode( 'bbn_gallery', 'bbn_gallery_shortcode' );