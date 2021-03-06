-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 20 May 2012, 18:22
-- Wersja serwera: 5.5.20
-- Wersja PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `buffet`
--

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `announcement`
--
CREATE TABLE IF NOT EXISTS `announcement` (
`id` int(10)
,`title` varchar(50)
,`date_from` date
,`date_to` date
,`pre_content_pl` text
,`content_pl` text
,`pre_content_en` text
,`content_en` text
,`event_news` varchar(1)
,`event_announcement` varchar(1)
,`picture_id` int(10)
,`arch_date` datetime
,`user` varchar(30)
,`title_en` varchar(50)
,`picture_id_small` int(10)
,`picture_id_archive` int(10)
,`picture_name` varchar(200)
,`picture_name_small` varchar(200)
,`picture_name_archive` varchar(200)
);
-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `archive`
--
CREATE TABLE IF NOT EXISTS `archive` (
`id` int(10)
,`title` varchar(50)
,`date_from` date
,`date_to` date
,`pre_content_pl` text
,`content_pl` text
,`pre_content_en` text
,`content_en` text
,`event_news` varchar(1)
,`event_announcement` varchar(1)
,`picture_id` int(10)
,`arch_date` datetime
,`user` varchar(30)
,`title_en` varchar(50)
,`picture_id_small` int(10)
,`picture_id_archive` int(10)
,`picture_name` varchar(200)
,`picture_name_small` varchar(200)
,`picture_name_archive` varchar(200)
);
-- --------------------------------------------------------

--
-- Struktura tabeli dla  `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `pre_content_pl` text COLLATE utf8_polish_ci,
  `content_pl` text COLLATE utf8_polish_ci,
  `pre_content_en` text COLLATE utf8_polish_ci,
  `content_en` text COLLATE utf8_polish_ci,
  `event_news` varchar(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `event_announcement` varchar(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `picture_id` int(10) DEFAULT NULL,
  `arch_date` datetime DEFAULT NULL,
  `user` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `title_en` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `picture_id_small` int(10) DEFAULT NULL,
  `picture_id_archive` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=98 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `galery`
--

CREATE TABLE IF NOT EXISTS `galery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `folder_date` datetime NOT NULL,
  `folder_content` varchar(2000) COLLATE utf8_polish_ci NOT NULL,
  `arch_date` datetime NOT NULL,
  `user` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `content` text COLLATE utf8_polish_ci,
  `picture_id` int(10) DEFAULT NULL,
  `arch_date` datetime NOT NULL,
  `user` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `content_en` text COLLATE utf8_polish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `information_view`
--
CREATE TABLE IF NOT EXISTS `information_view` (
`id` int(10)
,`type` varchar(50)
,`content` text
,`picture_id` int(10)
,`arch_date` datetime
,`user` varchar(30)
,`content_en` text
,`picture_name` varchar(200)
);
-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `news`
--
CREATE TABLE IF NOT EXISTS `news` (
`id` int(10)
,`title` varchar(50)
,`date_from` date
,`date_to` date
,`pre_content_pl` text
,`content_pl` text
,`pre_content_en` text
,`content_en` text
,`event_news` varchar(1)
,`event_announcement` varchar(1)
,`picture_id` int(10)
,`arch_date` datetime
,`user` varchar(30)
,`title_en` varchar(50)
,`picture_id_small` int(10)
,`picture_name` varchar(200)
,`picture_name_small` varchar(200)
);
-- --------------------------------------------------------

--
-- Struktura tabeli dla  `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `potwierdzenie` varchar(1) COLLATE utf8_polish_ci NOT NULL,
  `arch_date` date NOT NULL,
  `user` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `information` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `main_picture` varchar(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `gallery_id` int(10) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `arch_date` datetime NOT NULL,
  `user` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `link` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=226 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `password` char(40) COLLATE utf8_polish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktura widoku `announcement`
--
DROP TABLE IF EXISTS `announcement`;

CREATE VIEW `announcement` AS 
	select 
		`e`.`id` AS `id`,
		`e`.`title` AS `title`,
		`e`.`date_from` AS `date_from`,
		`e`.`date_to` AS `date_to`,
		`e`.`pre_content_pl` AS `pre_content_pl`,
		`e`.`content_pl` AS `content_pl`,
		`e`.`pre_content_en` AS `pre_content_en`,
		`e`.`content_en` AS `content_en`,
		`e`.`event_news` AS `event_news`,
		`e`.`event_announcement` AS `event_announcement`,
		`e`.`picture_id` AS `picture_id`,
		`e`.`arch_date` AS `arch_date`,
		`e`.`user` AS `user`,
		`e`.`title_en` AS `title_en`,
		`e`.`picture_id_small` AS `picture_id_small`,
		`e`.`picture_id_archive` AS `picture_id_archive`,
		`p`.`name` AS `picture_name`,
		`ps`.`name` AS `picture_name_small`,
		`pa`.`name` AS `picture_name_archive` 
	from 
		`event` `e` 
		left join `picture` `p` on(`p`.`id` = `e`.`picture_id`)
		left join `picture` `ps` on(`ps`.`id` = `e`.`picture_id_small`)
		left join `picture` `pa` on((`pa`.`id` = `e`.`picture_id_archive`))
	where 
		`e`.`event_announcement` = 'T'
		and (
			(`e`.`date_to` is not null and date_format(`e`.`date_to`,'%Y-%m-%d') >= date_format(now(),'%Y-%m-%d')) 
			or 
			(isnull(`e`.`date_to`) and date_format(`e`.`date_from`,'%Y-%m-%d') >= date_format(now(),'%Y-%m-%d'))
		);

-- --------------------------------------------------------

--
-- Struktura widoku `archive`
--
DROP TABLE IF EXISTS `archive`;

CREATE VIEW `archive` AS
	select 
		`e`.`id` AS `id`,
		`e`.`title` AS `title`,
		`e`.`date_from` AS `date_from`,
		`e`.`date_to` AS `date_to`,
		`e`.`pre_content_pl` AS `pre_content_pl`,
		`e`.`content_pl` AS `content_pl`,
		`e`.`pre_content_en` AS `pre_content_en`,
		`e`.`content_en` AS `content_en`,
		`e`.`event_news` AS `event_news`,
		`e`.`event_announcement` AS `event_announcement`,
		`e`.`picture_id` AS `picture_id`,
		`e`.`arch_date` AS `arch_date`,
		`e`.`user` AS `user`,
		`e`.`title_en` AS `title_en`,
		`e`.`picture_id_small` AS `picture_id_small`,
		`e`.`picture_id_archive` AS `picture_id_archive`,
		`p`.`name` AS `picture_name`,
		`ps`.`name` AS `picture_name_small`,
		`pa`.`name` AS `picture_name_archive` 
	from 
		`event` `e` 
		left join `picture` `p` on(`p`.`id` = `e`.`picture_id`)
		left join `picture` `ps` on(`ps`.`id` = `e`.`picture_id_small`)
		left join `picture` `pa` on(`pa`.`id` = `e`.`picture_id_archive`)
	where
		`e`.`event_announcement` = 'T'
		 and (
			(date_format(`e`.`date_to`,'%Y-%m-%d') is not null and date_format(`e`.`date_to`,'%Y-%m-%d') < date_format(now(),'%Y-%m-%d'))
			or
			(isnull(date_format(`e`.`date_to`,'%Y-%m-%d')) and date_format(`e`.`date_from`,'%Y-%m-%d') < date_format(now(),'%Y-%m-%d'))
		);

-- --------------------------------------------------------

--
-- Struktura widoku `information_view`
--
DROP TABLE IF EXISTS `information_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `information_view` AS select `i`.`id` AS `id`,`i`.`type` AS `type`,`i`.`content` AS `content`,`i`.`picture_id` AS `picture_id`,`i`.`arch_date` AS `arch_date`,`i`.`user` AS `user`,`i`.`content_en` AS `content_en`,`p`.`name` AS `picture_name` from (`information` `i` left join `picture` `p` on((`p`.`id` = `i`.`picture_id`)));

-- --------------------------------------------------------

--
-- Struktura widoku `news`
--
DROP TABLE IF EXISTS `news`;

CREATE VIEW `news` AS
	select 
		`e`.`id` AS `id`,
		`e`.`title` AS `title`,
		`e`.`date_from` AS `date_from`,
		`e`.`date_to` AS `date_to`,
		`e`.`pre_content_pl` AS `pre_content_pl`,
		`e`.`content_pl` AS `content_pl`,
		`e`.`pre_content_en` AS `pre_content_en`,
		`e`.`content_en` AS `content_en`,
		`e`.`event_news` AS `event_news`,
		`e`.`event_announcement` AS `event_announcement`,
		`e`.`picture_id` AS `picture_id`,
		`e`.`arch_date` AS `arch_date`,
		`e`.`user` AS `user`,
		`e`.`title_en` AS `title_en`,
		`e`.`picture_id_small` AS `picture_id_small`,
		`p`.`name` AS `picture_name`,
		`ps`.`name` AS `picture_name_small` 
from 
	`event` `e` left join `picture` `p` on(`p`.`id` = `e`.`picture_id`)
	left join `picture` `ps` on(`ps`.`id` = `e`.`picture_id_small`)
where `e`.`event_news` = 'T';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
