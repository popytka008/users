<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.09.15
 * Time: 22:32
 */
class C_Login extends Controller
{
  /**
   * Задает начальную работу контролёра, а именно:
   * - получение псетителя по заданным элементам(сессия, кука, БД)
   * - обновление активности посетителя в БД
   */
  public function onStart()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      if ($this->_sid)
        $this->stopActivity();

      if ($this->_login) {
        setcookie('login', $this->_login, time() - 10000);
        setcookie('password', $this->_password, time() - 10000);
      }
      $this->_right_to_view_this_page = 1;
    }
  }

  /**
   *
   */
  public function onEnd()
  {
    $this->_errorMessage = '';
    $login = '';
    // отослал форму - ждёт ответа
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $login = $_POST['login'];
      $password = md5($_POST['password']);

      $this->_user = $this->_mechanic->getUserByLoginAndPassword($login, $password);
      if ($this->_user) {
        if($this->runActivity()){
          if ($_POST['remember'] === true) {
            setcookie('login', $login, time() + 10000000);
            setcookie('password', $password, time() + 10000000);
          }
          // переходим на главную страницу
          header('Location: index.php');
          exit();
        }
      }

      $this->_errorMessage = 'Что-то пошлО не так, не удалось создать сессию. Приношу свои извинения!..';
      if ($this->_sid)
        $this->stopActivity();
      if ($this->_login) {
        setcookie('login', $this->_login, time() - 10000);
        setcookie('password', '', time() - 10000);
      }
    }

    // это метод ГЕТ - простой вывод формы
    $this->_vid->view('v/login.html', array('errorMessage' => $this->_errorMessage, 'login' => $login));

    //echo 'out: public function onEnd()'.PHP_EOL.'<br/>';
  }

protected function goodPassword($question, $pattern) { return $question === $pattern; }

}