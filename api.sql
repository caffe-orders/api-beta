-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 25 2015 г., 13:56
-- Версия сервера: 5.5.38
-- Версия PHP: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Структура таблицы `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `placeId` int(11) NOT NULL,
  `url` varchar(70) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `albums`
--

INSERT INTO `albums` (`placeId`, `url`) VALUES
(4, 'places/4/album/8b2425df448bb056fdc8a211f62e77f2.jpg'),
(1, 'places/1/album/3796e2a5908b6185fd214276bf7bf6e6.jpg'),
(1, 'places/1/album/98a19c58abbf73e6417afe4805abcbc0.jpg');

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
(2, 5, 0, 'цук', '2015-04-02', 1),
(1, 5, 0, 'цуауц', '2015-04-02', 1),
(2, 5, 0, '', '2015-04-02', 1),
(2, 5, 0, '', '2015-04-02', 1),
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
(1, 5, 0, 'de', '2015-04-05', 1),
(1, 5, 1, '4y54', '2015-04-05', 1),
(1, 5, 1, 'awdawd', '2015-04-06', 1),
(1, 5, 0, 'ef', '2015-04-06', 1),
(1, 5, 0, 'ef', '2015-04-06', 1),
(1, 5, 0, 'sef', '2015-04-06', 1),
(1, 5, 0, 'sef', '2015-04-06', 1),
(1, 4, 0, 'zsczc', '2015-04-06', 1),
(1, 4, 0, 'w3fwfse', '2015-04-07', 1),
(1, 5, 1, 'awdawd', '2015-04-07', 1),
(1, 5, 1, 'awdawdawd', '2015-04-07', 1),
(1, 5, 1, 'alert(&quot;awdawd&quot;);', '2015-04-07', 1),
(1, 5, 1, 'wadawd345345345', '2015-04-07', 1),
(1, 5, 1, 'ыфыфш', '2015-04-07', 1),
(1, 5, 1, 'фцвфцв', '2015-04-12', 1),
(1, 5, 1, 'фцвфцв', '2015-04-12', 1),
(1, 5, 1, '1233333333', '2015-04-12', 1),
(1, 4, 1, 'фцвфцв', '2015-04-12', 1),
(1, 4, 1, 'фцвфцв', '2015-04-13', 1),
(1, 4, 1, 'оарпапл рлоры', '2015-04-13', 1),
(1, 4, 1, 'цфвфцвфц', '2015-04-13', 1),
(1, 5, 1, 'вввв', '2015-04-17', 1),
(1, 5, 1, 'пустой комент', '2015-05-03', 1),
(1, 5, 1, 'вц', '2015-05-21', 0),
(1, 5, 1, 'awd', '2015-05-22', 0),
(5, 5, 1, 'wad', '2015-05-22', 0),
(1, 5, 1, 'wad', '2015-05-22', 0),
(5, 5, 1, 'ntcn', '2015-05-22', 0),
(5, 5, 0, 'awd', '2015-05-22', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `complex_dinner`
--

CREATE TABLE IF NOT EXISTS `complex_dinner` (
`id` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `cost` int(11) NOT NULL,
  `day` smallint(6) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `complex_dinner`
--

INSERT INTO `complex_dinner` (`id`, `placeId`, `deleted`, `name`, `description`, `cost`, `day`) VALUES
(1, 2, 0, '234234dsfsdfsd', '1111', 100, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `corporate_orders`
--

CREATE TABLE IF NOT EXISTS `corporate_orders` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` date NOT NULL,
  `code` int(11) NOT NULL,
  `serializedData` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dish`
--

CREATE TABLE IF NOT EXISTS `dish` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(350) NOT NULL,
  `cost` int(11) NOT NULL,
  `imgSrc` varchar(150) NOT NULL,
  `dishCategoryId` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `dish`
--

INSERT INTO `dish` (`id`, `name`, `description`, `cost`, `imgSrc`, `dishCategoryId`, `deleted`) VALUES
(1, 'a3334', 'awdawd', 123, 'dawda', 2, 0),
(2, 'a234234', 'awdawd', 123, 'dawda', 1, 0),
(3, 'a22wwdw234', 'awdawd', 123, 'dawda', 2, 0),
(4, 'aфцвwdw234', 'awdawd', 123, 'dawda', 1, 0),
(5, 'wadawd', 'wadwad', 234, '234234', 2, 0),
(6, 'wadawd', 'wadwad', 234, '234234', 1, 0),
(7, 'aфцвwdw234', 'awdawd', 123, 'dawda', 2, 0),
(8, 'аааааа', 'awdawd', 123, 'dawda', 2, 0),
(9, 'aфцвwdw234', 'awdawd', 123, 'dawda', 2, 0),
(10, 'a3334', 'awdawd', 123, 'dawda', 2, 0),
(11, 'фцвфцвфцв', 'awdawd', 123, 'dawda', 1, 0),
(12, 'aфцвwdw234', 'awdawd', 123, 'dawda', 2, 0),
(13, 'dish', 'awdawd', 123, 'dishs/b32908324d553a4a32f6abc6dc7495e8.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `dish_category`
--

CREATE TABLE IF NOT EXISTS `dish_category` (
`id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `dish_category`
--

INSERT INTO `dish_category` (`id`, `name`, `deleted`) VALUES
(1, '1stCat', 0),
(2, 'testCategory', 0),
(3, 'testCategory1', 1),
(4, 'testCategory', 0),
(5, 'testCategory', 0),
(6, '1', 0),
(7, 'testCategory333', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `files_token`
--

CREATE TABLE IF NOT EXISTS `files_token` (
  `token` varchar(64) COLLATE utf8_bin NOT NULL,
  `sessionHash` varchar(64) COLLATE utf8_bin NOT NULL,
  `deleteDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `files_token`
--

INSERT INTO `files_token` (`token`, `sessionHash`, `deleteDate`) VALUES
('7ea8e2620a84661773336b669f16af6d', '306804551f155a2b1d44c5679326a3a3', '2015-05-23 14:25:24');

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `placeId` int(11) NOT NULL,
  `dishId` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`placeId`, `dishId`, `deleted`) VALUES
(3, 11, 0),
(3, 2, 0),
(3, 8, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `places`
--

CREATE TABLE IF NOT EXISTS `places` (
`id` int(11) NOT NULL,
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
  `avgBill` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `places`
--

INSERT INTO `places` (`id`, `name`, `ownerId`, `gmap`, `address`, `phones`, `workTime`, `descr`, `type`, `sumRating`, `countRating`, `outdoors`, `cuisine`, `parking`, `smoking`, `wifi`, `avgBill`) VALUES
(1, 'VivaldiCaffeеTesst', 1, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.4166082006163!2d30.339385631773798!3d53.90657244840632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000:0x3a1deb5578d145d1!2z0J_QsNGA0LzQtdC30LDQvQ!5e0!3m2!1sru!2sru!4v1422629379226', 'Magic Street2', '375445378287', '123-123', 'descr full', 'Кафе', 4, 1, 1, '&amp;amp;ETH;', 1, 1, 1, 100000),
(2, 'VivaldiCaffe', 1, '', 'Magic Street', '123213123', '123-123', 'descr', '&ETH;', 3, 1, 1, '&ETH;', 1, 1, 1, 123123),
(3, '&ETH;', 1, '', 'Magic Street', '123213123', '123-123', 'descr', '&ETH;', 1, 1, 1, '&ETH;', 1, 1, 1, 123123),
(4, '&ETH;', 1, '', 'Magic Street', '123213123', '123-123', 'descr', '&ETH;', 5, 1, 1, '&ETH;', 1, 1, 1, 123123),
(5, 'БугуртКафе', 1, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.4166082006163!2d30.339385631773798!3d53.90657244840632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000:0x3a1deb5578d145d1!2z0J_QsNGA0LzQtdC30LDQvQ!5e0!3m2!1sru!2sru!4v1422629379226', 'Magic Street', '123213123', '123-123', 'descr', 'Магия', 4, 1, 1, 'Итальянская', 1, 1, 1, 123123);

-- --------------------------------------------------------

--
-- Структура таблицы `place_rated`
--

CREATE TABLE IF NOT EXISTS `place_rated` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `mark` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `place_rated`
--

INSERT INTO `place_rated` (`id`, `userId`, `placeId`, `mark`) VALUES
(1, 1, 2, 3),
(2, 1, 5, 4),
(3, 1, 4, 5),
(4, 1, 1, 4),
(5, 1, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `place_statistics`
--

CREATE TABLE IF NOT EXISTS `place_statistics` (
`id` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `allViews` int(11) NOT NULL,
  `todayViews` int(11) NOT NULL,
  `allVisited` int(11) NOT NULL,
  `todayVisited` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `prohibited_names`
--

CREATE TABLE IF NOT EXISTS `prohibited_names` (
  `value` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `restore_access`
--

CREATE TABLE IF NOT EXISTS `restore_access` (
`id` int(11) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `code` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `attempts` int(11) NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `restore_access`
--

INSERT INTO `restore_access` (`id`, `phone`, `code`, `date`, `attempts`, `isActive`) VALUES
(8, 375445378289, 77664, '2015-05-25 09:54:05', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
`id` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id`, `placeId`, `number`, `capacity`, `deleted`) VALUES
(1, 1, 1, 323, 0),
(2, 2, 1, 123, 0),
(3, 3, 11, 200, 0),
(4, 1, 2, 100, 0),
(5, 1, 3, 100, 0),
(6, 3, 1, 100, 0),
(7, 5, 12, 200, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
`id` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `posX` int(11) NOT NULL,
  `posY` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `tables`
--

INSERT INTO `tables` (`id`, `placeId`, `roomId`, `type`, `posX`, `posY`, `status`, `deleted`) VALUES
(1, 5, 7, 1, 34, 45, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `table_orders`
--

CREATE TABLE IF NOT EXISTS `table_orders` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `tableId` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `activateCode` int(11) NOT NULL,
  `attempts` int(11) NOT NULL,
  `dateOrder` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `table_orders`
--

INSERT INTO `table_orders` (`id`, `userId`, `placeId`, `roomId`, `tableId`, `status`, `activateCode`, `attempts`, `dateOrder`) VALUES
(22, 1, 5, 7, 1, 3, 4887, 3, '2015-05-22 17:02:59'),
(23, 1, 5, 7, 1, 3, 6151, 1, '2015-05-22 17:05:28'),
(24, 1, 5, 7, 1, 3, 5720, 1, '2015-05-22 17:14:38'),
(26, 1, 5, 7, 1, 3, 3369, 3, '2015-05-22 17:36:29'),
(27, 1, 5, 7, 1, 2, 1038, 3, '2015-05-25 13:13:46');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `firstName` char(255) NOT NULL,
  `lastName` char(255) NOT NULL,
  `email` char(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `pwdHash` char(255) NOT NULL DEFAULT 'default',
  `access` tinyint(4) NOT NULL,
  `regDate` datetime NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `sessionHash` char(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `phone`, `pwdHash`, `access`, `regDate`, `isActive`, `sessionHash`) VALUES
(1, 'Максим', 'Концевой', 'clain@sample.com', 375445378289, 'bd40cc1fed396db7c897e2f4a373270c', 3, '2015-04-01 19:10:20', 0, '306804551f155a2b1d44c5679326a3a3'),
(5, 'Алексей', 'Алиновский', 'dvd2444@mail.ru', 375445378289, 'bd40cc1fed396db7c897e2f4a373270c', 3, '2015-05-04 00:00:00', 0, '2f1c922c6a3cf52b6d26c279a2227e81');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complex_dinner`
--
ALTER TABLE `complex_dinner`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `corporate_orders`
--
ALTER TABLE `corporate_orders`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dish_category`
--
ALTER TABLE `dish_category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place_rated`
--
ALTER TABLE `place_rated`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place_statistics`
--
ALTER TABLE `place_statistics`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restore_access`
--
ALTER TABLE `restore_access`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_orders`
--
ALTER TABLE `table_orders`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complex_dinner`
--
ALTER TABLE `complex_dinner`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `corporate_orders`
--
ALTER TABLE `corporate_orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `dish_category`
--
ALTER TABLE `dish_category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `place_rated`
--
ALTER TABLE `place_rated`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `place_statistics`
--
ALTER TABLE `place_statistics`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restore_access`
--
ALTER TABLE `restore_access`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `table_orders`
--
ALTER TABLE `table_orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
