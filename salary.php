<?php
require_once 'autoload.php';

$page_status = '3';
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 11.09.2015
 * Time: 19:09
 */


$controller = new C_Salary($page_status);
$controller->Request();