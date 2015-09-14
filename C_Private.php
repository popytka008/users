<?php


/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 14.09.2015
 * Time: 19:42
 */
class C_Private extends Controller {
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
            //страница 404 (посетитель не зарегистрирован )
            //или
            //страница 404 (права доступа не соответствуют)
            header('Location: p404.php');
        } else
            // если мы здесь, то права есть, очевидно (вторая часть логического выражения)
            // подключим страницу
            $this->_vid->view('v/private.html');

        parent::onEnd();
    }
}