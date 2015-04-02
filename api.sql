-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 02 2015 г., 17:21
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `api`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `senderId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `text` varchar(500) NOT NULL,
  `pubDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`senderId`, `placeId`, `state`, `text`, `pubDate`) VALUES
(1, 5, 0, 'sample comment text', '2002-04-20'),
(1, 5, 0, 'sample comment text', '2015-04-02'),
(1, 5, 0, 'ewetwe', '2015-04-02');

-- --------------------------------------------------------

--
-- Структура таблицы `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `gmap` varchar(800) NOT NULL,
  `address` char(255) NOT NULL,
  `phones` char(255) NOT NULL,
  `workTime` char(255) NOT NULL,
  `descr` text NOT NULL,
  `type` char(255) NOT NULL,
  `sumRating` int(11) NOT NULL,
  `countRating` int(11) NOT NULL,
  `outdoors` tinyint(1) NOT NULL,
  `cuisine` char(255) NOT NULL,
  `parking` int(11) NOT NULL,
  `smoking` tinyint(1) NOT NULL,
  `wifi` tinyint(1) NOT NULL,
  `avgBill` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `places`
--

INSERT INTO `places` (`id`, `name`, `ownerId`, `gmap`, `address`, `phones`, `workTime`, `descr`, `type`, `sumRating`, `countRating`, `outdoors`, `cuisine`, `parking`, `smoking`, `wifi`, `avgBill`) VALUES
(1, 'VivaldiCaffe', 1, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.4166082006163!2d30.339385631773798!3d53.90657244840632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000:0x3a1deb5578d145d1!2z0J_QsNGA0LzQtdC30LDQvQ!5e0!3m2!1sru!2sru!4v1422629379226', 'Magic Street', '123213123', '123-123', 'descr', '&ETH;', 0, 0, 1, '&ETH;', 1, 1, 1, 123123),
(2, 'VivaldiCaffe', 1, '', 'Magic Street', '123213123', '123-123', 'descr', '&ETH;', 0, 0, 1, '&ETH;', 1, 1, 1, 123123),
(3, '&ETH;', 1, '', 'Magic Street', '123213123', '123-123', 'descr', '&ETH;', 0, 0, 1, '&ETH;', 1, 1, 1, 123123),
(4, '&ETH;', 1, '', 'Magic Street', '123213123', '123-123', 'descr', '&ETH;', 0, 0, 1, '&ETH;', 1, 1, 1, 123123),
(5, 'БугуртКафе', 1, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.4166082006163!2d30.339385631773798!3d53.90657244840632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000:0x3a1deb5578d145d1!2z0J_QsNGA0LzQtdC30LDQvQ!5e0!3m2!1sru!2sru!4v1422629379226', 'Magic Street', '123213123', '123-123', 'descr', 'Магия', 0, 0, 1, 'Итальянская', 1, 1, 1, 123123);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` char(255) NOT NULL,
  `lastName` char(255) NOT NULL,
  `email` char(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `pwdHash` char(255) NOT NULL,
  `access` tinyint(4) NOT NULL,
  `regDate` datetime NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `sessionHash` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `phone`, `pwdHash`, `access`, `regDate`, `isActive`, `sessionHash`) VALUES
(1, 'Ыгар', 'Жоржев', 'clain@sample.com', 375291269934, 'cb6474b4e2f29b95654296bda17da524', 1, '2015-04-01 19:10:20', 0, '3f848383aca7fb2835963842aad617e5');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
