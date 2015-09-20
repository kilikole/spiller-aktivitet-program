-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2015 at 11:16 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `spillerbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitet`
--

CREATE TABLE IF NOT EXISTS `aktivitet` (
`aktivid` int(11) NOT NULL,
  `adato` date NOT NULL DEFAULT '0000-00-00',
  `klokke` time NOT NULL,
  `atype` varchar(255) NOT NULL DEFAULT '',
  `commenta` text NOT NULL,
  `alag` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aktivitet`
--

INSERT INTO `aktivitet` (`aktivid`, `adato`, `klokke`, `atype`, `commenta`, `alag`) VALUES
(2, '2015-01-11', '00:00:00', 'Trening', 'kan legge til kommentar pÃ¥ aktiviteten', 1),
(4, '2015-01-22', '00:00:00', 'Kamp', 'her stÃ¥r noe om aktiviteten', 2),
(6, '2015-01-10', '00:00:00', 'Trening', '', 2),
(7, '2011-01-30', '00:00:00', 'Trening', '', 4),
(8, '2015-01-11', '00:00:00', 'Kamp', '', 3),
(13, '1969-04-30', '00:00:00', 'Kamp', 'Kommentar til kampen. Blablabblalaa.. ', 1),
(15, '2015-02-20', '00:00:00', 'Trening', '', 4),
(20, '2015-12-01', '00:00:00', 'Kamp', 'sdldlsdflsdf', 2),
(31, '2015-02-12', '00:00:00', 'Kamp', '', 1),
(32, '2015-02-19', '00:00:00', 'Kamp', '', 1),
(34, '2015-02-19', '00:00:00', 'Kamp', '', 2),
(37, '2015-02-20', '00:00:00', 'Kamp', '', 2),
(38, '2015-02-09', '00:00:00', 'Kamp', 'mandag den 9. for g15', 2),
(39, '2015-02-10', '00:00:00', 'Trening', 'trening tirsdag', 2),
(40, '2015-02-25', '00:00:00', 'MÃ¸te', 'jkjjk', 2),
(42, '2015-02-12', '00:00:00', 'Kamp', '', 1),
(44, '2015-02-02', '00:00:00', 'Trening', '', 2),
(47, '2015-02-10', '00:00:00', 'Kamp', '', 1),
(61, '2015-02-25', '00:00:00', 'Kamp', '', 2),
(68, '2015-02-11', '00:00:00', 'Trening', 'kan da foreta notater her', 20),
(74, '2015-02-09', '00:00:00', 'Trening', 'FÃ¸rste trening.', 39),
(75, '2015-02-21', '00:00:00', 'Kamp', 'FÃ¸rste kamp.', 39),
(76, '2015-02-21', '00:00:00', 'MÃ¸te', 'SpillermÃ¸te fÃ¸r kampen.', 39),
(77, '2015-02-16', '00:00:00', 'Trening', 'Trening nr. 2', 39),
(81, '2015-02-13', '16:00:00', 'Kamp', 'test tid', 30),
(82, '2015-02-20', '17:00:00', 'Trening', 'test insert', 30),
(83, '2015-04-14', '18:00:00', 'Kamp', 'test kl. 18.00', 30),
(84, '2015-02-21', '19:00:00', 'Kamp', '', 30),
(85, '2015-02-20', '09:00:00', 'Kamp', 'kamp1', 30);

-- --------------------------------------------------------

--
-- Table structure for table `deltagere`
--

CREATE TABLE IF NOT EXISTS `deltagere` (
`id` int(11) NOT NULL,
  `navn` text NOT NULL,
  `etternavn` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `adresse` varchar(80) NOT NULL,
  `telefon` varchar(40) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `lagid` int(4) DEFAULT NULL,
  `commentd` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=269 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deltagere`
--

INSERT INTO `deltagere` (`id`, `navn`, `etternavn`, `email`, `adresse`, `telefon`, `type`, `lagid`, `commentd`) VALUES
(253, 'Gunnar', 'Pedersen', 'nilsarne', 'sdklsdfl vei  15', '4565656', 'Spiller', 30, 'ghghgh324fgfg!'),
(255, 'Nils Arne', 'Eggen', 'nilsarne@rosenborg.no', 'KlÃ¦buveien 14', '999999999', 'Trener', 30, 'Bra trener.'),
(261, 'Arne', 'Berg', 'arneberg', 'arneveien', '23934', 'Spiller', 30, 'dfdfdf'),
(262, 'Per', 'Borten', 'perborten', 'arneveien', '23934', 'Spiller', 30, 'dfdfdf'),
(263, 'Knut', 'Knudsen', 'knutknudsen', 'knutveien 5', '123156', 'Spiller', 30, 'dfdfdf'),
(264, 'Odd', 'Iversen', 'ivers', 'rivsollan', '66666', 'Spiller', 30, 'legende'),
(265, 'Perry', 'Hansen', 'perhansen', 'stjÃ¸rdal', '32893434', 'Trener', 30, ''),
(266, 'Mini', 'Jakobsen', 'minitv2', 'nordland', '54564654', 'Spiller', 30, 'liten'),
(267, 'Sverre', 'Brandhaug', 'svrbrand', 'trondheim', '233423435', 'Spiller', 30, ''),
(268, 'Gunnar', 'Kvalhaug', 'sddfslsdf', 'DFDFL', '322343', 'Spiller', 30, '');

-- --------------------------------------------------------

--
-- Table structure for table `lag`
--

CREATE TABLE IF NOT EXISTS `lag` (
`lagid` int(11) NOT NULL,
  `lagnavn` varchar(255) NOT NULL DEFAULT '',
  `kjoenn` varchar(10) NOT NULL,
  `alder` int(3) NOT NULL,
  `commentl` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lag`
--

INSERT INTO `lag` (`lagid`, `lagnavn`, `kjoenn`, `alder`, `commentl`) VALUES
(1, 'G14', 'Gutter', 14, 'ssdffddffddfsdfdsgsgsdgsdsdg'),
(2, 'G15', 'Gutter', 15, ''),
(3, 'G16', 'Gutter', 16, ''),
(4, 'G17', 'Gutter', 17, ''),
(7, 'J12', 'Jenter', 12, ''),
(8, 'J15', 'Jenter', 15, ''),
(10, 'J17', 'Jenter', 17, ''),
(12, 'J16', 'Jenter', 16, ''),
(20, 'G12', 'Gutter', 12, ''),
(26, 'J11', 'Jenter', 11, ''),
(30, 'G10', 'Gutter', 10, 'test pÃ¥ g10'),
(32, 'G9', 'Gutter', 9, 'fskdlfklsdfklsdfldsf'),
(33, 'G55', 'Gutter', 55, 'testgreier'),
(39, 'TestG14', 'Gutter', 14, 'Her er en test av G14. Oppdat 2.'),
(40, 'Test', 'Gutter', 17, 'slettest');

-- --------------------------------------------------------

--
-- Table structure for table `opp`
--

CREATE TABLE IF NOT EXISTS `opp` (
  `oppid` int(10) NOT NULL,
  `aktivid` int(5) NOT NULL,
  `navnid` int(5) NOT NULL,
  `tilstede` varchar(30) NOT NULL,
  `tilgjengelig` varchar(30) NOT NULL,
  `kommentaro` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `opp`
--

INSERT INTO `opp` (`oppid`, `aktivid`, `navnid`, `tilstede`, `tilgjengelig`, `kommentaro`) VALUES
(21, 2, 1, 'Ikkesatt', 'Nei', 'kommentarer'),
(27, 2, 7, 'Ikkesatt', 'Nei', 'kommentarer'),
(131, 13, 1, 'Ikkesatt', 'Nei', 'kommentarer'),
(137, 13, 7, 'Ikkesatt', 'Nei', 'kommentarer'),
(181, 18, 1, 'Nei', 'Nei', 'kommentarer'),
(187, 18, 7, 'Nei', 'Nei', 'kommentarer'),
(321, 32, 1, 'Ikkesatt', 'Nei', 'kommentarer'),
(327, 32, 7, 'Ikkesatt', 'Nei', 'kommentarer'),
(411, 4, 11, 'Ikkesatt', 'Nei', 'kommentarer'),
(511, 5, 11, 'Ja', '', 'kommentarer'),
(611, 6, 11, 'Ja', 'Ja', 'kommentarer'),
(2111, 21, 11, 'Nei', '', 'kommentarer'),
(2205, 2, 205, 'Ikkesatt', 'Nei', 'kommentarer'),
(2207, 2, 207, 'Ikkesatt', 'Nei', 'kommentarer'),
(2208, 2, 208, 'Ikkesatt', 'Nei', 'kommentarer'),
(2210, 2, 210, 'Ikkesatt', 'Nei', 'kommentarer'),
(4183, 4, 183, 'Ikkesatt', 'Nei', 'kommentarer'),
(4193, 4, 193, 'Ikkesatt', 'Nei', 'kommentarer'),
(4194, 4, 194, 'Ikkesatt', 'Nei', 'kommentarer'),
(4195, 4, 195, 'Ikkesatt', 'Nei', 'kommentarer'),
(4196, 4, 196, 'Ikkesatt', 'Nei', 'kommentarer'),
(4197, 4, 197, 'Ikkesatt', 'Nei', 'kommentarer'),
(4200, 4, 200, 'Ikkesatt', 'Nei', 'kommentarer'),
(5169, 5, 169, 'Nei', '', 'kommentarer'),
(5182, 5, 182, 'Nei', '', 'kommentarer'),
(5183, 5, 183, 'Nei', '', 'kommentarer'),
(5185, 5, 185, 'Nei', '', 'kommentarer'),
(6183, 6, 183, 'Ja', 'Ja', 'kommentarer'),
(6193, 6, 193, 'Nei', 'Ja', 'kommentarer'),
(6194, 6, 194, 'Ikkesatt', 'Nei', 'kommentarer'),
(6195, 6, 195, 'Ikkesatt', 'Nei', 'kommentarer'),
(6196, 6, 196, 'Nei', 'Ja', 'kommentarer'),
(6197, 6, 197, 'Ikkesatt', 'Nei', 'kommentarer'),
(6200, 6, 200, 'Ja', 'Ja', 'kommentarer'),
(6206, 6, 206, 'Ja', 'Ja', 'kommentarer'),
(6212, 6, 212, 'Ikkesatt', 'Nei', 'kommentarer'),
(7173, 7, 173, 'Ikkesatt', 'Nei', 'kommentarer'),
(7186, 7, 186, 'Nei', '', 'kommentarer'),
(8165, 8, 165, 'Ikkesatt', 'Nei', 'kommentarer'),
(8174, 8, 174, 'Ja', '', 'kommentarer'),
(8187, 8, 187, 'Ja', '', 'kommentarer'),
(8188, 8, 188, 'Ja', '', 'kommentarer'),
(8190, 8, 190, 'Ikkesatt', 'Nei', 'kommentarer'),
(13205, 13, 205, 'Ikkesatt', 'Nei', 'kommentarer'),
(13207, 13, 207, 'Ikkesatt', 'Nei', 'kommentarer'),
(13208, 13, 208, 'Ikkesatt', 'Nei', 'kommentarer'),
(13210, 13, 210, 'Ikkesatt', 'Nei', 'kommentarer'),
(15173, 15, 173, 'Nei', '', 'kommentarer'),
(15186, 15, 186, 'Nei', '', 'kommentarer'),
(21183, 21, 183, 'Nei', '', 'kommentarer'),
(68204, 68, 204, 'Ikkesatt', 'Ja', 'kommentarer'),
(74220, 74, 220, 'Ja', 'Ja', 'kommentarer'),
(74221, 74, 221, 'Nei', 'Ja', 'kommentarer'),
(74222, 74, 222, 'Nei', 'Ja', 'kommentarer'),
(74223, 74, 223, 'Ja', 'Ja', 'kommentarer'),
(74224, 74, 224, 'Nei', 'Ja', 'kommentarer'),
(74225, 74, 225, 'Nei', 'Ja', 'kommentarer'),
(74226, 74, 226, 'Ikkesatt', 'Nei', 'kommentarer'),
(74227, 74, 227, 'Ja', 'Ja', 'kommentarer'),
(75220, 75, 220, 'Ikkesatt', 'Ja', 'kommentarer'),
(75221, 75, 221, 'Ikkesatt', 'Ja', 'kommentarer'),
(75222, 75, 222, 'Ikkesatt', 'Nei', 'kommentarer'),
(75223, 75, 223, 'Ikkesatt', 'Ja', 'kommentarer'),
(75224, 75, 224, 'Ikkesatt', 'Nei', 'kommentarer'),
(75225, 75, 225, 'Ikkesatt', 'Nei', 'kommentarer'),
(75226, 75, 226, 'Ikkesatt', 'Ja', 'kommentarer'),
(75227, 75, 227, 'Ikkesatt', 'Ja', 'kommentarer'),
(76220, 76, 220, 'Ikkesatt', '', 'kommentarer'),
(76221, 76, 221, 'Ikkesatt', '', 'kommentarer'),
(76222, 76, 222, 'Ikkesatt', '', 'kommentarer'),
(76223, 76, 223, 'Ikkesatt', '', 'kommentarer'),
(76224, 76, 224, 'Ikkesatt', '', 'kommentarer'),
(76225, 76, 225, 'Ikkesatt', '', 'kommentarer'),
(76226, 76, 226, 'Ikkesatt', '', 'kommentarer'),
(76227, 76, 227, 'Ikkesatt', '', 'kommentarer'),
(77220, 77, 220, 'Ikkesatt', 'Ja', 'kommentarer'),
(77221, 77, 221, 'Ikkesatt', 'Ja', 'kommentarer'),
(77222, 77, 222, 'Ikkesatt', 'Ja', 'kommentarer'),
(77223, 77, 223, 'Ikkesatt', 'Ja', 'kommentarer'),
(77224, 77, 224, 'Ikkesatt', 'Ja', 'kommentarer'),
(77225, 77, 225, 'Ikkesatt', 'Ja', 'kommentarer'),
(77226, 77, 226, 'Ikkesatt', 'Ja', 'kommentarer'),
(77227, 77, 227, 'Ikkesatt', 'Ja', 'kommentarer'),
(79253, 79, 253, 'Ikkesatt', '', 'kommentarer'),
(79255, 79, 255, 'Ikkesatt', '', 'kommentarer'),
(81253, 81, 253, 'Ja', 'Ja', 'kommentarer'),
(81255, 81, 255, 'Nei', 'Ja', 'kommentarer'),
(81261, 81, 261, 'Nei', 'Ja', 'kommentarer'),
(81262, 81, 262, 'Ja', 'Ja', 'kommentarer'),
(81263, 81, 263, 'Ikkesatt', 'Nei', 'kommentarer'),
(81264, 81, 264, 'Nei', 'Ja', 'kommentarer'),
(81265, 81, 265, 'Ja', 'Ja', 'kommentarer-edit'),
(81266, 81, 266, 'Nei', 'Ja', 'kommentarer'),
(81267, 81, 267, 'Ja', 'Ja', 'kommentarer'),
(81268, 81, 268, 'Nei', 'Ja', 'kommentarer'),
(82253, 82, 253, 'Ikkesatt', '', 'kommentarer'),
(82255, 82, 255, 'Ikkesatt', '', 'kommentarer'),
(84253, 84, 253, 'Ja', 'Ja', 'kommentarer'),
(84255, 84, 255, 'Nei', 'Ja', 'kommentarer'),
(84261, 84, 261, 'Nei', 'Ja', 'kommentarer'),
(84262, 84, 262, 'Ja', 'Ja', 'kommentarer'),
(84263, 84, 263, 'Nei', 'Ja', 'kommentarer'),
(84264, 84, 264, 'Ikkesatt', 'Nei', 'kommentarer'),
(84265, 84, 265, 'Ikkesatt', 'Nei', 'kommentarer'),
(84266, 84, 266, 'Ja', 'Ja', 'kommentarer'),
(84267, 84, 267, 'Ja', 'Ja', 'kommentarer'),
(84268, 84, 268, 'Nei', 'Ja', 'kommentarer'),
(85253, 85, 253, 'Ja', 'Ja', '10/10'),
(85255, 85, 255, 'Nei', 'Ja', 'kommentarer'),
(85261, 85, 261, 'Ja', 'Ja', 'kommentarer'),
(85262, 85, 262, 'Nei', 'Ja', 'kommentarer'),
(85263, 85, 263, 'Ja', 'Ja', 'kommentarer'),
(85264, 85, 264, 'Nei', 'Ja', 'kommentarer'),
(85265, 85, 265, 'Ja', 'Ja', 'kommentarer'),
(85266, 85, 266, 'Nei', 'Ja', 'kommentarer'),
(85267, 85, 267, 'Ikkesatt', 'Nei', 'kommentarer'),
(85268, 85, 268, 'Ikkesatt', 'Nei', 'kommentarer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitet`
--
ALTER TABLE `aktivitet`
 ADD PRIMARY KEY (`aktivid`);

--
-- Indexes for table `deltagere`
--
ALTER TABLE `deltagere`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lag`
--
ALTER TABLE `lag`
 ADD PRIMARY KEY (`lagid`), ADD UNIQUE KEY `lagnavn` (`lagnavn`);

--
-- Indexes for table `opp`
--
ALTER TABLE `opp`
 ADD PRIMARY KEY (`oppid`), ADD UNIQUE KEY `oppid` (`oppid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitet`
--
ALTER TABLE `aktivitet`
MODIFY `aktivid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `deltagere`
--
ALTER TABLE `deltagere`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=269;
--
-- AUTO_INCREMENT for table `lag`
--
ALTER TABLE `lag`
MODIFY `lagid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
