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
    //echo ('in: public function onStart()'.PHP_EOL.'<br/>');
    // пришол извне - очистить хвосты и всякие куки
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      // если задан сид - есть текущая сессия.
      // уничтожить метки сессии, удалить данные в таблице активностей `online`
      if ($this->_sid)
        $this->stopActivity();

      // если задан логин - существует кука
      // присвоить куке просроченную дату
      if ($this->_login) {
        setcookie('login', $this->_login, time() - 10000);
        setcookie('password', $this->_password, time() - 10000);
      }
      $this->_right_to_view_this_page = 1;
    }
    //echo 'out: public function onStart()'.PHP_EOL.'<br/>';
  }

  /**
   *
   */
  public function onEnd()
  {
    //echo 'in: public function onEnd()'.PHP_EOL.'<br/>';

    $this->_errorMessage = '';
    $login = '';
    // отослал форму - ждёт ответа
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //echo 'in: if ($_SERVER[\'REQUEST_METHOD\'] === \'POST\') '.PHP_EOL.'<br/>';
      //print_r($_POST); echo PHP_EOL.'<br/>';

      $login = $_POST['login'];
      $password = md5($_POST['password']);

      // попробуем определить uid, если получится:
      // генерируем sid - метку сессии
      // создадим запись в таблице активностей online по sid и uid
      // создадим сессию $_SESSION['sid'] = sid;
      // переправим посетителя на главную страницу.
      $this->_user = $this->_mechanic->getUserByLoginAndPassword($login, $password);
      // есть посетитель!! проверим пароль
      //if($this->_user)print_r($this->_user); else print_r ("никакой: \$this->_user"); echo PHP_EOL.'<br/>';
      if ($this->_user) {
        //print_r($this->_user);
        //необходим $_sid - генерируем!! и сразу:
        //создаём запись в таблице активностей online по sid и uid
        if($this->runActivity()){
          // ЗАПИСЬ В ТАБЛИЦУ АКТИВНОСТЕЙ ВНЕСЕНА:
          // создаем куку (если флаг в форме "ЗАПОМНИТЬ")
          if ($_POST['remember'] === true) {
            setcookie('login', $login, time() + 10000000);
            setcookie('password', $password, time() + 10000000);
          }
          // переходим на главную страницу
          header('Location: index.php');
          //echo 'out: if ($_SERVER[\'REQUEST_METHOD\'] === \'POST\') '.PHP_EOL.'<br/>';
          exit();
        }
      }
      // что-то не так - неверный пароль/логин - вернуть форму
      // удалив возможные сессию и запись в таблице активностей
      //echo 'in: что-то не так - неверный пароль/логин - вернуть форму'.PHP_EOL.'<br/>';

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