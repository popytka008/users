<?php
/**
 * @author alex
 * @version 1.0
 * @created 01-окт-2015 0:45:51
 */
class MysqlDataManager extends DataManagerBase
{

  /**
   *
   * @param query
   * @return int | null
   */
  public function Delete($query)
  {
    return $this->GetResult($query);
  }

  /**
   * вернкуть единственный экземпляр класса по требованию
   */
  public static function GetInstance()
  {
    if (!self::$_instance) {
      self::$_instance = new MysqlDataManager(MysqlConnection::getInstance());
      //self::$_instance->_connection->Connect();включено
    }

    return self::$_instance;
  }

  /**
   * получить из БД результат запроса, или ошибку/номер ошибки
   * вернуть вызвавшему. результат запроса
   *
   * @param query
   * @return int | null
   */
  public function GetResult($query)
  {
    if ($r = mysql_query($query)) {
      $this->_result = $r;
    } else {
      $this->_error_message = mysql_error();
      $this->_error_num = mysql_errno();
      $this->_result = null;
    }
    return $this->_result;
  }

  /**
   *
   * @param query
   * @return int | null
   */
  public function Insert($query)
  {
    return $this->GetResult($query);
  }

  /**
   *
   * @param query
   * @return array | null
   */
  public function Select($query)
  {
    if ($r = mysql_query($query)) {
      $n = mysql_num_rows($r);

      for ($i = 0; $i < $n; $i++) {
        $row = mysql_fetch_assoc($r);
        $this->_result[] = $row;
      }
    } else {
      $this->_error_message = mysql_error();
      $this->_error_num = mysql_errno();
      $this->_result = null;
    }

    return $this->_result;
  }

  /**
   *
   * @param query
   * @return int | null
   */
  public function Update($query)
  {
    return $this->GetResult($query);
  }

}