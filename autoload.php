<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.09.15
 * Time: 22:22
 */

function __autoload($filename){
  require_once $filename.'.php';
}