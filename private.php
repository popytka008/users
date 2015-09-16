<?php
require_once 'etc/autoload.php';

$page_status = '4';
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 11.09.2015
 * Time: 19:09
 */


$controller = new C_Private($page_status);
$controller->Request();