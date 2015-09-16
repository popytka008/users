<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.09.15
 * Time: 22:26
 */
class Controller
{
  protected $_page_status;

  protected $_mechanic;
  protected $_vid;

  protected $_right_to_view_this_page;


  protected $_sid;
  protected $_user;
  protected $_password;
  protected $_login;

  protected $_errorMessage;


  /**
   * Создание личных Механика и Видеопроектора.
   * Определение личных переменных sid ($_SESSION) и login/pwd ($_COOKIE)

   * @param $page_status
   */
  public function __construct($page_status)
  {
    session_start();

    $this->_page_status = $page_status;

    $this->_mechanic = new Mechanic();
    $this->_vid = new VideoProjector();


    if (isset($_SESSION['sid'])) $this->_sid = $_SESSION['sid'];

    if (isset($_COOKIE['login'])) {

      $this->_login = $_COOKIE['login'];
      $this->_password = $_COOKIE['password'];
    }

  }

  /**
   * Задает последовательность работы контролёра в приложении
   */
  public function Request(){
    $this->onStart();
    $this->onEnd();
  }

  /**
   * Задает начальную работу контролёра, а именно:
   * - получение псетителя по заданным элементам(сессия, кука, БД)
   * - обновление активности посетителя в БД
   */
  public function onStart()
  {
  }

  /**
   * Задаёт финальную фазу работы контролёра, а именноЖ
   * - вычисление отображаемой страницы
   */
  public function onEnd()
  {
  }


  /**
   * определение посетителя если есть возможность
   */
  public function getUser()
  {
    if (!$this->_sid) {
      if (!$this->_login) $this->_user = null;
      else {
        // нет сессии - но есть возможность (кука) её воссоздать
        $this->_user = $this->_mechanic->getUserByLoginAndPassword($this->_login, $this->_password);
      }
    }
    else
      $this->_user = $this->_mechanic->getUserBySid($this->_sid);
  }

  /**
   * определение показываемой страницы:
   * - эта страница (права доступа соответствуют)
   * - страница 404 (права доступа не соответствуют)
   */
  public function resolvePage()
  {
    return $this->_right_to_view_this_page >= $this->_page_status;
  }

  public function updateActivity()
  {
    //необходим $_sid
    if(!$this->_sid) {$_SESSION['sid'] = $this->_sid = $this->createSid();}

    // если активность обновлена так или иначе.
    if(!($this->_mechanic->updateActivity($this->_sid) || $this->isActive())){
      //$this->_mechanic->runActivity($this->_sid, $this->_user->id_user);
    }
  }

  public function runActivity()
  {
    // предварительное условие - посетитель зарегистрирован

    // создать sid если нету
    // создать запись активности
    // зарядить $_SESSION
    if(!$this->_sid) {$_SESSION['sid'] = $this->_sid = $this->createSid();}
    return $this->_mechanic->runActivity($this->_sid, $this->_user->id_user);
  }

  public function stopActivity()
  {
    $this->_mechanic->stopActivity($this->_sid);
  }

  public function isActive()
  {
    return $this->_mechanic->isActive($this->_sid);
  }
  public function createSid($length= 10)
  {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;

    while (strlen($code) < $length)
      $code .= $chars[mt_rand(0, $clen)];

    return $code;
  }

}