-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 11 2015 г., 02:52
-- Версия сервера: 5.1.53
-- Версия PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `article`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  `article_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `name`, `text`, `date`, `article_id`) VALUES
(20, 'Вася', 'Блин все норм', '2015-12-11', 156),
(21, 'Петя', 'второй коммент', '2015-12-11', 156),
(22, 'Иван ', 'третий коммент', '2015-12-11', 156),
(23, 'вася', 'dll injection', '2015-12-11', 157),
(24, 'Вася', 'первый коммент', '2015-12-11', 228),
(26, 'SZFDS<BR><BR><BR><BR>', 'SC.,MSD.M,<BR><BR>', '2015-12-11', 238),
(27, 'htmlspecialchars <BR> <BR> <BR> <BR>', 'szDLFMSZD;FM', '2015-12-11', 238),
(28, 'ZSDSZF', 'SADAS&lt;BR&gt;', '2015-12-11', 238),
(29, 'ZSDFLX,ZDF;L', 'SDSFC', '2015-12-11', 238);
