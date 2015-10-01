<?php

/**
 * @author Андрей
 * @version 1.0
 * @created 01-окт-2015 0:45:51
 */
class MysqlConnection extends ConnectionBase
{

  private $_resource;

  public function Connect()
  {
    mysql_connect(Data::HOST,Data::USERNAME, Data::PASSWORD);
    mysql_select_db(Data::DB);
  }

  public function Disconnect()
  {
    if ($this->_resource) mysql_close($this->_resource);
  }

  /**
   * Создание единственного экземпляра класса для создания соединения на период
   * обработки запроса
   */
  public static function GetInstance()
  {
    if (!self::$_instance)
      self::$_instance = new MysqlConnection();

    return self::$_instance;
  }

}