-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 01 Kwi 2012, 19:00
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
,`date_from` datetime
,`date_to` datetime
,`pre_content_pl` char(200)
,`content_pl` varchar(2000)
,`pre_content_en` varchar(100)
,`content_en` varchar(2000)
,`event_news` varchar(1)
,`event_announcement` varchar(1)
,`picture_id` int(10)
,`arch_date` datetime
,`user` varchar(30)
,`picture_name` varchar(200)
);
-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `archive`
--
CREATE TABLE IF NOT EXISTS `archive` (
`id` int(10)
,`title` varchar(50)
,`date_from` datetime
,`date_to` datetime
,`pre_content_pl` char(200)
,`content_pl` varchar(2000)
,`pre_content_en` varchar(100)
,`content_en` varchar(2000)
,`event_news` varchar(1)
,`event_announcement` varchar(1)
,`picture_id` int(10)
,`arch_date` datetime
,`user` varchar(30)
,`picture_name` varchar(200)
);
-- --------------------------------------------------------

--
-- Struktura tabeli dla  `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime DEFAULT NULL,
  `pre_content_pl` char(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `content_pl` varchar(2000) COLLATE utf8_polish_ci NOT NULL,
  `pre_content_en` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `content_en` varchar(2000) COLLATE utf8_polish_ci DEFAULT NULL,
  `event_news` varchar(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `event_announcement` varchar(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `picture_id` int(10) DEFAULT NULL,
  `arch_date` datetime DEFAULT NULL,
  `user` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=33 ;

--
-- Zrzut danych tabeli `event`
--

INSERT INTO `event` (`id`, `title`, `date_from`, `date_to`, `pre_content_pl`, `content_pl`, `pre_content_en`, `content_en`, `event_news`, `event_announcement`, `picture_id`, `arch_date`, `user`) VALUES
(1, 'Tytuł pierwszego newsa', '2012-03-19 23:16:11', NULL, 'Zajawka newsa Zajawka newsa Ala ma kota a kot jest idiotaZajawka newsa Zajawka newsa Zajawka newsa Aleksandra Juchniewicz tralala co by tu jeszcze napisaćććććc\n\nZajawka newsa Zajawka newsa Ala ma kota', 'Adam Mickiewicz był synem Mikołaja Mickiewicza herbu Poraj, adwokata sądowego w Nowogródku i komornika mińskiego oraz Barbary z Majewskich, córki ekonoma z pobliskiego Czombrowa.\n\nW latach 1807–1815 uczęszczał do dominikańskiej szkoły powiatowej w Nowogródku. W 1812 miały miejsce dwa ważne wydarzenia w jego życiu: 16 maja umarł jego ojciec, a nieco później przez Nowogródek przeszły wojska Napoleona, maszerujące na Moskwę. Miasto Mickiewicza opanowała atmosfera radości i nadziei na koniec niewoli, jednak kilka miesięcy później ta sama Wielka Armia napoleońska wróciła rozbita i pokonana przez Rosjan.\n\nW 1815 Mickiewicz wyjechał do Wilna w celu podjęcia studiów. Studiował nauki humanistyczne na Uniwersytecie Wileńskim – czołowej uczelni dawnego Wielkiego Księstwa Litewskiego. Studia podjął na Wydziale Nauk Fizycznych i Matematycznych, uczęszczając jednocześnie na wykłady Wydziału Nauk Moralnych i Politycznych oraz Literatury i Sztuk Wyzwolonych. Ciężka sytuacja materialna rodziny po śmierci ojca skłoniła go do podjęcia nauki w uniwersyteckim Seminarium Nauczycielskim, co gwarantowało później zatrudnienie w szkołach carskich. Studia ukończył w 1819 ze stopniem magistra.', NULL, NULL, 'T', NULL, 1, NULL, NULL),
(2, 'To już drugi news', '2012-03-21 22:51:13', NULL, 'Zajawka newsa Zajawka newsa Ala ma kota a kot jest idiotaZajawka newsa Zajawka newsa Zajawka newsa A', 'Drugi news vo by tu w nim napisać', NULL, NULL, 'T', NULL, 2, NULL, NULL),
(3, 'Trzeci news', '2012-03-21 23:08:35', NULL, 'Zajawka newsa Zajawka newsa Ala ma kota a kot jest idiotaZajawka newsa Zajawka newsa Zajawka newsa A', 'Treść trzecie newsa\n\nCo by tu napisać', NULL, NULL, 'T', NULL, 3, '2012-03-21 23:08:35', 'root'),
(4, 'Czwarty news', '2012-03-21 23:09:14', NULL, 'Zajawka newsa Zajawka newsa Ala ma kota a kot jest idiotaZajawka newsa Zajawka newsa Zajawka newsa A', 'Treść czwartego newsa!!!\n\nCo by tu napisać', NULL, NULL, 'T', NULL, 4, '2012-03-21 23:09:14', 'root'),
(5, 'Piąty news :D', '2012-03-22 21:31:33', NULL, 'Zajawka newsa Zajawka newsa Ala ma kota a kot jest idiotaZajawka newsa Zajawka newsa Zajawka newsa A', 'Treść piątego newsa\n\n\nTreść piątwego newsa', NULL, NULL, 'T', NULL, 5, '2012-03-22 21:31:33', 'root'),
(6, 'Szósty news :D', '2012-03-22 21:32:44', NULL, 'Zajawka newsa Zajawka newsa Ala ma kota a kot jest idiotaZajawka newsa Zajawka newsa Zajawka newsa A', 'Treść szóstego newsa\n\n\nTreść szóstego newsa', NULL, NULL, 'T', NULL, 6, '2012-03-22 21:32:44', 'root'),
(7, 'Siódmy news :D', '2012-03-22 22:40:24', NULL, 'Zajawka newsa Zajawka newsa Ala ma kota a kot jest idiotaZajawka newsa Zajawka newsa Zajawka newsa A', 'Treść siódmego newsa\n\n\nTreść siódmego newsa', NULL, NULL, 'N', 'T', 7, '2012-03-22 22:40:24', 'root'),
(8, 'Siódmy news :D', '2012-03-22 22:45:48', NULL, 'Zajawka newsa Zajawka newsa Ala ma kota a kot jest idiotaZajawka newsa Zajawka newsa Zajawka newsa A', 'Treść siódmego newsa\n\n\nTreść siódmego newsa', NULL, NULL, 'T', NULL, 8, '2012-03-22 22:45:48', 'root'),
(9, 'Pierwsza zapowiedź', '2012-03-25 23:22:52', NULL, 'Zajawka pierwszej zapowiedzi tralala tralala Ala ma kota a kot jest idiorta Zajawka pierwszej zapowiedzi zajawkaa', 'Treść pierwszej zapowiedzi\n\nTreść pierwszej zapowiedzi', NULL, NULL, NULL, 'T', 9, '2012-03-25 23:22:52', 'root'),
(10, 'PIERWSZA ZAPOWIEDZ DZISIAJ', '2012-03-29 00:00:00', NULL, 'Zajawka pierwszej zapowiedzi dzisiaj Ala ma kota a kot jest idioa tralala Zajawka pierwszej zapowiedzi dzisiaj\n\nZajawka pierwszej zapowiedzi dzisiaj Zajawka pierwszej zapowiedzi dzisiaj Zajawka pierws', 'cos tam cos tam', NULL, NULL, NULL, 'T', 10, '2012-03-26 23:17:48', 'root'),
(11, 'Zapowiedź nr 2', '2012-03-29 00:00:00', NULL, 'Zapowiedź nr 2 tralala zapowiedćdkfgjjg nsdkjhfksdfh sjs jsdhf skjdhf sdhf djksh fsjkdhf jsd  ifhsudfhsuidfh sdhf siuhf suidhf shf isudhf sdhf sduihf suidhf iusdhf siudhf suidhf isduhf sdhiuf', 'zapowiedź nr 2 treść', NULL, NULL, NULL, 'T', 11, '2012-03-27 18:57:35', 'root'),
(12, 'Zapowiedź nr 3', '2012-03-30 00:00:00', NULL, 'Zapowiedź nr 3 tralala zapowiedćdkfgjjg nsdkjhfksdfh sjs jsdhf skjdhf sdhf djksh fsjkdhf jsd  ifhsudfhsuidfh sdhf siuhf suidhf shf isudhf sdhf sduihf suidhf iusdhf siudhf suidhf isduhf sdhiuf', 'zapowiedź nr 3 treść', NULL, NULL, NULL, 'T', 12, '2012-03-27 18:58:24', 'root'),
(13, 'Zapowiedź nr 4', '2012-03-31 00:00:00', NULL, 'Zapowiedź nr 4 tralala zapowiedćdkfgjjg nsdkjhfksdfh sjs jsdhf skjdhf sdhf djksh fsjkdhf jsd  ifhsudfhsuidfh sdhf siuhf suidhf shf isudhf sdhf sduihf suidhf iusdhf siudhf suidhf isduhf sdhiuf', 'zapowiedź nr 4 treść', NULL, NULL, NULL, 'T', 13, '2012-03-27 18:58:34', 'root'),
(14, 'Zapowiedź nr 5', '0000-00-00 00:00:00', NULL, 'Zapowiedź nr 5 tralala zapowiedćdkfgjjg nsdkjhfksdfh sjs jsdhf skjdhf sdhf djksh fsjkdhf jsd  ifhsudfhsuidfh sdhf siuhf suidhf shf isudhf sdhf sduihf suidhf iusdhf siudhf suidhf isduhf sdhiuf', 'zapowiedź nr 5 treść', NULL, NULL, NULL, 'T', 14, '2012-03-27 18:58:43', 'root'),
(15, 'Zapowiedź nr 6', '0000-00-00 00:00:00', NULL, 'Zapowiedź nr 6 tralala zapowiedćdkfgjjg nsdkjhfksdfh sjs jsdhf skjdhf sdhf djksh fsjkdhf jsd  ifhsudfhsuidfh sdhf siuhf suidhf shf isudhf sdhf sduihf suidhf iusdhf siudhf suidhf isduhf sdhiuf', 'zapowiedź nr 6 treść', NULL, NULL, NULL, 'T', 15, '2012-03-27 18:59:17', 'root'),
(16, 'Zapowiedź nr 7', '0000-00-00 00:00:00', NULL, 'Zapowiedź nr 7 tralala zapowiedćdkfgjjg nsdkjhfksdfh sjs jsdhf skjdhf sdhf djksh fsjkdhf jsd  ifhsudfhsuidfh sdhf siuhf suidhf shf isudhf sdhf sduihf suidhf iusdhf siudhf suidhf isduhf sdhiuf', 'zapowiedź nr 7 treść', NULL, NULL, NULL, 'T', 16, '2012-03-27 18:59:25', 'root'),
(17, 'Zapowiedź nr kolejny 11', '2012-03-30 00:00:00', NULL, 'Zajawka pierwszej zapowiedzi dzisiaj Ala ma kota a kot jest idioa tralala Zajawka pierwszej zapowiedzi dzisiaj\n\nZajawka pierwszej zapowiedzi dzisiaj Zajawka pierwszej zapowiedzi dzisiaj Zajawka pierws', 'zapowiedx ne kolejny', NULL, NULL, NULL, 'T', 17, '2012-03-27 19:04:09', 'root'),
(18, 'Zapowiedź nr kolejny 12', '2012-03-30 00:00:00', NULL, 'Zajawka pierwszej zapowiedzi dzisiaj Ala ma kota a kot jest idioa tralala Zajawka pierwszej zapowiedzi dzisiaj\n\nZajawka pierwszej zapowiedzi dzisiaj Zajawka pierwszej zapowiedzi dzisiaj Zajawka pierws', 'zapowiedx ne kolejny', NULL, NULL, NULL, 'T', 18, '2012-03-27 19:04:28', 'root'),
(19, 'Zapowiedź nr kolejny 13', '2012-03-30 00:00:00', NULL, 'Zajawka pierwszej zapowiedzi dzisiaj Ala ma kota a kot jest idioa tralala Zajawka pierwszej zapowiedzi dzisiaj\n\nZajawka pierwszej zapowiedzi dzisiaj Zajawka pierwszej zapowiedzi dzisiaj Zajawka pierws', 'zapowiedx ne kolejny', NULL, NULL, NULL, 'T', 19, '2012-03-27 19:04:50', 'root'),
(20, 'Zapowiedź nr kolejny 14', '2012-03-26 00:00:00', NULL, 'Zajawka pierwszej zapowiedzi dzisiaj Ala ma kota a kot jest idioa tralala Zajawka pierwszej zapowiedzi dzisiaj\n\nZajawka pierwszej zapowiedzi dzisiaj Zajawka pierwszej zapowiedzi dzisiaj Zajawka pierws', 'zapowiedx ne kolejny', NULL, NULL, NULL, 'T', 20, '2012-03-27 19:46:13', 'root'),
(21, 'Zapowiedź nr kolejny 15', '2012-03-26 00:00:00', NULL, 'Zajawka pierwszej zapowiedzi dzisiaj Ala ma kota a kot jest idioa tralala Zajawka pierwszej zapowiedzi dzisiaj\n\nZajawka pierwszej zapowiedzi dzisiaj Zajawka pierwszej zapowiedzi dzisiaj Zajawka pierws', 'zapowiedx ne kolejny', NULL, NULL, NULL, 'T', 21, '2012-03-27 19:46:26', 'root'),
(22, 'Zapowiedź nr kolejny 16', '2012-03-26 00:00:00', NULL, 'Zajawka pierwszej zapowiedzi dzisiaj Ala ma kota a kot jest idioa tralala Zajawka pierwszej zapowiedzi dzisiaj\n\nZajawka pierwszej zapowiedzi dzisiaj Zajawka pierwszej zapowiedzi dzisiaj Zajawka pierws', 'zapowiedx ne kolejny', NULL, NULL, NULL, 'T', 22, '2012-03-27 19:46:31', 'root'),
(23, 'Zapowiedź nr kolejny 17', '2012-03-26 00:00:00', NULL, 'Zajawka pierwszej zapowiedzi dzisiaj Ala ma kota a kot jest idioa tralala Zajawka pierwszej zapowiedzi dzisiaj\n\nZajawka pierwszej zapowiedzi dzisiaj Zajawka pierwszej zapowiedzi dzisiaj Zajawka pierws', 'zapowiedx ne kolejny', NULL, NULL, NULL, 'T', 23, '2012-03-27 19:46:59', 'root'),
(24, 'Zapowiedź 100', '2012-03-31 00:00:00', NULL, ' 100 Adam Mickiewicz był synem Mikołaja Mickiewicza herbu Poraj, adwokata sądowego w Nowogródku i komornika mińskiego oraz Barbary z Majewskich, córki ekonoma z pobliskiego Czombrowa.', '100 Adam Mickiewicz był synem Mikołaja Mickiewicza herbu Poraj, adwokata sądowego w Nowogródku i komornika mińskiego oraz Barbary z Majewskich, córki ekonoma z pobliskiego Czombrowa.\n\nW latach 1807–1815 uczęszczał do dominikańskiej szkoły powiatowej w Nowogródku. W 1812 miały miejsce dwa ważne wydarzenia w jego życiu: 16 maja umarł jego ojciec, a nieco później przez Nowogródek przeszły wojska Napoleona, maszerujące na Moskwę. Miasto Mickiewicza opanowała atmosfera radości i nadziei na koniec niewoli, jednak kilka miesięcy później ta sama Wielka Armia napoleońska wróciła rozbita i pokonana przez Rosjan.\n\nW 1815 Mickiewicz wyjechał do Wilna w celu podjęcia studiów. Studiował nauki humanistyczne na Uniwersytecie Wileńskim – czołowej uczelni dawnego Wielkiego Księstwa Litewskiego. Studia podjął na Wydziale Nauk Fizycznych i Matematycznych, uczęszczając jednocześnie na wykłady Wydziału Nauk Moralnych i Politycznych oraz Literatury i Sztuk Wyzwolonych. Ciężka sytuacja materialna rodziny po śmierci ojca skłoniła go do podjęcia nauki w uniwersyteckim Seminarium Nauczycielskim, co gwarantowało później zatrudnienie w szkołach carskich. Studia ukończył w 1819 ze stopniem magistra[12].\n\nW okresie studiów w październiku 1817 wespół z Tomaszem Zanem i grupą przyjaciół założył towarzystwo Filomatów, organizację na wzór wolnomularski, która z czasem przekształciła się w spiskową organizację narodowo-patriotyczną. Związek Filomatów, nieco później założony związek Filaretów oraz Promieniści służyły organicznej pracy edukacyjno-patriotycznej polskiej młodzieży wileńskiej tamtego okresu. Organizacje te w 1822 roku liczyły już ponad 200 członków[13]. Ich aktywność, cele i coraz wyraźniejsze proniepodległościowe aspiracje nie uszły czujnej uwadze carskich służb policyjnych. Okres końca lat dwudziestych XIX wieku był też świadkiem niespełnionej wielkiej młodzieńczej miłości Mickiewicza do Maryli Wereszczakówny z Tuhanowicz w powiecie nowogródzkim. Młoda Maryla pochodziła z zamożnej i wpły', NULL, NULL, NULL, 'T', 1, '2012-03-30 17:30:35', 'root'),
(25, 'Zapowiedź 101', '2012-03-31 00:00:00', NULL, ' 101 Adam Mickiewicz był synem Mikołaja Mickiewicza herbu Poraj, adwokata sądowego w Nowogródku i komornika mińskiego oraz Barbary z Majewskich, córki ekonoma z pobliskiego Czombrowa.', '101 Adam Mickiewicz był synem Mikołaja Mickiewicza herbu Poraj, adwokata sądowego w Nowogródku i komornika mińskiego oraz Barbary z Majewskich, córki ekonoma z pobliskiego Czombrowa.\n\nW latach 1807–1815 uczęszczał do dominikańskiej szkoły powiatowej w Nowogródku. W 1812 miały miejsce dwa ważne wydarzenia w jego życiu: 16 maja umarł jego ojciec, a nieco później przez Nowogródek przeszły wojska Napoleona, maszerujące na Moskwę. Miasto Mickiewicza opanowała atmosfera radości i nadziei na koniec niewoli, jednak kilka miesięcy później ta sama Wielka Armia napoleońska wróciła rozbita i pokonana przez Rosjan.\n\nW 1815 Mickiewicz wyjechał do Wilna w celu podjęcia studiów. Studiował nauki humanistyczne na Uniwersytecie Wileńskim – czołowej uczelni dawnego Wielkiego Księstwa Litewskiego. Studia podjął na Wydziale Nauk Fizycznych i Matematycznych, uczęszczając jednocześnie na wykłady Wydziału Nauk Moralnych i Politycznych oraz Literatury i Sztuk Wyzwolonych. Ciężka sytuacja materialna rodziny po śmierci ojca skłoniła go do podjęcia nauki w uniwersyteckim Seminarium Nauczycielskim, co gwarantowało później zatrudnienie w szkołach carskich. Studia ukończył w 1819 ze stopniem magistra[12].\n\nW okresie studiów w październiku 1817 wespół z Tomaszem Zanem i grupą przyjaciół założył towarzystwo Filomatów, organizację na wzór wolnomularski, która z czasem przekształciła się w spiskową organizację narodowo-patriotyczną. Związek Filomatów, nieco później założony związek Filaretów oraz Promieniści służyły organicznej pracy edukacyjno-patriotycznej polskiej młodzieży wileńskiej tamtego okresu. Organizacje te w 1822 roku liczyły już ponad 200 członków[13]. Ich aktywność, cele i coraz wyraźniejsze proniepodległościowe aspiracje nie uszły czujnej uwadze carskich służb policyjnych. Okres końca lat dwudziestych XIX wieku był też świadkiem niespełnionej wielkiej młodzieńczej miłości Mickiewicza do Maryli Wereszczakówny z Tuhanowicz w powiecie nowogródzkim. Młoda Maryla pochodziła z zamożnej i wpły', NULL, NULL, NULL, 'T', 2, '2012-03-30 17:30:49', 'root'),
(26, 'Zapowiedź 102', '2012-03-31 00:00:00', NULL, ' 102 Adam Mickiewicz był synem Mikołaja Mickiewicza herbu Poraj, adwokata sądowego w Nowogródku i komornika mińskiego oraz Barbary z Majewskich, córki ekonoma z pobliskiego Czombrowa.', '102 Adam Mickiewicz był synem Mikołaja Mickiewicza herbu Poraj, adwokata sądowego w Nowogródku i komornika mińskiego oraz Barbary z Majewskich, córki ekonoma z pobliskiego Czombrowa.\n\nW latach 1807–1815 uczęszczał do dominikańskiej szkoły powiatowej w Nowogródku. W 1812 miały miejsce dwa ważne wydarzenia w jego życiu: 16 maja umarł jego ojciec, a nieco później przez Nowogródek przeszły wojska Napoleona, maszerujące na Moskwę. Miasto Mickiewicza opanowała atmosfera radości i nadziei na koniec niewoli, jednak kilka miesięcy później ta sama Wielka Armia napoleońska wróciła rozbita i pokonana przez Rosjan.\n\nW 1815 Mickiewicz wyjechał do Wilna w celu podjęcia studiów. Studiował nauki humanistyczne na Uniwersytecie Wileńskim – czołowej uczelni dawnego Wielkiego Księstwa Litewskiego. Studia podjął na Wydziale Nauk Fizycznych i Matematycznych, uczęszczając jednocześnie na wykłady Wydziału Nauk Moralnych i Politycznych oraz Literatury i Sztuk Wyzwolonych. Ciężka sytuacja materialna rodziny po śmierci ojca skłoniła go do podjęcia nauki w uniwersyteckim Seminarium Nauczycielskim, co gwarantowało później zatrudnienie w szkołach carskich. Studia ukończył w 1819 ze stopniem magistra[12].\n\nW okresie studiów w październiku 1817 wespół z Tomaszem Zanem i grupą przyjaciół założył towarzystwo Filomatów, organizację na wzór wolnomularski, która z czasem przekształciła się w spiskową organizację narodowo-patriotyczną. Związek Filomatów, nieco później założony związek Filaretów oraz Promieniści służyły organicznej pracy edukacyjno-patriotycznej polskiej młodzieży wileńskiej tamtego okresu. Organizacje te w 1822 roku liczyły już ponad 200 członków[13]. Ich aktywność, cele i coraz wyraźniejsze proniepodległościowe aspiracje nie uszły czujnej uwadze carskich służb policyjnych. Okres końca lat dwudziestych XIX wieku był też świadkiem niespełnionej wielkiej młodzieńczej miłości Mickiewicza do Maryli Wereszczakówny z Tuhanowicz w powiecie nowogródzkim. Młoda Maryla pochodziła z zamożnej i wpły', NULL, NULL, NULL, 'T', 3, '2012-03-30 17:30:58', 'root'),
(27, 'Zapowiedź 1', '0000-00-00 00:00:00', NULL, 'Pre content zapowiedzi 1', 'Treść zapowiedzi 1', NULL, NULL, NULL, 'T', 2, '2012-03-31 13:05:33', 'root'),
(28, 'Zapowiedź 1', '2012-03-31 13:06:32', NULL, 'Pre content zapowiedzi 1', 'Treść zapowiedzi 1', NULL, NULL, NULL, 'T', 2, '2012-03-31 13:06:22', 'root'),
(29, 'Zapowiedź 1', '2012-04-30 00:00:00', NULL, 'Tralala tralala Ala ma kota a kot jest idiota Ala ma kota a kot jest idiota Ala ma kota a kot jest idiota', 'Treść zapowiedzi 1', NULL, NULL, NULL, 'T', 2, '2012-03-31 13:07:20', 'root'),
(30, 'Zapowiedź 2', '2012-04-29 00:00:00', NULL, 'Tralala tralala Ala ma kota a kot jest idiota Ala ma kota a kot jest idiota Ala ma kota a kot jest idiota', 'Treść zapowiedzi 2', NULL, NULL, NULL, 'T', 3, '2012-03-31 13:08:08', 'root'),
(31, 'Zapowiedź 3', '2012-04-28 00:00:00', NULL, 'Tralala tralala Ala ma kota a kot jest idiota Ala ma kota a kot jest idiota Ala ma kota a kot jest idiota', 'Treść zapowiedzi 3', NULL, NULL, NULL, 'T', 4, '2012-03-31 13:08:23', 'root'),
(32, 'Zapowiedź 4', '2012-04-27 00:00:00', NULL, 'Tralala tralala Ala ma kota a kot jest idiota Ala ma kota a kot jest idiota Ala ma kota a kot jest idiota', 'Treść zapowiedzi 4', NULL, NULL, NULL, 'T', 5, '2012-03-31 13:08:36', 'root');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `information`
--

INSERT INTO `galery` (`id`, `folder_name`, `folder_date`, `folder_content`, `arch_date`, `user`) VALUES
(1, 'Pierwsza galeria', '2012-03-31 13:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mollis luctus scelerisque. Sed rhoncus sapien at purus condimentum tincidunt quis sed erat. Fusce non magna sed justo viverra porta sed rhoncus ante. Suspendisse in sapien sed nisi posuere porta. Donec dignissim, velit quis gravida iaculis, dui purus facilisis ipsum, non eleifend diam tellus posuere lorem. Suspendisse potenti. Etiam libero nulla, sagittis nec pellentesque quis, euismod id risus. Cras elit dui, venenatis sed gravida vel, pulvinar eget eros. Integer consequat rhoncus quam, interdum vehicula turpis ullamcorper at. Vivamus suscipit, erat at pharetra commodo, risus arcu aliquet quam, sit amet pellentesque felis enim id ipsum.', '0000-00-00 00:00:00', 'seta'),
(3, 'Galeria 2', '2012-03-31 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mollis luctus scelerisque. Sed rhoncus sapien at purus condimentum tincidunt quis sed erat. Fusce non magna sed justo viverra porta sed rhoncus ante. Suspendisse in sapien sed nisi posuere porta. Donec dignissim, velit quis gravida iaculis, dui purus facilisis ipsum, non eleifend diam tellus posuere lorem. Suspendisse potenti. Etiam libero nulla, sagittis nec pellentesque quis, euismod id risus. Cras elit dui, venenatis sed gravida vel, pulvinar eget eros. Integer consequat rhoncus quam, interdum vehicula turpis ullamcorper at. Vivamus suscipit, erat at pharetra commodo, risus arcu aliquet quam, sit amet pellentesque felis enim id ipsum.', '2012-03-31 00:00:00', 'seta'),
(4, 'Galeria 3', '2012-03-31 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mollis luctus scelerisque. Sed rhoncus sapien at purus condimentum tincidunt quis sed erat. Fusce non magna sed justo viverra porta sed rhoncus ante. Suspendisse in sapien sed nisi posuere porta. Donec dignissim, velit quis gravida iaculis, dui purus facilisis ipsum, non eleifend diam tellus posuere lorem. Suspendisse potenti. Etiam libero nulla, sagittis nec pellentesque quis, euismod id risus. Cras elit dui, venenatis sed gravida vel, pulvinar eget eros. Integer consequat rhoncus quam, interdum vehicula turpis ullamcorper at. Vivamus suscipit, erat at pharetra commodo, risus arcu aliquet quam, sit amet pellentesque felis enim id ipsum.', '2012-03-31 00:00:00', 'seta');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `content` varchar(2000) COLLATE utf8_polish_ci NOT NULL,
  `picture_id` int(10) DEFAULT NULL,
  `arch_date` datetime NOT NULL,
  `user` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=5 ;

--
-- Zrzut danych tabeli `information`
--

INSERT INTO `information` (`id`, `type`, `content`, `picture_id`, `arch_date`, `user`) VALUES
(1, 'HOME', 'BUFFET to nowe miejsce na Stoczni Gdańskiej. W postindustrialnych przestrzeniach IS Wyspa inicjowane będą działania oferujące alternatywe ludziom nie zainteresowanym komercyjnym nurtem. Przestrzeń Klubu Buffet jest otwarta dla ludzi pragnących promować ambitne projekty artystyczne. Wspieramy niezależne, nowatorskie formy wyrazu. Muzykę na wysokim poziomie bez względu na gatunek. Ludzi, którzy mają coś ciekawego do przekazania.\r\n\r\nBUFFET to nowe miejsce na Stoczni Gdańskiej. W postindustrialnych przestrzeniach IS Wyspa inicjowane będą działania oferujące alternatywe ludziom nie zainteresowanym komercyjnym nurtem. Przestrzeń Klubu Buffet jest otwarta dla ludzi pragnących promować ambitne projekty artystyczne. Wspieramy niezależne, nowatorskie formy wyrazu. Muzykę na wysokim poziomie bez względu na gatunek. Ludzi, którzy mają coś ciekawego do przekazania.', NULL, '2012-03-18 23:00:38', 'root'),
(2, 'KONTAKT', 'Kontakt z klubem Buffet:\ntel. 58 666-00-11\ne-mail: info@buffet.pl', NULL, '2012-03-21 00:11:17', 'root'),
(3, 'OFERTA', 'OFERTA OFERTA\nBUFFET to nowe miejsce na Stoczni Gdańskiej. W postindustrialnych przestrzeniach IS Wyspa inicjowane będą działania oferujące alternatywe ludziom nie zainteresowanym komercyjnym nurtem. Przestrzeń Klubu Buffet jest otwarta dla ludzi pragnących promować ambitne projekty artystyczne. Wspieramy niezależne, nowatorskie formy wyrazu. Muzykę na wysokim poziomie bez względu na gatunek. Ludzi, którzy mają coś ciekawego do przekazania.\n\nWSTĘP POWYŻEJ 20 ROKU ŻYCIA\nBUFFET to nowe miejsce na Stoczni Gdańskiej. W postindustrialnych przestrzeniach IS Wyspa inicjowane będą działania oferujące alternatywe ludziom nie zainteresowanym komercyjnym nurtem. Przestrzeń Klubu Buffet jest otwarta dla ludzi pragnących promować ambitne projekty artystyczne. Wspieramy niezależne, nowatorskie formy wyrazu. Muzykę na wysokim poziomie bez względu na gatunek. Ludzi, którzy mają coś ciekawego do przekazania.\n\nWSTĘP POWYŻEJ 20 ROKU ŻYCIA.\nOFERTA OFERTA', NULL, '2012-03-27 00:14:15', 'root'),
(4, 'KARTA', 'To jest treść podstrony "karta". Co by tu jeszcze napisać. Moze znowu coś o Adamie Mickiewczu. Adam Mickiewicz był synem Mikołaja Mickiewicza herbu Poraj, adwokata sądowego w Nowogródku i komornika mińskiego oraz Barbary z Majewskich, córki ekonoma z pobliskiego Czombrowa.\n\nW latach 1807–1815 uczęszczał do dominikańskiej szkoły powiatowej w Nowogródku. W 1812 miały miejsce dwa ważne wydarzenia w jego życiu: 16 maja umarł jego ojciec, a nieco później przez Nowogródek przeszły wojska Napoleona, maszerujące na Moskwę. Miasto Mickiewicza opanowała atmosfera radości i nadziei na koniec niewoli, jednak kilka miesięcy później ta sama Wielka Armia napoleońska wróciła rozbita i pokonana przez Rosjan.\n\nW 1815 Mickiewicz wyjechał do Wilna w celu podjęcia studiów. Studiował nauki humanistyczne na Uniwersytecie Wileńskim – czołowej uczelni dawnego Wielkiego Księstwa Litewskiego. Studia podjął na Wydziale Nauk Fizycznych i Matematycznych, uczęszczając jednocześnie na wykłady Wydziału Nauk Moralnych i Politycznych oraz Literatury i Sztuk Wyzwolonych. Ciężka sytuacja materialna rodziny po śmierci ojca skłoniła go do podjęcia nauki w uniwersyteckim Seminarium Nauczycielskim, co gwarantowało później zatrudnienie w szkołach carskich. Studia ukończył w 1819 ze stopniem magistra[12].\n\nW okresie studiów w październiku 1817 wespół z Tomaszem Zanem i grupą przyjaciół założył towarzystwo Filomatów, organizację na wzór wolnomularski, która z czasem przekształciła się w spiskową organizację narodowo-patriotyczną. Związek Filomatów, nieco później założony związek Filaretów oraz Promieniści służyły organicznej pracy edukacyjno-patriotycznej polskiej młodzieży wileńskiej tamtego okresu. Organizacje te w 1822 roku liczyły już ponad 200 członków[13]. Ich aktywność, cele i coraz wyraźniejsze proniepodległościowe aspiracje nie uszły czujnej uwadze carskich służb policyjnych. Okres końca lat dwudziestych XIX wieku był też świadkiem niespełnionej wielkiej młodzieńczej miłości Mickiewicza do Maryli Wer', 6, '2012-04-01 01:58:27', 'root');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `information_view`
--
CREATE TABLE IF NOT EXISTS `information_view` (
`id` int(10)
,`type` varchar(50)
,`content` varchar(2000)
,`picture_id` int(10)
,`arch_date` datetime
,`user` varchar(30)
,`picture_name` varchar(200)
);
-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `news`
--
CREATE TABLE IF NOT EXISTS `news` (
`id` int(10)
,`title` varchar(50)
,`date_from` datetime
,`date_to` datetime
,`pre_content_pl` char(200)
,`content_pl` varchar(2000)
,`pre_content_en` varchar(100)
,`content_en` varchar(2000)
,`event_news` varchar(1)
,`event_announcement` varchar(1)
,`picture_id` int(10)
,`arch_date` datetime
,`user` varchar(30)
,`picture_name` varchar(200)
);
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
  `arch_date` datetime NOT NULL,
  `user` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `link` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=36 ;

--
-- Zrzut danych tabeli `picture`
--

INSERT INTO `picture` (`id`, `name`, `information`, `main_picture`, `gallery_id`, `arch_date`, `user`, `link`) VALUES
(1, '/pictures/wiosna.jpg', 'MAIN', NULL, NULL, '2012-03-25 22:51:14', 'root', NULL),
(2, '/pictures/wiosna2.jpg', 'MAIN', NULL, NULL, '2012-03-27 00:28:42', 'root', NULL),
(3, '/pictures/wiosna3.jpg', 'MAIN', NULL, NULL, '2012-03-27 22:05:25', 'root', NULL),
(4, '/pictures/wiosna4.jpg', 'MAIN', NULL, NULL, '2012-03-27 22:05:32', 'root', NULL),
(5, '/pictures/wiosna5.jpg', NULL, NULL, NULL, '2012-03-27 22:05:37', 'root', NULL),
(6, '/pictures/wiosna6.jpg', NULL, NULL, NULL, '2012-03-27 22:05:43', 'root', NULL),
(7, '/pictures/wiosna7.jpg', NULL, NULL, NULL, '2012-03-27 22:05:49', 'root', NULL),
(8, '/pictures/wiosna8.jpg', NULL, NULL, NULL, '2012-03-27 22:10:27', 'root', NULL),
(9, '/pictures/wiosna9.jpg', NULL, NULL, NULL, '2012-03-27 22:10:27', 'root', NULL),
(10, '/pictures/wiosna10.jpg', NULL, NULL, NULL, '2012-03-27 22:10:28', 'root', NULL),
(11, '/pictures/wiosna11.jpg', NULL, NULL, NULL, '2012-03-27 22:11:02', 'root', NULL),
(12, '/pictures/wiosna12.jpg', NULL, NULL, NULL, '2012-03-27 22:11:03', 'root', NULL),
(13, '/pictures/wiosna11.jpg', NULL, NULL, NULL, '2012-03-27 22:11:23', 'root', NULL),
(14, '/pictures/wiosna12.jpg', NULL, NULL, NULL, '2012-03-27 22:11:24', 'root', NULL),
(15, '/pictures/wiosna13.jpg', NULL, NULL, NULL, '2012-03-27 22:11:24', 'root', NULL),
(16, '/pictures/wiosna14.jpg', NULL, NULL, NULL, '2012-03-27 22:12:13', 'root', NULL),
(17, '/pictures/wiosna15.jpg', NULL, NULL, NULL, '2012-03-27 22:12:13', 'root', NULL),
(18, '/pictures/wiosna16.jpg', NULL, NULL, NULL, '2012-03-27 22:12:13', 'root', NULL),
(19, '/pictures/wiosna17.jpg', NULL, NULL, NULL, '2012-03-27 22:12:13', 'root', NULL),
(20, '/pictures/wiosna18.jpg', NULL, NULL, NULL, '2012-03-27 22:12:13', 'root', NULL),
(21, '/pictures/wiosna19.jpg', NULL, NULL, NULL, '2012-03-27 22:12:13', 'root', NULL),
(22, '/pictures/wiosna20.jpg', NULL, NULL, NULL, '2012-03-27 22:12:13', 'root', NULL),
(23, '/pictures/wiosna21.jpg', NULL, NULL, NULL, '2012-03-27 22:12:14', 'root', NULL),
(24, '/pictures/wiosna22.jpg', NULL, NULL, NULL, '2012-03-27 22:12:14', 'root', NULL),
(25, '/pictures/partners/wp.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:26:16', 'root', 'http://www.wp.pl'),
(26, '/pictures/partners/onet.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:26:34', 'root', 'http://www.onet.pl'),
(27, '/pictures/partners/reszel.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:26:52', 'root', 'http://www.reszel.pl'),
(28, '/pictures/partners/interia.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:27:13', 'root', 'http://www.interia.pl'),
(29, '/pictures/partners/trojmiasto.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:27:34', 'root', 'http://www.trojmiasto.pl'),
(30, '/pictures/partners/otago.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:27:46', 'root', 'http://www.otago.pl'),
(31, '/pictures/partners/facebook.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:28:35', 'root', 'http://www.facebook.pl'),
(32, '/pictures/partners/facebook.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:31:24', 'root', 'http://www.facebook.pl'),
(33, '/pictures/partners/mbank.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:32:21', 'root', 'http://www.mbank.pl'),
(34, '/pictures/partners/youtube.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:32:45', 'root', 'http://www.youtube.pl'),
(35, '/pictures/partners/o2.jpg', 'PARTNERS', NULL, NULL, '2012-04-01 12:33:01', 'root', 'http://www.o2.pl'),
(36, '/galleries/1/photo1.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(37, '/galleries/1/photo2.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(38, '/galleries/1/photo3.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(39, '/galleries/1/photo4.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(40, '/galleries/1/photo5.jpg', NULL, 'Y', 1, '2012-03-31 00:00:00', 'seta', NULL),
(41, '/galleries/1/photo6.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(42, '/galleries/1/photo7.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(43, '/galleries/1/photo8.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(44, '/galleries/1/photo9.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(45, '/galleries/1/photo10.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(46, '/galleries/1/photo11.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(47, '/galleries/1/photo12.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(48, '/galleries/1/photo13.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(49, '/galleries/1/photo14.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(50, '/galleries/1/photo15.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(51, '/galleries/1/photo16.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(52, '/galleries/1/photo17.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(53, '/galleries/1/photo18.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(54, '/galleries/1/photo19.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(55, '/galleries/1/photo20.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(56, '/galleries/1/photo21.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(57, '/galleries/1/photo22.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL),
(58, '/galleries/1/photo23.jpg', NULL, NULL, 1, '2012-03-31 00:00:00', 'seta', NULL);


-- --------------------------------------------------------

--
-- Struktura widoku `announcement`
--
DROP TABLE IF EXISTS `announcement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `announcement` AS select `e`.`id` AS `id`,`e`.`title` AS `title`,`e`.`date_from` AS `date_from`,`e`.`date_to` AS `date_to`,`e`.`pre_content_pl` AS `pre_content_pl`,`e`.`content_pl` AS `content_pl`,`e`.`pre_content_en` AS `pre_content_en`,`e`.`content_en` AS `content_en`,`e`.`event_news` AS `event_news`,`e`.`event_announcement` AS `event_announcement`,`e`.`picture_id` AS `picture_id`,`e`.`arch_date` AS `arch_date`,`e`.`user` AS `user`,`p`.`name` AS `picture_name` from (`event` `e` left join `picture` `p` on((`p`.`id` = `e`.`picture_id`))) where ((`e`.`event_announcement` = 'T') and (((`e`.`date_to` is not null) and (`e`.`date_to` >= now())) or (isnull(`e`.`date_to`) and (`e`.`date_from` >= now()))));

-- --------------------------------------------------------

--
-- Struktura widoku `archive`
--
DROP TABLE IF EXISTS `archive`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `archive` AS select `e`.`id` AS `id`,`e`.`title` AS `title`,`e`.`date_from` AS `date_from`,`e`.`date_to` AS `date_to`,`e`.`pre_content_pl` AS `pre_content_pl`,`e`.`content_pl` AS `content_pl`,`e`.`pre_content_en` AS `pre_content_en`,`e`.`content_en` AS `content_en`,`e`.`event_news` AS `event_news`,`e`.`event_announcement` AS `event_announcement`,`e`.`picture_id` AS `picture_id`,`e`.`arch_date` AS `arch_date`,`e`.`user` AS `user`,`p`.`name` AS `picture_name` from (`event` `e` left join `picture` `p` on((`p`.`id` = `e`.`picture_id`))) where ((`e`.`event_announcement` = 'T') and (((`e`.`date_to` is not null) and (`e`.`date_to` < now())) or (isnull(`e`.`date_to`) and (`e`.`date_from` < now()))));

-- --------------------------------------------------------

--
-- Struktura widoku `information_view`
--
DROP TABLE IF EXISTS `information_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `information_view` AS select `i`.`id` AS `id`,`i`.`type` AS `type`,`i`.`content` AS `content`,`i`.`picture_id` AS `picture_id`,`i`.`arch_date` AS `arch_date`,`i`.`user` AS `user`,`p`.`name` AS `picture_name` from (`information` `i` left join `picture` `p` on((`p`.`id` = `i`.`picture_id`)));

-- --------------------------------------------------------

--
-- Struktura widoku `news`
--
DROP TABLE IF EXISTS `news`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `news` AS select `e`.`id` AS `id`,`e`.`title` AS `title`,`e`.`date_from` AS `date_from`,`e`.`date_to` AS `date_to`,`e`.`pre_content_pl` AS `pre_content_pl`,`e`.`content_pl` AS `content_pl`,`e`.`pre_content_en` AS `pre_content_en`,`e`.`content_en` AS `content_en`,`e`.`event_news` AS `event_news`,`e`.`event_announcement` AS `event_announcement`,`e`.`picture_id` AS `picture_id`,`e`.`arch_date` AS `arch_date`,`e`.`user` AS `user`,`p`.`name` AS `picture_name` from (`event` `e` left join `picture` `p` on((`p`.`id` = `e`.`picture_id`))) where (`e`.`event_news` = 'T');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
