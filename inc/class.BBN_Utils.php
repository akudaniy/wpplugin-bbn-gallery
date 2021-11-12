<?php

class BBN_Utils {


  /**
   * Translate time into verbals like "1 hour ago", "4 weeks ago"
   * 
   * @param   int     $time
   * @param   int     $granularity
   * @return  string
   */
  public static function relativeTime($time, $granularity=2) {

    $d[0] = array(1,"second");
    $d[1] = array(60,"minute");
    $d[2] = array(3600,"hour");
    $d[3] = array(86400,"day");
    $d[4] = array(604800,"week");
    $d[5] = array(2592000,"month");
    $d[6] = array(31104000,"year");

    $w = array();

    $return = "";
    $now = time();
    $diff = ($now-$time);
    $secondsLeft = $diff;

    for($i=6;$i>-1;$i--) {

      $w[$i] = intval($secondsLeft/$d[$i][0]);
      $secondsLeft -= ($w[$i]*$d[$i][0]);


      if($w[$i]!=0) {
      $return.= abs($w[$i]) . " " . $d[$i][1] . (($w[$i]>1)?'s':'') ." ";
      }

    }

    $return .= ($diff>0)?"ago":"left";
    return $return;
  }



  /**
   * Create a text excerpt
   * 
   * @param   int     $max_char
   * @param   string  $more_link_text
   * @param   bool    $use_post_excerpt
   * 
   * @return  string
   */
  public static function excerpt($max_char, $more_link_text = '[&#8230;]', $use_post_excerpt = FALSE) {
  
    global $post;
    
    if( $use_post_excerpt && strlen($post->post_excerpt) > 5 ) {
      $content = get_the_excerpt();
      echo $content;
      return;
    }  
    
    $content = get_the_content();
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = wp_strip_all_tags($content);
    
    if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {

      $content = substr($content, 0, $espacio);
      $content = $content;
      echo $content . " {$more_link_text}";

    } else {
      echo $content . " {$more_link_text}";

    }
    
    return;
  }





  public static function stringExcerpt( $string, $max_char ) {
    
    if ((strlen($string)>$max_char) && ($espacio = strpos($string, " ", $max_char ))) {

      $string = substr($string, 0, $espacio);
      return $string;

    } else {
      return $string;

    }

  }



  /**
   * Check the $n is the multiples result of $multiplier
   *
   * Useful in a foreach iteration to output thumbnail images.
   * If you have a set of thumbnails inside a container of certain width,
   * each images has 10px margin-right which need to be reset after 4 times in a row
   * To calculate which image needed to be reset, this function
   * is a great help, saves you two lines of code
   *
   * @author  Murdani Eko
   * @param   int   $n
   * @param   int   $multiplier
   * @return  bool
   */
  public static function isMultiplesOf($n, $multiplier) {

    $modulus = ($n + 1) % $multiplier;
    if( $modulus == 0 ) return TRUE;
    return FALSE;


  }


  /**
   * Check if the number given is an odd number. Usually used to check $n value within a foreach loop
   * 
   * @param   int   $n 
   * @param   bool  $start_zero   this function usually used in foreach where items starts from zero rather than one
   */
  public static function isOdd($n, $start_zero = TRUE) {
    if( $start_zero ) 
      $n = $n + 1;

    $modulus = $n % 2;
    if( $modulus == 0 ) return FALSE;
    return TRUE;
  }




  /**
   * 'var_dump' a variable with tree structure, far better than var_dump
   *
   * @link http://www.php.net/manual/en/function.var-dump.php#80288
   * @param mixed $var
   * @param string $var_name
   * @param string $indent
   * @param string $reference
   */

  public static function treeDump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)  {

      $tree_dump_indent = "<span style='color:#eeeeee;'>|</span> &nbsp;&nbsp; ";
      $reference = $reference.$var_name;
      $keyvar = 'the_tree_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';

      if (is_array($var) && isset($var[$keyvar]))
      {
          $real_var = &$var[$keyvar];
          $real_name = &$var[$keyname];
          $type = ucfirst(gettype($real_var));
          echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
      }
      else
      {
          $var = array($keyvar => $var, $keyname => $reference);
          $avar = &$var[$keyvar];

          $type = ucfirst(gettype($avar));
          if($type == "String") $type_color = "<span style='color:green'>";
          elseif($type == "Integer") $type_color = "<span style='color:red'>";
          elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
          elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
          elseif($type == "NULL") $type_color = "<span style='color:black'>";

          if(is_array($avar))
          {
              $count = count($avar);
              echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#a2a2a2'>$type ($count)</span><br>$indent(<br>";
              $keys = array_keys($avar);
              foreach($keys as $name)
              {
                  $value = &$avar[$name];
                  tree_dump($value, "['$name']", $indent.$tree_dump_indent, $reference);
              }
              echo "$indent)<br>";
          }
          elseif(is_object($avar))
          {
              echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br>$indent(<br>";
              foreach($avar as $name=>$value) tree_dump($value, "$name", $indent.$tree_dump_indent, $reference);
              echo "$indent)<br>";
          }
          elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
          elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span><br>";
          elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
          elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
          elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
          else echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $avar<br>";

          $var = $var[$keyvar];
      }

  }


}