-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 14 2015 г., 19:53
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `documents`
--

DELIMITER $$

-- --------------------------------------------------------

--
-- Структура таблицы `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `id_online` int(11) NOT NULL AUTO_INCREMENT,
  `sid` varchar(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `time_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_last` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_online`),
  KEY `online_ibfk_2` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='определение сессии, активного времени онлайн.' AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Структура таблицы `priv2role`
--

CREATE TABLE IF NOT EXISTS `priv2role` (
  `id_role` int(11) NOT NULL,
  `id_priv` int(11) NOT NULL,
  PRIMARY KEY (`id_priv`,`id_role`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `priv2role`
--

INSERT INTO `priv2role` (`id_role`, `id_priv`) VALUES
  (1, 1),
  (2, 1),
  (2, 2),
  (3, 1),
  (3, 2),
  (3, 3),
  (4, 1),
  (4, 2),
  (4, 3),
  (4, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `privs`
--

CREATE TABLE IF NOT EXISTS `privs` (
  `id_priv` int(11) NOT NULL AUTO_INCREMENT,
  `priv` varchar(20) NOT NULL,
  PRIMARY KEY (`id_priv`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='привилегии доступа к страницам приложения' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `privs`
--

INSERT INTO `privs` (`id_priv`, `priv`) VALUES
  (1, 'preview anon-zone'),
  (2, 'preview common-zone'),
  (3, 'preview all-zones'),
  (4, 'preview and edit all');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ключ таблицы',
  `name` varchar(20) NOT NULL COMMENT 'название роли',
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='таблица перечисляет роли доступа для клинентов' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id_role`, `name`) VALUES
  (1, 'anon'),
  (2, 'client'),
  (3, 'super-client'),
  (4, 'master');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `users_ibfk_2` (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='описание пользователя: логин, пароль и роль' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `login`, `password`, `name`) VALUES
  (1, 4, 'sasha', '', 'sasha'),
  (2, 1, 'anon', '', 'anon'),
  (3, 3, 'chuch', '880cf765dace97311c3a49c440681a49', 'chuch'),
  (4, 2, 'misha', '383d802a4c84af5ac3719276218bb918', 'misha'),
  (5, 4, 'super', '1b3231655cebb7a1f783eddf27d254ca', 'super');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `online`
--
ALTER TABLE `online`
ADD CONSTRAINT `online_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `priv2role`
--
ALTER TABLE `priv2role`
ADD CONSTRAINT `priv2role_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `priv2role_ibfk_2` FOREIGN KEY (`id_priv`) REFERENCES `privs` (`id_priv`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
