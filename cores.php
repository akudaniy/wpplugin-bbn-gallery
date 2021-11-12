<?php 
/**
 * File: cores.php
 * Version: 1
 * Last Edit: 9:20 am 14 September 2015
 */



/**
 * Build attachment gallery using Google rich snippets
 * 
 * @return  $string  The HTML gallery
 */
function bbn_build_html() { 

  $options     = bbn_options_items();
  $imwpopts    = array(
    'image_size'        => $options['bbn_image_size'],
    'max_result_count'  => $options['bbn_single_amount'],
    'randomize_order'   => $options['bbn_randomize'],
    );
  $parents_img = imwp_get_gallery( $imwpopts );

  $g_html  = '';
  $g_html .= '<div id="bbn-wrap-'. get_the_ID() .'" class="bbn-container bbn-size-'. $options['bbn_image_size'] .' clearfix">';

    foreach( $parents_img as $pimg ): 

      if( $options['bbn_image_link']=='page' )
        $image_link = $pimg['link'];
      elseif( $options['bbn_image_link']=='source' )
        $image_link = $pimg['sizes'][$options['bbn_image_size']]['fileurl'];

      $g_html .= '<div class="bbn-image-wrap" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">';
      $g_html .= '<a itemprop="url" href="' . $image_link . '" title="' . $pimg['title'] . '" rel="prettyPhoto[pp_gal_'. get_the_ID() .']">';
      $g_html .= '<img src="' . $pimg['sizes']['thumbnail']['fileurl'] . '" alt="'. $pimg['title'] .'" />';
      // $g_html .= '<img src="' . $pimg['sizes'][$options['bbn_image_size']]['fileurl'] . '" alt="'. $pimg['title'] .'" />';
      $g_html .= '</a>';

      $g_html .= '<meta content="'. $pimg['title'] . ' of ' . get_the_title() .'" itemprop="caption description">';
      $g_html .= '<meta content="'. $pimg['sizes'][$options['bbn_image_size']]['fileurl'] .'" itemprop="thumbnail">';
      $g_html .= '<meta content="'. $pimg['sizes'][$options['bbn_image_size']]['width'] .'" itemprop="width">';
      $g_html .= '<meta content="'. $pimg['sizes'][$options['bbn_image_size']]['height'] .'" itemprop="height">';
      
      /* ========================================
      $g_html .= '<span class="media-sizes">';
        foreach ( $pimg['sizes'] as $sizename => $ps ) : 
          $format  = '<a href="%s" title="%s (%d x %d pixels)" target="_blank">%s</a>';
          $g_html .= sprintf($format, $ps['fileurl'], ucwords($sizename), $ps['width'], $ps['height'], ucwords($sizename[0]));
        endforeach;
      $g_html .= '</span>';
      =========================================== */

      if( $options['bbn_image_size']=='original' || $options['bbn_image_size']=='large' )
        $g_html .= '<p class="bbn-image-title">'. $pimg['title'] .'</p>';

      $g_html .= '</div>';

    endforeach;

  $g_html .= '</div>';

  return $g_html;

}


