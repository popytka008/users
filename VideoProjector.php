<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.09.15
 * Time: 22:20
 */
class VideoProjector
{

  /**
   * @param $filename string filename
   */
  public function view($filename, array $argv = null)
  {
    if($argv)
      foreach($argv as $k => $v){
        $$k = $v;
      }

    ob_start();

    include $filename;
    echo ob_get_clean();
  }
}

