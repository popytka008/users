<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.09.15
 * Time: 22:28
 */
class MSQL
{
  protected $_connection;
  static $_instance;
  public $error;

  /**
   * MSQL constructor.
   */
  protected function __construct()
  {
    if (!$this->_connection) {
      $this->_connection = mysql_connect('localhost:3306', 'root', '');
      mysql_select_db('documents');
    }
    self::$_instance = $this;
  }

  /**
   * @return MSQL
   */
  static public function getInstance()
  {
    $instance = new MSQL();
    return $instance;
  }

  public function __destruct()
  {
    //print_r($this->_connection);
    mysql_close($this->_connection);
  }

  public function selectLoginPassword(array $argv) //select(array('`users`', '`login`', $login, '`password`', $password)))
  {
    $resource = mysql_query("SELECT * FROM {$argv[0]} WHERE {$argv[1]} = '{$argv[2]}' AND {$argv[3]} = '{$argv[4]}'");

    if (!($result = mysql_fetch_assoc($resource))) {
      $this->error = mysql_error();
    }

    //print_r("SELECT * FROM {$argv[0]} WHERE {$argv[1]} = '{$argv[2]}' AND {$argv[3]} = '{$argv[4]}'".PHP_EOL.'<br/>');
    //print_r('строк: '.mysql_num_rows($resource).PHP_EOL.'<br/>');


    return $result;
  }

  public function select(array $argv)
  {
    $resource = mysql_query("SELECT * FROM {$argv[0]} WHERE {$argv[1]} = '{$argv[2]}'");

    if (!($result = mysql_fetch_assoc($resource))) {
      $this->error = mysql_error();
    }

    //print_r("SELECT * FROM {$argv[0]} WHERE {$argv[1]} = '{$argv[2]}'".PHP_EOL.'<br/>');
    //print_r('строк: '.mysql_num_rows($resource).PHP_EOL.'<br/>');


    return $result;
  }

  public function delete(array $argv)  //delete(array('`online`', '`sid`', $sid));
  {
    $resource = mysql_query("DELETE FROM {$argv[0]} WHERE {$argv[1]} = '{$argv[2]}'");

    //print_r("DELETE FROM {$argv[0]} WHERE {$argv[1]} = '{$argv[2]}'".PHP_EOL.'<br/>');
    //var_export($resource);echo PHP_EOL.'<br/>';
    //
    //print_r('строк: '.mysql_affected_rows()); echo PHP_EOL.'<br/>';
    return mysql_affected_rows();
  }

  public function update(array $argv) //update(array('`online`', '`time_last`', time(),'`sid`', $sid))
  {
    $resource = mysql_query("UPDATE {$argv[0]} SET {$argv[1]} = {$argv[2]} WHERE {$argv[3]} = '{$argv[4]}'");

    //print_r("UPDATE {$argv[0]} SET {$argv[1]} = {$argv[2]} WHERE {$argv[3]} = '{$argv[4]}'".PHP_EOL.'<br/>');
    //var_export($resource);echo PHP_EOL.'<br/>';
    //print_r('строк: '.mysql_affected_rows());echo PHP_EOL.'<br/>';

    return mysql_affected_rows();
  }

  public function insert($table, array $argv) //insert('`online`', array('`sid`', $sid, '`time_last`', time(), '`id_user`', $uid));
  {
    $resource = mysql_query("INSERT INTO {$table}({$argv[0]}, {$argv[2]}, {$argv[4]}) VALUES ('{$argv[1]}', {$argv[3]}, {$argv[5]})");

    //print_r("INSERT INTO {$table}({$argv[0]}, {$argv[2]}, {$argv[4]}) VALUES ('{$argv[1]}', {$argv[3]}, {$argv[5]})".PHP_EOL.'<br/>');
    //var_export($resource);echo PHP_EOL.'<br/>';
    //print_r('строк: '.mysql_affected_rows());echo PHP_EOL.'<br/>';

    return mysql_affected_rows();
    //return false;
  }

  public function getCount(array $argv)/*array('`online`', '`sid`', $sid))*/
  {
    $count = false;
    $resource = mysql_query("SELECT COUNT(*) FROM {$argv[0]} WHERE {$argv[1]} = '{$argv[2]}'");
    if ($result = mysql_fetch_row($resource)){
      $count = ((int)$result[0] > 0);
    }

    //print_r("SELECT COUNT(*) FROM {$argv[0]} WHERE {$argv[1]} = '{$argv[2]}'".PHP_EOL.'<br/>');
    //print_r('строк: '.mysql_num_rows($resource).PHP_EOL.'<br/>');

    return $count;
  }
}