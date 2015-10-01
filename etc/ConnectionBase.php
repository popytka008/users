<?php

/**
* Описывает абстракцию классов подключения к БД.
* Задаёт их интерфейс.
* @author Андрей
* @version 1.0
* @created 01-окт-2015 0:45:50
*/
abstract class ConnectionBase
{

/**
* единственный (и статический) экземпляр класса
*/
protected static $_instance;
/**
* ресурс подключения - не нулл если есть подключение
*/
private $_resource;


protected function __construct()
{
$this->Connect();
}

/**
* Подключение к БД
*/
abstract public function Connect();

/**
* Отключение от БД
*/
abstract public function Disconnect();

/**
* Создание единственного экземпляра класса для создания соединения на период
* обработки запроса
*/
public static function GetInstance(){ return null; }

/**
* Проверка существования подкючения
*/
public function IsConnected()
{
return $this->_resource;
}

}