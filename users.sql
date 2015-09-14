-- phpMyAdmin SQL Dump
-- version 4.4.14.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 14 2015 г., 10:30
-- Версия сервера: 5.5.39
-- Версия PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `documents`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_click`(IN `param` VARCHAR(30) CHARSET utf8)
    MODIFIES SQL DATA
begin

update `images` set `count` = `count`+1 where `id` = param;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `first_proc`()
    NO SQL
begin

select "hello world!";


end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `id_online` int(11) NOT NULL,
  `sid` varchar(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `time_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_last` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='определение сессии, активного времени онлайн.';

--
-- Дамп данных таблицы `online`
--

INSERT INTO `online` (`id_online`, `sid`, `id_user`, `time_start`, `time_last`) VALUES
(10, '1234567890', 4, '2015-09-13 21:57:50', '2015-09-13 21:57:50');

-- --------------------------------------------------------

--
-- Структура таблицы `priv2role`
--

CREATE TABLE IF NOT EXISTS `priv2role` (
  `id_role` int(11) NOT NULL,
  `id_priv` int(11) NOT NULL
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
  `id_priv` int(11) NOT NULL,
  `priv` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='привилегии доступа к страницам приложения';

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
  `id_role` int(11) NOT NULL COMMENT 'ключ таблицы',
  `name` varchar(20) NOT NULL COMMENT 'название роли'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='таблица перечисляет роли доступа для клинентов';

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
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='описание пользователя: логин, пароль и роль';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `login`, `password`, `name`) VALUES
(1, 4, 'sasha', '', 'sasha'),
(2, 1, 'anon', '', 'anon'),
(3, 3, 'super', '', 'super'),
(4, 2, 'misha', 'misha', 'misha'),
(5, 4, 'super', 'super', 'super');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`id_online`),
  ADD KEY `online_ibfk_2` (`id_user`);

--
-- Индексы таблицы `priv2role`
--
ALTER TABLE `priv2role`
  ADD PRIMARY KEY (`id_priv`,`id_role`),
  ADD KEY `id_role` (`id_role`);

--
-- Индексы таблицы `privs`
--
ALTER TABLE `privs`
  ADD PRIMARY KEY (`id_priv`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `users_ibfk_2` (`id_role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `online`
--
ALTER TABLE `online`
  MODIFY `id_online` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `privs`
--
ALTER TABLE `privs`
  MODIFY `id_priv` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ключ таблицы',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
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
