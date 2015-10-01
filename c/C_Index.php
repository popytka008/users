<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.09.15
 * Time: 22:32
 */
class C_Index extends Controller
{
  /**
   * Задает начальную работу контролёра, а именно:
   * - получение псетителя по заданным элементам(сессия, кука, БД)
   * - обновление активности посетителя в БД
   */
  public function onStart()
  {
    parent::onStart();

    $this->getUser();
    if($this->_user){
      $this->_right_to_view_this_page = $this->_user->id_role;
      $this->updateActivity();
    } else
      $this->_right_to_view_this_page = 1;
  }
  /**
   * Задаёт финальную фазу работы контролёра, а именноЖ
   * - вычисление отображаемой страницы
   */
  public function onEnd()
  {
    if (!$this->resolvePage()) {
      header('Location: p404.php');
    } else
      $this->_vid->view('v/index.html');

    parent::onEnd();
  }

}