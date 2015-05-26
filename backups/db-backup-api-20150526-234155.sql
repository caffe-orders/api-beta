CREATE DATABASE IF NOT EXISTS api;

USE api;

DROP TABLE IF EXISTS albums;

CREATE TABLE `albums` (
  `placeId` int(11) NOT NULL,
  `url` varchar(70) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO albums VALUES("4","places/4/album/8b2425df448bb056fdc8a211f62e77f2.jpg");
INSERT INTO albums VALUES("1","places/1/album/3796e2a5908b6185fd214276bf7bf6e6.jpg");
INSERT INTO albums VALUES("1","places/1/album/98a19c58abbf73e6417afe4805abcbc0.jpg");



DROP TABLE IF EXISTS comments;

CREATE TABLE `comments` (
  `senderId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `text` varchar(500) NOT NULL,
  `pubDate` date NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO comments VALUES("1","5","0","sample comment text","2002-04-20","1");
INSERT INTO comments VALUES("1","5","0","sample comment text","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","ewetwe","2015-04-02","1");
INSERT INTO comments VALUES("1","5","1","Я просто обязан написать этот ахуенный комментарий, ведь баг фиксед :D","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","tryrth","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","dddddddddd","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","xcv","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","укеку","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","укеку435","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","45","2015-04-02","1");
INSERT INTO comments VALUES("2","5","0","цук","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","цуауц","2015-04-02","1");
INSERT INTO comments VALUES("2","5","0","","2015-04-02","1");
INSERT INTO comments VALUES("2","5","0","","2015-04-02","1");
INSERT INTO comments VALUES("1","5","0","sdfdsd","2015-04-02","1");
INSERT INTO comments VALUES("1","5","1","234","2015-04-04","1");
INSERT INTO comments VALUES("1","5","1","wefew","2015-04-04","1");
INSERT INTO comments VALUES("1","5","1","wefeweeee","2015-04-04","1");
INSERT INTO comments VALUES("1","5","1","sdfdsfЛалка","2015-04-04","1");
INSERT INTO comments VALUES("1","5","1","sdfdsfЛалка","2015-04-04","1");
INSERT INTO comments VALUES("1","5","1","Лалкаааа","2015-04-04","1");
INSERT INTO comments VALUES("1","5","1","Лалкаааа","2015-04-04","1");
INSERT INTO comments VALUES("1","5","1","retyutrewrtyu","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","Тестовый коммент с крилицей","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","vfffubz","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","увучцу","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","увучцуусу","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","увучцуусу","2015-04-05","1");
INSERT INTO comments VALUES("1","5","0","htbrgvefc","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","htbrgvefc","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","wqewqewqewqe","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","wqewqewqewqe","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","wqewqewqewqe","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","wqesrdfghj","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","wwef","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","wwef","2015-04-05","1");
INSERT INTO comments VALUES("1","5","0","de","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","4y54","2015-04-05","1");
INSERT INTO comments VALUES("1","5","1","awdawd","2015-04-06","1");
INSERT INTO comments VALUES("1","5","0","ef","2015-04-06","1");
INSERT INTO comments VALUES("1","5","0","ef","2015-04-06","1");
INSERT INTO comments VALUES("1","5","0","sef","2015-04-06","1");
INSERT INTO comments VALUES("1","5","0","sef","2015-04-06","1");
INSERT INTO comments VALUES("1","4","0","zsczc","2015-04-06","1");
INSERT INTO comments VALUES("1","4","0","w3fwfse","2015-04-07","1");
INSERT INTO comments VALUES("1","5","1","awdawd","2015-04-07","1");
INSERT INTO comments VALUES("1","5","1","awdawdawd","2015-04-07","1");
INSERT INTO comments VALUES("1","5","1","alert(&quot;awdawd&quot;);","2015-04-07","1");
INSERT INTO comments VALUES("1","5","1","wadawd345345345","2015-04-07","1");
INSERT INTO comments VALUES("1","5","1","ыфыфш","2015-04-07","1");
INSERT INTO comments VALUES("1","5","1","фцвфцв","2015-04-12","1");
INSERT INTO comments VALUES("1","5","1","фцвфцв","2015-04-12","1");
INSERT INTO comments VALUES("1","5","1","1233333333","2015-04-12","1");
INSERT INTO comments VALUES("1","4","1","фцвфцв","2015-04-12","1");
INSERT INTO comments VALUES("1","4","1","фцвфцв","2015-04-13","1");
INSERT INTO comments VALUES("1","4","1","оарпапл рлоры","2015-04-13","1");
INSERT INTO comments VALUES("1","4","1","цфвфцвфц","2015-04-13","1");
INSERT INTO comments VALUES("1","5","1","вввв","2015-04-17","1");
INSERT INTO comments VALUES("1","5","1","пустой комент","2015-05-03","1");
INSERT INTO comments VALUES("1","5","1","вц","2015-05-21","0");
INSERT INTO comments VALUES("1","5","1","awd","2015-05-22","0");
INSERT INTO comments VALUES("5","5","1","wad","2015-05-22","0");
INSERT INTO comments VALUES("1","5","1","wad","2015-05-22","0");
INSERT INTO comments VALUES("5","5","1","ntcn","2015-05-22","0");
INSERT INTO comments VALUES("5","5","0","awd","2015-05-22","0");



DROP TABLE IF EXISTS complex_dinner;

CREATE TABLE `complex_dinner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeId` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `cost` int(11) NOT NULL,
  `day` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO complex_dinner VALUES("1","2","0","234234dsfsdfsd","1111","100","3");
INSERT INTO complex_dinner VALUES("2","1","1","qwe","qweqweqwe","11111","3");



DROP TABLE IF EXISTS corporate_orders;

CREATE TABLE `corporate_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `dateStart` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateFinish` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `code` int(11) NOT NULL,
  `data` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS dish;

CREATE TABLE `dish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(350) NOT NULL,
  `cost` int(11) NOT NULL,
  `dishCategoryId` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO dish VALUES("1","a3334","awdawd","123","2","0");
INSERT INTO dish VALUES("2","a234234","awdawd","123","1","0");
INSERT INTO dish VALUES("3","a22wwdw234","awdawd","123","2","0");
INSERT INTO dish VALUES("4","aфцвwdw234","awdawd","123","1","0");
INSERT INTO dish VALUES("5","wadawd","wadwad","234","2","0");
INSERT INTO dish VALUES("6","wadawd","wadwad","234","1","0");
INSERT INTO dish VALUES("7","aфцвwdw234","awdawd","123","2","0");
INSERT INTO dish VALUES("8","аааааа","awdawd","123","2","0");
INSERT INTO dish VALUES("9","aфцвwdw234","awdawd","123","2","0");
INSERT INTO dish VALUES("10","a3334","awdawd","123","2","0");
INSERT INTO dish VALUES("11","фцвфцвфцв","awdawd","123","1","0");
INSERT INTO dish VALUES("12","aфцвwdw234","awdawd","123","2","0");
INSERT INTO dish VALUES("13","dish","awdawd","123","1","0");
INSERT INTO dish VALUES("14","Сметанка в сметанке","Сметанка в сметанке лучек","20000","1","0");



DROP TABLE IF EXISTS dish_category;

CREATE TABLE `dish_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO dish_category VALUES("1","1stCat","0");
INSERT INTO dish_category VALUES("2","testCategory","0");
INSERT INTO dish_category VALUES("3","testCategory1","1");
INSERT INTO dish_category VALUES("4","testCategory","0");
INSERT INTO dish_category VALUES("5","testCategory","0");
INSERT INTO dish_category VALUES("6","1","0");
INSERT INTO dish_category VALUES("7","testCategory333","0");



DROP TABLE IF EXISTS files_token;

CREATE TABLE `files_token` (
  `token` varchar(64) COLLATE utf8_bin NOT NULL,
  `sessionHash` varchar(64) COLLATE utf8_bin NOT NULL,
  `deleteDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO files_token VALUES("41e06d53ed81ad4cd393f82f14ab74b4","306804551f155a2b1d44c5679326a3a3","2015-05-26 22:20:41");
INSERT INTO files_token VALUES("501a7861b8aaa16d745e4c3a9e9cc12e","306804551f155a2b1d44c5679326a3a3","2015-05-26 22:22:48");
INSERT INTO files_token VALUES("2884a4b0acdbce1257b539091b8e08ad","306804551f155a2b1d44c5679326a3a3","2015-05-26 22:25:59");



DROP TABLE IF EXISTS menu;

CREATE TABLE `menu` (
  `placeId` int(11) NOT NULL,
  `dishId` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO menu VALUES("3","11","0");
INSERT INTO menu VALUES("3","2","0");
INSERT INTO menu VALUES("3","8","0");
INSERT INTO menu VALUES("3","1","0");
INSERT INTO menu VALUES("1","14","0");
INSERT INTO menu VALUES("3","4","0");



DROP TABLE IF EXISTS place_rated;

CREATE TABLE `place_rated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO place_rated VALUES("1","1","2","3");
INSERT INTO place_rated VALUES("2","1","5","4");
INSERT INTO place_rated VALUES("3","1","4","5");
INSERT INTO place_rated VALUES("4","1","1","4");
INSERT INTO place_rated VALUES("5","1","3","1");



DROP TABLE IF EXISTS place_statistics;

CREATE TABLE `place_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeId` int(11) NOT NULL,
  `allViews` int(11) NOT NULL,
  `todayViews` int(11) NOT NULL,
  `allVisited` int(11) NOT NULL,
  `todayVisited` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS places;

CREATE TABLE `places` (
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO places VALUES("1","VivaldiCaffeеTesst","1","https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.4166082006163!2d30.339385631773798!3d53.90657244840632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000:0x3a1deb5578d145d1!2z0J_QsNGA0LzQtdC30LDQvQ!5e0!3m2!1sru!2sru!4v1422629379226","Magic Street2","375445378287","123-123","descr full","Кафе","4","1","1","italian","1","1","1","100000");
INSERT INTO places VALUES("2","VivaldiCaffe","1","","Magic Street","123213123","123-123","descr","&ETH;","3","1","1","&ETH;","1","1","1","123123");
INSERT INTO places VALUES("3","&ETH;","1","","Magic Street","123213123","123-123","descr","&ETH;","1","1","1","&ETH;","1","1","1","123123");
INSERT INTO places VALUES("4","&ETH;","1","","Magic Street","123213123","123-123","descr","&ETH;","5","1","1","&ETH;","1","1","1","123123");
INSERT INTO places VALUES("5","БугуртКафе","1","https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.4166082006163!2d30.339385631773798!3d53.90657244840632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000:0x3a1deb5578d145d1!2z0J_QsNGA0LzQtdC30LDQvQ!5e0!3m2!1sru!2sru!4v1422629379226","Magic Street","123213123","123-123","descr","Кафе","4","1","1","Итальянская","1","1","1","123123");



DROP TABLE IF EXISTS prohibited_names;

CREATE TABLE `prohibited_names` (
  `value` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS registration_requests;

CREATE TABLE `registration_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `placeType` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `commentary` varchar(10000) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO registration_requests VALUES("1","1","awda","caffe","mogilev","comment","1");



DROP TABLE IF EXISTS restore_access;

CREATE TABLE `restore_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` bigint(20) NOT NULL,
  `code` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `attempts` int(11) NOT NULL,
  `isActive` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO restore_access VALUES("8","375445378289","79087","2015-05-26 15:28:18","2","1");



DROP TABLE IF EXISTS rooms;

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeId` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO rooms VALUES("1","1","1","323","0");
INSERT INTO rooms VALUES("2","2","1","123","0");
INSERT INTO rooms VALUES("3","3","11","200","0");
INSERT INTO rooms VALUES("4","1","2","100","0");
INSERT INTO rooms VALUES("5","1","3","100","0");
INSERT INTO rooms VALUES("6","3","1","100","0");
INSERT INTO rooms VALUES("7","5","12","200","0");
INSERT INTO rooms VALUES("8","1","4","100","1");
INSERT INTO rooms VALUES("9","1","5","1","0");
INSERT INTO rooms VALUES("10","1","6","11","0");
INSERT INTO rooms VALUES("11","1","7","12","0");
INSERT INTO rooms VALUES("12","1","8","12","0");



DROP TABLE IF EXISTS table_orders;

CREATE TABLE `table_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `tableId` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `activateCode` int(11) NOT NULL,
  `attempts` int(11) NOT NULL,
  `dateOrder` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

INSERT INTO table_orders VALUES("22","1","5","7","1","3","4887","3","2015-05-22 17:02:59");
INSERT INTO table_orders VALUES("23","1","5","7","1","3","6151","1","2015-05-22 17:05:28");
INSERT INTO table_orders VALUES("24","1","5","7","1","3","5720","1","2015-05-22 17:14:38");
INSERT INTO table_orders VALUES("26","1","5","7","1","3","3369","3","2015-05-22 17:36:29");
INSERT INTO table_orders VALUES("27","1","5","7","1","2","1038","3","2015-05-25 13:13:46");



DROP TABLE IF EXISTS tables;

CREATE TABLE `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `posX` int(11) NOT NULL,
  `posY` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO tables VALUES("1","5","7","1","34","45","2","0");
INSERT INTO tables VALUES("2","1","4","1","24","65","0","0");
INSERT INTO tables VALUES("3","1","4","4","23","41","0","0");
INSERT INTO tables VALUES("4","1","4","2","64","29","0","0");
INSERT INTO tables VALUES("5","1","12","1","44","7","0","0");
INSERT INTO tables VALUES("6","1","12","2","44","7","0","0");
INSERT INTO tables VALUES("7","1","12","4","45","5","0","0");
INSERT INTO tables VALUES("8","1","12","1","44","8","0","0");
INSERT INTO tables VALUES("9","1","12","4","44","7","0","0");
INSERT INTO tables VALUES("10","1","12","1","44","7","0","0");
INSERT INTO tables VALUES("11","1","12","2","45","1","0","0");



DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` char(255) NOT NULL,
  `lastName` char(255) NOT NULL,
  `email` char(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `pwdHash` char(255) NOT NULL DEFAULT 'default',
  `access` tinyint(4) NOT NULL,
  `regDate` datetime NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `sessionHash` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO users VALUES("1","Максим","Концевой","clain@sample.com","375445378289","bd40cc1fed396db7c897e2f4a373270c","3","2015-04-01 19:10:20","0","306804551f155a2b1d44c5679326a3a3");
INSERT INTO users VALUES("5","Алексей","Алиновский","dvd2444@mail.ru","375445378289","bd40cc1fed396db7c897e2f4a373270c","3","2015-05-04 00:00:00","0","2f1c922c6a3cf52b6d26c279a2227e81");



