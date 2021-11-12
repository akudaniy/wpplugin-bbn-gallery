<?php 


class BBN_Spin {

  public static function spin($s) {
    preg_match('#{(.+?)}#is',$s,$m);
    if(empty($m)) return $s;

    $t = $m[1];

    if(strpos($t,'{')!==false){
      $t = substr($t, strrpos($t,'{') + 1);
    }

    $parts = explode("|", $t);
    $s = preg_replace("+{".preg_quote($t)."}+is", $parts[array_rand($parts)], $s, 1);

    return self::spin($s);
  }



  public static function autoSpinAttachment() {
    global $post;

    $options    = bbn_options_items();
    $imgmeta    = wp_get_attachment_metadata( $post->ID );

    $img_w      = $imgmeta['width'];
    $img_h      = $imgmeta['height'];

    $jud        = get_the_title();
    $parent     = get_post( $post->post_parent ); 
    $parenturl  = get_permalink( $post->post_parent );
    $cats       = get_the_category( $parent->ID );

    $cat1       = $cats[0]->name;
    $date       = get_the_time('F jS, Y');
    $author     = get_the_author();
    $link       = get_permalink();
    $blog       = get_bloginfo('name');
    $blogurl    = get_bloginfo('url');

    $desc       = self::spin( stripslashes( $options['bbn_spin_att'] ) );

    $src_reps = array(
      '[title]'         => $jud,
      '[parent_title]'  => $parent->post_title,
      '[parent_url]'    => $parenturl,
      '[permalink]'     => $link,
      '[cat]'           => $cat1,
      '[date]'          => $date,
      '[author]'        => $author,
      '[blog]'          => $blog,
      '[url]'           => $blogurl,
      '[img_w]'         => $img_w, 
      '[img_h]'         => $img_h, 
      '[today_day]'     => date("l", time()), 
      );

    $descout  = str_ireplace( array_keys($src_reps),
                              array_values($src_reps), 
                              $desc );

    return $descout;
  }

  public static function arrayFilter( $array ) {

    $arrcleans = array();
    foreach ($array as $arr) {
      if( strlen($arr) > 5 ) {
        $arrcleans[] = $arr;
      }
    }

    return $arrcleans;

  }

}
