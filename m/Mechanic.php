<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.09.15
 * Time: 22:29
 */
class Mechanic
{
  private $_msql;
  private $_result;
  public $error;

  /**
   * Mechanic constructor.
   */
  public function __construct()
  {
    $this->_msql = MSQL::getInstance();

  }


  /**
   * Определение посетителя по login в БД
   * @param $login string - ключ поиска в БД
   * @return null|User - результат поиска
   */
  function getUserByLoginAndPassword($login, $password)
  {
    $user = null;
    if ($this->_result = $this->_msql->selectLoginPassword(array('`users`', '`login`', $login, '`password`', $password))) {
      $user = new User();

      $user->id_user = $this->_result['id_user'];
      $user->id_role = $this->_result['id_role'];
      $user->login = $this->_result['login'];
      $user->password = $this->_result['password'];
      $user->name = $this->_result['name'];

    }
    $this->error = $this->_msql->error;

    return $user;
  }
  /**
   * Определение посетителя по login в БД
   * @param $login string - ключ поиска в БД
   * @return null|User - результат поиска
   */
  function getUserByLogin($login)
  {
    $user = null;
    if ($this->_result = $this->_msql->select(array('`users`', '`login`', $login))) {
      $user = new User();

      $user->id_user = $this->_result['id_user'];
      $user->id_role = $this->_result['id_role'];
      $user->login = $this->_result['login'];
      $user->password = $this->_result['password'];
      $user->name = $this->_result['name'];

    }
    $this->error = $this->_msql->error;

    return $user;
  }

  /**
   * Определение посетителя по sid в БД
   * @param $sid string - ключ поиска в БД
   * @return null|User - результат поиска
   */
  function getUserBySid($sid)
  {
    $user = null;
    if ($session = $this->_msql->select(array('`online`', '`sid`', $sid))) {
      $id_user = $session['id_user'];
      if ($this->_result = $this->_msql->select(array('`users`', '`id_user`', $id_user))) {

        $user = new User();

        $user->id_user = $this->_result['id_user'];
        $user->id_role = $this->_result['id_role'];
        $user->login = $this->_result['login'];
        $user->password = $this->_result['password'];
        $user->name = $this->_result['name'];
      }
    }
    $this->error = $this->_msql->error;

    return $user;
  }



  function updateActivity($sid)
  {
    return
      $this->_msql->update(array('`online`', '`time_last`', 'CURRENT_TIMESTAMP','`sid`', $sid));
  }

  function isActive($sid)
  {
    return $this->countActivity($sid);
  }

  function stopActivity($sid)
  {
    return $this->_msql->delete(array('`online`', '`sid`', $sid));
  }

  function countActivity($sid)
  {
    return $this->_msql->getCount(array('`online`', '`sid`', $sid));
  }
  function runActivity($sid, $uid)//($this->_sid, $this->_user->id_user)
  {
    return $this->_msql->insert('`online`', array('`sid`', $sid, '`time_last`', 'CURRENT_TIMESTAMP', '`id_user`', $uid));
  }

}