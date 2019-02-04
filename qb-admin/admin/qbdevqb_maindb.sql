-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 28, 2015 at 07:38 PM
-- Server version: 5.6.23
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qbdevqb_maindb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` text NOT NULL,
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `status` enum('main admin','admin') NOT NULL DEFAULT 'main admin',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE IF NOT EXISTS `ads` (
  `ads_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_creator` int(11) NOT NULL,
  `ads_title` mediumtext NOT NULL,
  `ads_content` mediumtext NOT NULL,
  `ads_pic` varchar(90) NOT NULL,
  `typeofadd` varchar(100) NOT NULL,
  `url` varchar(500) NOT NULL,
  `targetgender` varchar(50) NOT NULL,
  `targetmob` varchar(25) NOT NULL,
  `targetstate` varchar(200) NOT NULL,
  `targetcity` varchar(200) NOT NULL,
  `targetcountry` varchar(200) NOT NULL,
  `targetdob` date NOT NULL,
  `targetadd` varchar(300) NOT NULL,
  `targetgrad` varchar(30) NOT NULL,
  `pricingperclick` varchar(100) NOT NULL,
  `pricingbuy` varchar(255) NOT NULL,
  `pricingpay` varchar(300) NOT NULL,
  `pricinggateway` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `agelimit` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`ads_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ads_description`
--

CREATE TABLE IF NOT EXISTS `ads_description` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ads_id` int(11) NOT NULL,
  `lang` text NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ads_like`
--

CREATE TABLE IF NOT EXISTS `ads_like` (
  `ads_like_id` double NOT NULL AUTO_INCREMENT,
  `ads_id` double NOT NULL,
  `member_id` double NOT NULL,
  PRIMARY KEY (`ads_like_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `ads_title`
--

CREATE TABLE IF NOT EXISTS `ads_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ads_id` int(11) NOT NULL,
  `lang` text NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `app`
--

CREATE TABLE IF NOT EXISTS `app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `image` text NOT NULL,
  `name` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE IF NOT EXISTS `backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bleh`
--

CREATE TABLE IF NOT EXISTS `bleh` (
  `bleh_id` int(11) NOT NULL AUTO_INCREMENT,
  `remarks` text NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`bleh_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `blehdis`
--

CREATE TABLE IF NOT EXISTS `blehdis` (
  `bleh_id` int(11) NOT NULL AUTO_INCREMENT,
  `remarks` text NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`bleh_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocklist`
--

CREATE TABLE IF NOT EXISTS `blocklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `blocked_userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `blocked_userid` (`blocked_userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `capture_videos`
--

CREATE TABLE IF NOT EXISTS `capture_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` text NOT NULL,
  `duration` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat`
--

CREATE TABLE IF NOT EXISTS `cometchat` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_announcements`
--

CREATE TABLE IF NOT EXISTS `cometchat_announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `announcement` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `to` int(10) NOT NULL,
  `recd` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `time` (`time`),
  KEY `to_id` (`to`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_block`
--

CREATE TABLE IF NOT EXISTS `cometchat_block` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fromid` int(10) unsigned NOT NULL,
  `toid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fromid` (`fromid`),
  KEY `toid` (`toid`),
  KEY `fromid_toid` (`fromid`,`toid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_chatroommessages`
--

CREATE TABLE IF NOT EXISTS `cometchat_chatroommessages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `chatroomid` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `chatroomid` (`chatroomid`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_chatrooms`
--

CREATE TABLE IF NOT EXISTS `cometchat_chatrooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lastactivity` int(10) unsigned NOT NULL,
  `createdby` int(10) unsigned NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `vidsession` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lastactivity` (`lastactivity`),
  KEY `createdby` (`createdby`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_chatrooms_users`
--

CREATE TABLE IF NOT EXISTS `cometchat_chatrooms_users` (
  `userid` int(10) unsigned NOT NULL,
  `chatroomid` int(10) unsigned NOT NULL,
  `lastactivity` int(10) unsigned NOT NULL,
  `isbanned` int(1) DEFAULT '0',
  PRIMARY KEY (`userid`,`chatroomid`) USING BTREE,
  KEY `chatroomid` (`chatroomid`),
  KEY `lastactivity` (`lastactivity`),
  KEY `userid` (`userid`),
  KEY `userid_chatroomid` (`chatroomid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_comethistory`
--

CREATE TABLE IF NOT EXISTS `cometchat_comethistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `channel` (`channel`),
  KEY `sent` (`sent`),
  KEY `channel_sent` (`channel`,`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_games`
--

CREATE TABLE IF NOT EXISTS `cometchat_games` (
  `userid` int(10) unsigned NOT NULL,
  `score` int(10) unsigned DEFAULT NULL,
  `games` int(10) unsigned DEFAULT NULL,
  `recentlist` text,
  `highscorelist` text,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_guests`
--

CREATE TABLE IF NOT EXISTS `cometchat_guests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lastactivity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lastactivity` (`lastactivity`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10000001 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1426295656`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1426295656` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1426664827`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1426664827` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1426664842`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1426664842` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1426754684`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1426754684` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1426760194`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1426760194` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1426761417`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1426761417` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1426761693`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1426761693` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1426762703`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1426762703` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1427048525`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1427048525` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1427110158`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1427110158` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1427110329`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1427110329` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1427112037`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1427112037` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1427125845`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1427125845` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1427230622`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1427230622` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1430288404`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1430288404` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1430295351`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1430295351` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1430295354`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1430295354` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1430299523`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1430299523` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_messages_old_1430300563`
--

CREATE TABLE IF NOT EXISTS `cometchat_messages_old_1430300563` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL DEFAULT '0',
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_status`
--

CREATE TABLE IF NOT EXISTS `cometchat_status` (
  `userid` int(10) unsigned NOT NULL,
  `message` text,
  `status` enum('available','away','busy','invisible','offline') DEFAULT NULL,
  `typingto` int(10) unsigned DEFAULT NULL,
  `typingtime` int(10) unsigned DEFAULT NULL,
  `isdevice` int(1) unsigned NOT NULL DEFAULT '0',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `typingto` (`typingto`),
  KEY `typingtime` (`typingtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cometchat_users`
--

CREATE TABLE IF NOT EXISTS `cometchat_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `displayname` varchar(100) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `grp` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_dislike`
--

CREATE TABLE IF NOT EXISTS `comment_dislike` (
  `dislike_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `comment_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `isread` enum('0','1') NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dislike_comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_like`
--

CREATE TABLE IF NOT EXISTS `comment_like` (
  `like_id` double NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `comment_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_reply`
--

CREATE TABLE IF NOT EXISTS `comment_reply` (
  `reply_id` double NOT NULL AUTO_INCREMENT,
  `comment_id` double NOT NULL,
  `content` text NOT NULL,
  `commentedby` varchar(200) NOT NULL,
  `member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  PRIMARY KEY (`reply_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_reply1`
--

CREATE TABLE IF NOT EXISTS `comment_reply1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `tr_id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_report`
--

CREATE TABLE IF NOT EXISTS `comment_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` double NOT NULL,
  `member_id` double NOT NULL,
  `report` varchar(10000) NOT NULL,
  `date_created` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `country_photo_tag`
--

CREATE TABLE IF NOT EXISTS `country_photo_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member_in_tag_id` varchar(11) NOT NULL,
  `div_top` int(11) NOT NULL,
  `div_left` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `count_share`
--

CREATE TABLE IF NOT EXISTS `count_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `post_member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `day`
--

CREATE TABLE IF NOT EXISTS `day` (
  `day_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(2) NOT NULL,
  PRIMARY KEY (`day_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `datepicker` varchar(255) NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `event_host` varchar(255) NOT NULL,
  `users_ip` varchar(200) NOT NULL,
  `date_created` int(11) NOT NULL,
  `source` int(11) NOT NULL COMMENT '1.home,2.country,3.group',
  `country_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_category`
--

CREATE TABLE IF NOT EXISTS `event_category` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(59) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_members`
--

CREATE TABLE IF NOT EXISTS `event_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0.invited 1.going',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_videos`
--

CREATE TABLE IF NOT EXISTS `event_videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `featured` int(11) NOT NULL,
  `location` varchar(200) NOT NULL,
  `location1` varchar(255) NOT NULL,
  `location2` varchar(255) NOT NULL,
  `thumburl` varchar(255) NOT NULL,
  `thumburl1` varchar(255) NOT NULL,
  `thumburl2` varchar(255) NOT NULL,
  `thumburl3` varchar(255) NOT NULL,
  `thumburl4` varchar(255) NOT NULL,
  `thumburl5` varchar(255) NOT NULL,
  `custom_thumb` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `view_count` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1.private, 0.public',
  `url_type` int(11) NOT NULL COMMENT '1.upload, 2.youtube',
  `source` int(11) NOT NULL COMMENT '1.country',
  `country_id` int(11) NOT NULL,
  `title_size` int(11) NOT NULL,
  `title_color` varchar(255) NOT NULL,
  `ads` int(11) NOT NULL,
  `ads_id` int(11) NOT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall`
--

CREATE TABLE IF NOT EXISTS `event_wall` (
  `messages_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `messages` text NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `member_id` double NOT NULL,
  `type` int(11) NOT NULL COMMENT '0:status,1:photo,2:video,3;url',
  `ip` varchar(200) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`messages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_comment`
--

CREATE TABLE IF NOT EXISTS `event_wall_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` double NOT NULL,
  `content` text NOT NULL,
  `member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_comment_dislike`
--

CREATE TABLE IF NOT EXISTS `event_wall_comment_dislike` (
  `dislike_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `comment_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `isread` enum('0','1') NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dislike_comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_comment_like`
--

CREATE TABLE IF NOT EXISTS `event_wall_comment_like` (
  `like_id` double NOT NULL AUTO_INCREMENT,
  `comment_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_comment_reply`
--

CREATE TABLE IF NOT EXISTS `event_wall_comment_reply` (
  `reply_id` double NOT NULL AUTO_INCREMENT,
  `comment_id` double NOT NULL,
  `content` text NOT NULL,
  `member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  PRIMARY KEY (`reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_comment_reply_dislike`
--

CREATE TABLE IF NOT EXISTS `event_wall_comment_reply_dislike` (
  `dislike_reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `reply_id` int(11) NOT NULL,
  `comment_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `isread` enum('0','1') NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dislike_reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_comment_reply_like`
--

CREATE TABLE IF NOT EXISTS `event_wall_comment_reply_like` (
  `like_id` double NOT NULL AUTO_INCREMENT,
  `reply_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_dislike`
--

CREATE TABLE IF NOT EXISTS `event_wall_dislike` (
  `dislike_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`dislike_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_like`
--

CREATE TABLE IF NOT EXISTS `event_wall_like` (
  `bleh_id` int(11) NOT NULL AUTO_INCREMENT,
  `remarks` text NOT NULL,
  `member_id` varchar(30) NOT NULL,
  PRIMARY KEY (`bleh_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_reply_reply`
--

CREATE TABLE IF NOT EXISTS `event_wall_reply_reply` (
  `id` double NOT NULL AUTO_INCREMENT,
  `reply_id` double NOT NULL,
  `content` text NOT NULL,
  `commentedby` varchar(200) NOT NULL,
  `member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wall_report`
--

CREATE TABLE IF NOT EXISTS `event_wall_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` double NOT NULL,
  `member_id` double NOT NULL,
  `report` varchar(10000) NOT NULL,
  `date_created` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `favourite_country`
--

CREATE TABLE IF NOT EXISTS `favourite_country` (
  `favourite_country_id` double NOT NULL AUTO_INCREMENT,
  `member_id` double NOT NULL,
  `code` varchar(100) NOT NULL,
  `favourite_country` varchar(200) NOT NULL,
  PRIMARY KEY (`favourite_country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Table structure for table `friendlist`
--

CREATE TABLE IF NOT EXISTS `friendlist` (
  `friends_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` double NOT NULL,
  `member_id` int(11) NOT NULL,
  `added_member_id` double NOT NULL,
  `request_status` int(11) NOT NULL,
  `msg` mediumtext NOT NULL,
  `is_unread` int(11) NOT NULL COMMENT '0.unread, 1.read',
  `sent` int(10) NOT NULL,
  `block` int(11) NOT NULL,
  PRIMARY KEY (`friends_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=688 ;

-- --------------------------------------------------------

--
-- Table structure for table `geo_city`
--

CREATE TABLE IF NOT EXISTS `geo_city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL DEFAULT '0',
  `city_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lat` bigint(20) NOT NULL,
  `long` bigint(20) NOT NULL,
  `pop` int(10) unsigned NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46636 ;

-- --------------------------------------------------------

--
-- Table structure for table `geo_country`
--

CREATE TABLE IF NOT EXISTS `geo_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=240 ;

-- --------------------------------------------------------

--
-- Table structure for table `geo_state`
--

CREATE TABLE IF NOT EXISTS `geo_state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `state_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`state_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3220 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(1) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `approvals` tinyint(1) NOT NULL,
  `created` varchar(200) NOT NULL,
  `avatar` text NOT NULL,
  `thumb` text NOT NULL,
  `discusscount` int(11) NOT NULL DEFAULT '0',
  `wallcount` int(11) NOT NULL DEFAULT '0',
  `membercount` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `discussordering` int(11) NOT NULL,
  `photopermission` int(11) NOT NULL,
  `videopermission` int(11) NOT NULL,
  `grouprecentphotos` int(11) NOT NULL,
  `grouprecentvideos` int(11) NOT NULL,
  `newmembernotification` int(11) NOT NULL,
  `joinrequestnotification` int(11) NOT NULL,
  `wallnotification` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1.country',
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups1`
--

CREATE TABLE IF NOT EXISTS `groups1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `lang` text NOT NULL,
  `data` text NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_album`
--

CREATE TABLE IF NOT EXISTS `groups_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_group_id` int(11) NOT NULL,
  `album_name` varchar(900) NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_bulletins`
--

CREATE TABLE IF NOT EXISTS `groups_bulletins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_category`
--

CREATE TABLE IF NOT EXISTS `groups_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_discuss`
--

CREATE TABLE IF NOT EXISTS `groups_discuss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `groupid` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `created` varchar(100) NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `lastreplied` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_invite`
--

CREATE TABLE IF NOT EXISTS `groups_invite` (
  `groupid` int(11) NOT NULL,
  `userid` varchar(100) NOT NULL,
  `creator` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups_members`
--

CREATE TABLE IF NOT EXISTS `groups_members` (
  `groupid` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `approved` int(11) NOT NULL COMMENT '1=approved,0=denied or delete',
  `permissions` int(1) NOT NULL,
  KEY `groupid` (`groupid`),
  KEY `idx_memberid` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups_photo`
--

CREATE TABLE IF NOT EXISTS `groups_photo` (
  `photo_id` int(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(20) NOT NULL,
  `member_id` int(20) NOT NULL,
  `FILE_NAME` varchar(200) NOT NULL,
  `FILE_SIZE` varchar(200) NOT NULL,
  `FILE_TYPE` varchar(200) NOT NULL,
  `album_id` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `caption` varchar(900) NOT NULL,
  `description` varchar(900) NOT NULL,
  `comments_count` int(11) NOT NULL,
  `like_count` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  `msg_album_id` int(11) NOT NULL,
  `share` int(11) NOT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_photo_tag`
--

CREATE TABLE IF NOT EXISTS `groups_photo_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member_in_tag_id` varchar(11) NOT NULL,
  `div_top` int(11) NOT NULL,
  `div_left` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall`
--

CREATE TABLE IF NOT EXISTS `groups_wall` (
  `messages_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `messages` text NOT NULL,
  `url_title` varchar(250) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `member_id` double NOT NULL,
  `content_id` double NOT NULL,
  `country_flag` varchar(200) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0:status,1:photo,2:video,3;url',
  `ip` varchar(200) NOT NULL,
  `wall_privacy` int(11) NOT NULL COMMENT '0=,1=public,2=friends,3=only me,4=custom',
  `msg_album_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `share_member_id` varchar(100) NOT NULL,
  `unshare_member_id` varchar(100) NOT NULL,
  `video_id` int(11) NOT NULL,
  `share` int(11) NOT NULL COMMENT '1.share 0.not',
  `share_by` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  `share_on_member` varchar(255) NOT NULL,
  `share_on_country` varchar(255) NOT NULL,
  `share_on_group` varchar(255) NOT NULL,
  `share_on_world` varchar(255) NOT NULL,
  `share_privacy` int(11) NOT NULL,
  `share_msg` text NOT NULL,
  `photo_status` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`messages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_comment`
--

CREATE TABLE IF NOT EXISTS `groups_wall_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` double NOT NULL,
  `content` text NOT NULL,
  `post_member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_comment_dislike`
--

CREATE TABLE IF NOT EXISTS `groups_wall_comment_dislike` (
  `dislike_id` int(10) NOT NULL AUTO_INCREMENT,
  `msg_id` int(10) NOT NULL,
  `comment_id` double NOT NULL,
  `member_id` varchar(20) NOT NULL,
  `created` int(11) NOT NULL,
  `isread` enum('0','1') NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dislike_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_comment_like`
--

CREATE TABLE IF NOT EXISTS `groups_wall_comment_like` (
  `like_id` double NOT NULL AUTO_INCREMENT,
  `msg_id` int(10) NOT NULL,
  `comment_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_dislike`
--

CREATE TABLE IF NOT EXISTS `groups_wall_dislike` (
  `dislike_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `member_id` varchar(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dislike_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_like`
--

CREATE TABLE IF NOT EXISTS `groups_wall_like` (
  `bleh_id` int(11) NOT NULL AUTO_INCREMENT,
  `remarks` text NOT NULL,
  `member_id` varchar(30) NOT NULL,
  PRIMARY KEY (`bleh_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_reply`
--

CREATE TABLE IF NOT EXISTS `groups_wall_reply` (
  `reply_id` double NOT NULL AUTO_INCREMENT,
  `comment_id` double NOT NULL,
  `content` text NOT NULL,
  `member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  PRIMARY KEY (`reply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_reply_dislike`
--

CREATE TABLE IF NOT EXISTS `groups_wall_reply_dislike` (
  `dislike_id` int(11) NOT NULL AUTO_INCREMENT,
  `reply_id` int(11) NOT NULL,
  `comment_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `isread` enum('0','1') NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dislike_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_reply_like`
--

CREATE TABLE IF NOT EXISTS `groups_wall_reply_like` (
  `like_id` double NOT NULL AUTO_INCREMENT,
  `reply_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_wall_reply_reply`
--

CREATE TABLE IF NOT EXISTS `groups_wall_reply_reply` (
  `id` double NOT NULL AUTO_INCREMENT,
  `reply_id` double NOT NULL,
  `content` text NOT NULL,
  `commentedby` varchar(200) NOT NULL,
  `member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `import_contact`
--

CREATE TABLE IF NOT EXISTS `import_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `member_id` int(11) NOT NULL,
  `oauth_id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invite_friends`
--

CREATE TABLE IF NOT EXISTS `invite_friends` (
  `invite_id` double NOT NULL AUTO_INCREMENT,
  `member_id` double NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`invite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `ip` varchar(20) DEFAULT NULL,
  `attempts` int(11) DEFAULT '0',
  `lastlogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `displayname` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dob` char(15) NOT NULL,
  `status` char(5) NOT NULL,
  `activation_key` varchar(84) NOT NULL,
  `salt` varchar(84) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_id` (`member_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=201 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `Mname` varchar(255) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `mobile_no` varchar(50) NOT NULL,
  `landline_no` varchar(200) NOT NULL,
  `website` varchar(100) NOT NULL,
  `Status_ID` int(11) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `registerDate` datetime NOT NULL,
  `lastvisitDate` datetime NOT NULL,
  `relationship` varchar(100) NOT NULL,
  `profImage` varchar(100) NOT NULL,
  `curcity` varchar(50) NOT NULL,
  `hometown` varchar(50) NOT NULL,
  `interested` varchar(30) NOT NULL,
  `language` varchar(30) NOT NULL,
  `religion` varchar(200) NOT NULL,
  `political_views` varchar(200) NOT NULL,
  `college` varchar(100) NOT NULL,
  `college_year` double NOT NULL,
  `highschool` varchar(100) NOT NULL,
  `school_year` double NOT NULL,
  `company` varchar(200) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `aboutme` text NOT NULL,
  `month` varchar(4) NOT NULL,
  `day` varchar(2) NOT NULL,
  `year` varchar(4) NOT NULL,
  `origion_country` varchar(200) NOT NULL,
  `lastactivity` int(11) DEFAULT '0',
  `ip` varchar(255) NOT NULL,
  `status_code` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `tempPass` varchar(200) NOT NULL,
  `salt` varchar(255) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_education_history`
--

CREATE TABLE IF NOT EXISTS `member_education_history` (
  `education_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `education_organization` int(11) NOT NULL,
  `education_grade` int(11) NOT NULL,
  `education_year_from` int(11) NOT NULL,
  `education_year_to` int(11) NOT NULL,
  PRIMARY KEY (`education_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_meta`
--

CREATE TABLE IF NOT EXISTS `member_meta` (
  `member_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `meta_key` varchar(50) NOT NULL,
  `meta_value` longtext NOT NULL,
  PRIMARY KEY (`member_meta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=290 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_places_lived_history`
--

CREATE TABLE IF NOT EXISTS `member_places_lived_history` (
  `mplh_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `zip` int(11) NOT NULL,
  `lived_from` int(11) NOT NULL,
  `lived_to` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`mplh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_working_history`
--

CREATE TABLE IF NOT EXISTS `member_working_history` (
  `working_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `working_organization` int(11) NOT NULL,
  `working_designation` int(11) NOT NULL,
  `working_year_from` int(11) NOT NULL,
  `working_year_to` int(11) NOT NULL,
  `working_status` int(11) NOT NULL,
  PRIMARY KEY (`working_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `messages_id` int(11) NOT NULL AUTO_INCREMENT,
  `messages` text NOT NULL,
  `description` text NOT NULL,
  `url_title` varchar(250) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `member_id` double NOT NULL,
  `content_id` double NOT NULL,
  `country_flag` varchar(200) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0:status,1:photo,2:video,3;url',
  `ip` varchar(200) NOT NULL,
  `wall_privacy` int(11) NOT NULL COMMENT '0=,1=public,2=friends,3=only me,4=custom',
  `msg_album_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `share_member_id` varchar(100) NOT NULL,
  `unshare_member_id` varchar(100) NOT NULL,
  `video_id` int(11) NOT NULL,
  `share` int(11) NOT NULL COMMENT '1.share 0.not',
  `share_by` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  `share_on_member` varchar(255) NOT NULL,
  `share_on_country` varchar(255) NOT NULL,
  `share_on_group` varchar(255) NOT NULL,
  `share_on_world` varchar(255) NOT NULL,
  `share_privacy` int(11) NOT NULL,
  `share_msg` text NOT NULL,
  `photo_status` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `wall_type` int(11) NOT NULL,
  `isread` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`messages_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `message1`
--

CREATE TABLE IF NOT EXISTS `message1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `message` text,
  `tr_id` varchar(10) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migration_members`
--

CREATE TABLE IF NOT EXISTS `migration_members` (
  `member_id` int(11) NOT NULL DEFAULT '0',
  `Value` varchar(50) NOT NULL,
  `Key` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `HasLookup` varchar(1) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'N',
  `TableLookupKey` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `LookupValue` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `month`
--

CREATE TABLE IF NOT EXISTS `month` (
  `month_id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(15) NOT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `image_url` text NOT NULL,
  `video_url` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `news_category`
--

CREATE TABLE IF NOT EXISTS `news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `received_id` int(11) NOT NULL,
  `type_of_notifications` int(11) NOT NULL COMMENT '1.like,2.comment,3.page_request,4.country_request,5.group_request,6.invite_event,7.request_accepted,8.post_status,9.share,10.wants to be friend ,11.posts image',
  `title` text NOT NULL,
  `href` text NOT NULL,
  `is_unread` int(11) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `photoscomment`
--

CREATE TABLE IF NOT EXISTS `photoscomment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `commentby` int(100) NOT NULL,
  `PIC` varchar(30) NOT NULL,
  `date_created` varchar(100) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photo_comments`
--

CREATE TABLE IF NOT EXISTS `photo_comments` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_item_id` int(11) NOT NULL,
  `c_ip` varchar(900) NOT NULL,
  `c_name` varchar(900) NOT NULL,
  `c_text` text NOT NULL,
  `c_when` int(11) NOT NULL,
  `c_user_id` int(11) NOT NULL,
  `like_count` int(11) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photo_comments_like`
--

CREATE TABLE IF NOT EXISTS `photo_comments_like` (
  `pcl_id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_comment_id` int(11) NOT NULL,
  `photo_comment_user_id` int(11) NOT NULL,
  PRIMARY KEY (`pcl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `postcomment`
--

CREATE TABLE IF NOT EXISTS `postcomment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` double NOT NULL,
  `content` text NOT NULL,
  `post_member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `isread` enum('0','1') NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `postcomment1`
--

CREATE TABLE IF NOT EXISTS `postcomment1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `tr_id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_dislike`
--

CREATE TABLE IF NOT EXISTS `post_dislike` (
  `dislike_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`dislike_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=387 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE IF NOT EXISTS `post_like` (
  `like_id` double NOT NULL AUTO_INCREMENT,
  `post_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_meta`
--

CREATE TABLE IF NOT EXISTS `post_meta` (
  `post_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`post_meta_id`),
  KEY `meta_search` (`post_id`,`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='meta values of a post' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `privacy`
--

CREATE TABLE IF NOT EXISTS `privacy` (
  `privacy_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile` int(11) NOT NULL,
  `friends` int(11) NOT NULL,
  `gender` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `birthday` int(11) NOT NULL,
  `mobileno` int(11) NOT NULL,
  `workandeducation` int(11) NOT NULL,
  `photo` int(11) NOT NULL,
  `receive_email` int(11) NOT NULL,
  `receive_notification` int(11) NOT NULL,
  `comment_notification` int(11) NOT NULL,
  `privacy_member_id` int(11) NOT NULL,
  PRIMARY KEY (`privacy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_country_company_record`
--

CREATE TABLE IF NOT EXISTS `qb_country_company_record` (
  `qb_ccr_id` int(11) NOT NULL AUTO_INCREMENT,
  `country` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `organization_name` varchar(500) NOT NULL,
  `organization_type` int(11) NOT NULL,
  PRIMARY KEY (`qb_ccr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_country_education_record`
--

CREATE TABLE IF NOT EXISTS `qb_country_education_record` (
  `qb_cer_id` int(11) NOT NULL AUTO_INCREMENT,
  `country` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `organization_name` varchar(500) NOT NULL,
  `organization_type` int(11) NOT NULL,
  PRIMARY KEY (`qb_cer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_lookup`
--

CREATE TABLE IF NOT EXISTS `qb_lookup` (
  `lookup_key` int(11) NOT NULL AUTO_INCREMENT,
  `lookup_value` varchar(50) NOT NULL,
  `lookup_parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`lookup_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_member_profile_ranking`
--

CREATE TABLE IF NOT EXISTS `qb_member_profile_ranking` (
  `member_id` int(11) NOT NULL,
  `profile_preference_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qb_profile_preference`
--

CREATE TABLE IF NOT EXISTS `qb_profile_preference` (
  `profile_preference_key` int(11) NOT NULL AUTO_INCREMENT,
  `profile_preference_value` varchar(50) NOT NULL,
  `profile_preference_rank` int(11) NOT NULL,
  PRIMARY KEY (`profile_preference_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `registered_ip`
--

CREATE TABLE IF NOT EXISTS `registered_ip` (
  `registered_ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(20) NOT NULL,
  `ip_holder_name` varchar(20) NOT NULL,
  `password` varchar(90) NOT NULL,
  `salt` varchar(90) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`registered_ip_id`),
  UNIQUE KEY `ip_address` (`ip_address`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `reply_dislike`
--

CREATE TABLE IF NOT EXISTS `reply_dislike` (
  `dislike_reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `reply_id` int(11) NOT NULL,
  `comment_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `isread` enum('0','1') NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dislike_reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reply_like`
--

CREATE TABLE IF NOT EXISTS `reply_like` (
  `like_id` double NOT NULL AUTO_INCREMENT,
  `reply_id` double NOT NULL,
  `member_id` varchar(30) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isread` enum('0','1') NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reply_reply`
--

CREATE TABLE IF NOT EXISTS `reply_reply` (
  `id` double NOT NULL AUTO_INCREMENT,
  `reply_id` double NOT NULL,
  `content` text NOT NULL,
  `commentedby` varchar(200) NOT NULL,
  `member_id` double NOT NULL,
  `date_created` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reply_reply1`
--

CREATE TABLE IF NOT EXISTS `reply_reply1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `tr_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE IF NOT EXISTS `reset_password` (
  `member_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(125) NOT NULL DEFAULT '',
  `site_address` varchar(125) NOT NULL DEFAULT '',
  `css_style` varchar(10) NOT NULL DEFAULT '',
  `header_text` varchar(125) NOT NULL DEFAULT '',
  `site_language` char(2) NOT NULL DEFAULT 'en',
  `datagrid_css_style` varchar(10) NOT NULL DEFAULT 'default',
  `menu_style` enum('left','top') NOT NULL DEFAULT 'left',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `status_share`
--

CREATE TABLE IF NOT EXISTS `status_share` (
  `share_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `msg_id` int(11) NOT NULL,
  `date_created_share` int(20) NOT NULL,
  `share_by` double NOT NULL,
  `share_on_member` varchar(100) NOT NULL,
  `share_on_group` varchar(100) NOT NULL,
  `share_on_country` varchar(100) NOT NULL,
  `share_on_world` varchar(50) NOT NULL,
  `privacy` int(11) NOT NULL,
  `share` int(11) NOT NULL,
  PRIMARY KEY (`share_id`),
  UNIQUE KEY `share_id` (`share_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member_in_tag_id` varchar(11) NOT NULL,
  `div_top` int(11) NOT NULL,
  `div_left` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `tr_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_qb`
--

CREATE TABLE IF NOT EXISTS `test_qb` (
  `name` varchar(20) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upload_data`
--

CREATE TABLE IF NOT EXISTS `upload_data` (
  `upload_data_id` int(5) NOT NULL AUTO_INCREMENT,
  `USER_CODE` int(11) NOT NULL,
  `FILE_NAME` varchar(200) NOT NULL,
  `FILE_SIZE` varchar(200) NOT NULL,
  `FILE_TYPE` varchar(200) NOT NULL,
  `album_id` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `caption` varchar(900) NOT NULL,
  `description` varchar(900) NOT NULL,
  `comments_count` int(11) NOT NULL,
  `like_count` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  `msg_album_id` int(11) NOT NULL,
  `share` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`upload_data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `upload_data_like`
--

CREATE TABLE IF NOT EXISTS `upload_data_like` (
  `upload_data_like_id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_data_user_id` int(11) NOT NULL,
  `upload_data_item_id` int(11) NOT NULL,
  PRIMARY KEY (`upload_data_like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_album`
--

CREATE TABLE IF NOT EXISTS `user_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_user_id` int(11) NOT NULL,
  `album_name` varchar(900) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1.country_photo',
  `country_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_uploads`
--

CREATE TABLE IF NOT EXISTS `user_uploads` (
  `upload_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` text,
  `user_id_fk` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `featured` int(11) NOT NULL,
  `location` varchar(200) NOT NULL,
  `location1` varchar(255) NOT NULL,
  `location2` varchar(255) NOT NULL,
  `thumburl` varchar(255) NOT NULL,
  `thumburl1` varchar(255) NOT NULL,
  `thumburl2` varchar(255) NOT NULL,
  `thumburl3` varchar(255) NOT NULL,
  `thumburl4` varchar(255) NOT NULL,
  `thumburl5` varchar(255) NOT NULL,
  `custom_thumb` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `view_count` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1.private, 0.public',
  `url_type` int(11) NOT NULL COMMENT '1.upload, 2.youtube',
  `source` int(11) NOT NULL COMMENT '1.country',
  `country_id` varchar(100) NOT NULL,
  `title_size` int(11) NOT NULL,
  `title_color` varchar(255) NOT NULL,
  `ads` int(11) NOT NULL,
  `ads_id` int(11) NOT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos1`
--

CREATE TABLE IF NOT EXISTS `videos1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL,
  `lang` text NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos_ads`
--

CREATE TABLE IF NOT EXISTS `videos_ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` int(11) NOT NULL,
  `ads_name` varchar(255) NOT NULL,
  `location` varchar(200) NOT NULL,
  `location1` varchar(255) NOT NULL,
  `location2` varchar(255) NOT NULL,
  `click_url` text NOT NULL,
  `date_created` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos_category`
--

CREATE TABLE IF NOT EXISTS `videos_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos_channel`
--

CREATE TABLE IF NOT EXISTS `videos_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `cover_photo` text NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos_playlist`
--

CREATE TABLE IF NOT EXISTS `videos_playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos_playlist_video`
--

CREATE TABLE IF NOT EXISTS `videos_playlist_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos_subscribe`
--

CREATE TABLE IF NOT EXISTS `videos_subscribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `subscriber_member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `videos_views`
--

CREATE TABLE IF NOT EXISTS `videos_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wall_alerts`
--

CREATE TABLE IF NOT EXISTS `wall_alerts` (
  `waid` int(11) NOT NULL AUTO_INCREMENT,
  `wawallid` int(11) NOT NULL DEFAULT '0',
  `wauserid` int(11) NOT NULL DEFAULT '0',
  `wapostby` int(11) NOT NULL DEFAULT '0',
  `watype` varchar(12) NOT NULL DEFAULT '',
  `wacomment_postby` int(11) NOT NULL DEFAULT '0',
  `waread` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`waid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wall_post_like`
--

CREATE TABLE IF NOT EXISTS `wall_post_like` (
  `bleh_id` int(11) NOT NULL AUTO_INCREMENT,
  `remarks` text NOT NULL,
  `member_id` varchar(30) NOT NULL,
  PRIMARY KEY (`bleh_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE IF NOT EXISTS `year` (
  `year_id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  PRIMARY KEY (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
