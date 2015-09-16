<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.09.15
 * Time: 22:22
 */

function __autoload($filename) {


  if($filename[1] === '_') {
    switch($filename[0]) {
    case 'C':
      require_once "c/{$filename}.php";

      return;
    case 'M':
      require_once "m/{$filename}.php";

      return;
    case 'V':
      require_once "v/{$filename}.php";

      return;
    }
  }

  switch($filename) {
  case 'Controller':
    require_once "c/{$filename}.php";

    return;
  case 'VideoProjector':
    require_once "v/{$filename}.php";

    return;
  case 'Mechanic':
    require_once "m/{$filename}.php";

    return;
  default:
    require_once "etc/{$filename}.php";
  }

}