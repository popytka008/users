<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 01.10.15
 * Time: 1:07
 */
abstract class DataManagerBase
{

  /**
   * подсоединение к (абстрактной) БД
   */
  protected $_connection;
  /**
   * текстовое содержимое сообщения об ошибке SQL на случай некорректного запроса
   */
  public $_error_message;
  /**
   * номер ошибки SQL на случай некорректного запроса
   */
  public $_error_num;
  /**
   * статический (и единый) экземпляр менеджера
   */
  protected static $_instance;
  /**
   * хранение результата запроса (архив или число задействованных полей [нет в коде]
   * или NULL)
   */
  protected $_result;


  /**
   * создание подключения
   *
   * @param ConnectionBase
   */
  protected function __construct(ConnectionBase $connection)
  {
    $this->_connection = $connection;
    //$this->_connection->Сonnect(); включено
  }

  /**
   * Удалить ряд из БД (сделать предохранитель на случай безконтрольного удаления,
   * например - ничего не делать)
   *
   * @param query
   */
  abstract public function Delete($query);
  /**
   * Выплонить запрос а БД
   *
   * @param query
   * @return array|null|int
   */
  public function Execute($query)
  {
    $type = explode(' ', $query);

    switch (strtoupper($type[0])) {
      case 'SELECT': return $this->Select($query);
      case 'INSERT': return $this->Insert($query);
      case 'UPDATE': return $this->Update($query);
      case 'DELETE': return $this->Delete($query);
    }
    return null;
  }

  /**
   * вырнуть п отребованию номер ошибки
   */
  public function GetErrno()
  {
    return $this->_error_num;
  }

  /**
   * вырнуть п отребованию текстовое содержимое ошибки
   */
  public function GetError()
  {
    return $this->_error_message;
  }

  /**
   * вставка ряда в БД
   *
   * @param query
   */
  abstract public function Insert($query);

  /**
   * выборка БД
   *
   * @param query
   */
  abstract public function Select($query);

  /**
   *
   * @param query
   */
  abstract public function Update($query);

}