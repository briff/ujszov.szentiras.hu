-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 20, 2011 at 09:28 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny13
-- 
-- Database: `ujszov`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `konyvek`
-- 

CREATE TABLE `konyvek` (
  `lh` varchar(15) default NULL,
  `fh` int(8) NOT NULL default '0',
  `fkh` int(8) default NULL,
  `feh` int(8) default NULL,
  `unic` varchar(255) default NULL,
  `grae` varchar(255) default NULL,
  `rk` varchar(255) default NULL,
  `ef` int(6) default NULL,
  `lj` text,
  `mj` varchar(255) default NULL,
  `szf` varchar(255) default NULL,
  `elem` varchar(255) default NULL,
  `bk` int(6) default NULL,
  `felelos` int(1) default NULL,
  `gk` int(7) default NULL,
  `szal` varchar(255) default NULL,
  `hj` int(1) NOT NULL default '0',
  PRIMARY KEY  (`fh`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `konyvhossz`
-- 

CREATE TABLE `konyvhossz` (
  `konyv_id` tinyint(3) unsigned NOT NULL default '0',
  `hossz` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`konyv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `konyvhossz`
-- 

INSERT INTO `konyvhossz` (`konyv_id`, `hossz`) VALUES (1, 28),
(2, 16),
(3, 24),
(4, 21),
(5, 28),
(6, 16),
(7, 16),
(8, 13),
(9, 6),
(10, 6),
(11, 4),
(12, 4),
(13, 5),
(14, 3),
(15, 6),
(16, 4),
(17, 3),
(18, 1),
(19, 13),
(20, 5),
(21, 5),
(22, 3),
(23, 5),
(24, 1),
(25, 1),
(26, 1),
(27, 22);


-- --------------------------------------------------------

-- 
-- Table structure for table `konyvnevek`
-- 

CREATE TABLE `konyvnevek` (
  `nev` varchar(10) NOT NULL default '',
  `konyv_id` tinyint(3) unsigned NOT NULL default '0',
  `tipus` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`nev`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 
-- Dumping data for table `konyvnevek`
-- 

INSERT INTO `konyvnevek` (`nev`, `konyv_id`, `tipus`) VALUES ('Mt', 1, 'default'),
('Mk', 2, 'default'),
('Lk', 3, 'default'),
('Jn', 4, 'default'),
('Acs', 5, 'default'),
('Róm', 6, 'default'),
('1Kor', 7, 'default'),
('2Kor', 8, 'default'),
('Gal', 9, 'default'),
('Ef', 10, 'default'),
('Fil', 11, 'default'),
('Kol', 12, 'default'),
('1Tessz', 13, 'default'),
('2Tessz', 14, 'default'),
('1Tim', 15, 'default'),
('2Tim', 16, 'default'),
('Tit', 17, 'default'),
('Filem', 18, 'default'),
('Zsid', 19, 'default'),
('Jak', 20, 'default'),
('1Pt', 21, 'default'),
('2Pt', 22, 'default'),
('1Jn', 23, 'default'),
('2Jn', 24, 'default'),
('3Jn', 25, 'default'),
('Júd', 26, 'default'),
('Jel', 27, 'default'),
('2Thes', 14, 'szomutato'),
('1Thes', 13, 'szomutato'),
('2Thessz', 14, 'ujprotestans'),
('1Thessz', 13, 'ujprotestans'),
('2Thess', 14, 'karoli'),
('1Thess', 13, 'karoli'),
('Eféz', 10, 'karoli'),
('Ján', 4, 'karoli'),
('Luk', 3, 'karoli'),
('Márk', 2, 'karoli'),
('Mát', 1, 'karoli'),
('2Tesz', 14, 'istvan'),
('1Tesz', 13, 'istvan'),
('ApCsel', 5, 'istvan'),
('3Ján', 25, 'jeromos'),
('2Ján', 24, 'jeromos'),
('1Ján', 23, 'jeromos'),
('2Pét', 22, 'jeromos'),
('1Pét', 21, 'jeromos'),
('Csel', 5, 'jeromos');

-- --------------------------------------------------------

-- 
-- Table structure for table `szot`
-- 

CREATE TABLE `szot` (
  `szal` varchar(255) NOT NULL default '',
  `szf` varchar(50) NOT NULL default '',
  `gk` int(7) NOT NULL default '0',
  `valt` text NOT NULL,
  `mj` text NOT NULL,
  `elem` varchar(20) NOT NULL default '',
  `strong` varchar(10) NOT NULL default '',
  `bk` varchar(7) NOT NULL default '',
  PRIMARY KEY  (`gk`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `vendegk` (
  `nev` varchar(20) NOT NULL default '',
  `e-mail` varchar(50) default NULL,
  `datum` varchar(25) NOT NULL default '',
  `uzenet` longtext NOT NULL,
  `ssz` int(11) default NULL,
  PRIMARY KEY  (`datum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

