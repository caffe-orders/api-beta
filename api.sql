-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 10 2015 г., 21:23
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
  `pubDate` date NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`senderId`, `placeId`, `state`, `text`, `pubDate`, `deleted`) VALUES
(1, 5, 0, 'sample comment text', '2002-04-20', 1),
(1, 5, 0, 'sample comment text', '2015-04-02', 1),
(1, 5, 0, 'ewetwe', '2015-04-02', 1),
(1, 5, 1, 'Я просто обязан написать этот ахуенный комментарий, ведь баг фиксед :D', '2015-04-02', 1),
(1, 5, 0, 'tryrth', '2015-04-02', 1),
(1, 5, 0, 'dddddddddd', '2015-04-02', 1),
(1, 5, 0, 'xcv', '2015-04-02', 1),
(1, 5, 0, 'укеку', '2015-04-02', 1),
(1, 5, 0, 'укеку435', '2015-04-02', 1),
(1, 5, 0, '45', '2015-04-02', 1),
(2, 5, 0, 'цук', '2015-04-02', 0),
(1, 5, 0, 'цуауц', '2015-04-02', 1),
(2, 5, 0, '', '2015-04-02', 0),
(2, 5, 0, '', '2015-04-02', 0),
(1, 5, 0, 'sdfdsd', '2015-04-02', 1),
(1, 5, 1, '234', '2015-04-04', 1),
(1, 5, 1, 'wefew', '2015-04-04', 1),
(1, 5, 1, 'wefeweeee', '2015-04-04', 1),
(1, 5, 1, 'sdfdsfЛалка', '2015-04-04', 1),
(1, 5, 1, 'sdfdsfЛалка', '2015-04-04', 1),
(1, 5, 1, 'Лалкаааа', '2015-04-04', 1),
(1, 5, 1, 'Лалкаааа', '2015-04-04', 1),
(1, 5, 1, 'retyutrewrtyu', '2015-04-05', 1),
(1, 5, 1, 'Тестовый коммент с крилицей', '2015-04-05', 1),
(1, 5, 1, 'vfffubz', '2015-04-05', 1),
(1, 5, 1, 'увучцу', '2015-04-05', 1),
(1, 5, 1, 'увучцуусу', '2015-04-05', 1),
(1, 5, 1, 'увучцуусу', '2015-04-05', 1),
(1, 5, 0, 'htbrgvefc', '2015-04-05', 1),
(1, 5, 1, 'htbrgvefc', '2015-04-05', 1),
(1, 5, 1, 'wqewqewqewqe', '2015-04-05', 1),
(1, 5, 1, 'wqewqewqewqe', '2015-04-05', 1),
(1, 5, 1, 'wqewqewqewqe', '2015-04-05', 1),
(1, 5, 1, 'wqesrdfghj', '2015-04-05', 1),
(1, 5, 1, 'wwef', '2015-04-05', 1),
(1, 5, 1, 'wwef', '2015-04-05', 1),
(1, 5, 0, 'de', '2015-04-05', 0),
(1, 5, 1, '4y54', '2015-04-05', 0),
(1, 5, 1, 'awdawd', '2015-04-06', 0),
(1, 5, 0, 'ef', '2015-04-06', 0),
(1, 5, 0, 'ef', '2015-04-06', 0),
(1, 5, 0, 'sef', '2015-04-06', 0),
(1, 5, 0, 'sef', '2015-04-06', 0),
(1, 4, 0, 'zsczc', '2015-04-06', 0),
(1, 4, 0, 'w3fwfse', '2015-04-07', 0),
(1, 5, 1, 'awdawd', '2015-04-07', 0),
(1, 5, 1, 'awdawdawd', '2015-04-07', 0),
(1, 5, 1, 'alert(&quot;awdawd&quot;);', '2015-04-07', 0),
(1, 5, 1, 'wadawd345345345', '2015-04-07', 0),
(1, 5, 1, 'ыфыфш', '2015-04-07', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `complex_dinner`
--

CREATE TABLE IF NOT EXISTS `complex_dinner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeId` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `serialisedData` varchar(4000) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `corporate_orders`
--

CREATE TABLE IF NOT EXISTS `corporate_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` date NOT NULL,
  `code` int(11) NOT NULL,
  `serializedData` varchar(3000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dish`
--

CREATE TABLE IF NOT EXISTS `dish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(350) NOT NULL,
  `cost` int(11) NOT NULL,
  `imgSrc` varchar(150) NOT NULL,
  `dishCategoryId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dish_category`
--

CREATE TABLE IF NOT EXISTS `dish_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `dish_category`
--

INSERT INTO `dish_category` (`id`, `name`, `deleted`) VALUES
(1, 'testCategory', 1),
(2, 'testCategory', 1),
(3, 'testCategory1', 1),
(4, 'testCategory', 0),
(5, 'testCategory', 0),
(6, '1', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `file_token`
--

CREATE TABLE IF NOT EXISTS `file_token` (
  `userid` int(11) NOT NULL,
  `token` int(11) NOT NULL,
  `dateExpiries` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `placeId` int(11) NOT NULL,
  `dishId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Структура таблицы `place_rated`
--

CREATE TABLE IF NOT EXISTS `place_rated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `place_statistics`
--

CREATE TABLE IF NOT EXISTS `place_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeId` int(11) NOT NULL,
  `allViews` int(11) NOT NULL,
  `todayViews` int(11) NOT NULL,
  `allVisited` int(11) NOT NULL,
  `todayVisited` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `prohibited_names`
--

CREATE TABLE IF NOT EXISTS `prohibited_names` (
  `value` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeId` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `posX` int(11) NOT NULL,
  `posY` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `table_orders`
--

CREATE TABLE IF NOT EXISTS `table_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `tableId` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `activateCode` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `phone`, `pwdHash`, `access`, `regDate`, `isActive`, `sessionHash`) VALUES
(1, 'Ыгар', 'Жоржев', 'clain@sample.com', 375291269934, 'cb6474b4e2f29b95654296bda17da524', 1, '2015-04-01 19:10:20', 0, '3f848383aca7fb2835963842aad617e5'),
(2, 'Лалка', 'Лалалай', 'clain1@sample.com', 37529126993466, 'cb6474b4e2f29b95654296bda17da524', 1, '2015-04-02 00:00:00', 0, '9687b677556f8bd95c63c78fc9836b99');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
