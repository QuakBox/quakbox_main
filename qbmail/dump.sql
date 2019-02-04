-- MySQL dump 10.13  Distrib 5.7.11, for osx10.9 (x86_64)
--
-- Host: localhost    Database: qbwebmail
-- ------------------------------------------------------
-- Server version	5.7.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `a_users`
--

DROP TABLE IF EXISTS `a_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a_users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_users`
--

LOCK TABLES `a_users` WRITE;
/*!40000 ALTER TABLE `a_users` DISABLE KEYS */;
INSERT INTO `a_users` VALUES (1,0);
/*!40000 ALTER TABLE `a_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_appointments`
--

DROP TABLE IF EXISTS `acal_appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_appointments` (
  `id_appointment` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `access_type` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `hash` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_appointment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_appointments`
--

LOCK TABLES `acal_appointments` WRITE;
/*!40000 ALTER TABLE `acal_appointments` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_awm_fnbl_runs`
--

DROP TABLE IF EXISTS `acal_awm_fnbl_runs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_awm_fnbl_runs` (
  `id_run` int(11) NOT NULL AUTO_INCREMENT,
  `run_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_run`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_awm_fnbl_runs`
--

LOCK TABLES `acal_awm_fnbl_runs` WRITE;
/*!40000 ALTER TABLE `acal_awm_fnbl_runs` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_awm_fnbl_runs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_calendars`
--

DROP TABLE IF EXISTS `acal_calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_calendars` (
  `calendar_id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_str_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `calendar_name` varchar(100) NOT NULL DEFAULT '',
  `calendar_description` text,
  `calendar_color` int(11) NOT NULL DEFAULT '0',
  `calendar_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`calendar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_calendars`
--

LOCK TABLES `acal_calendars` WRITE;
/*!40000 ALTER TABLE `acal_calendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_cron_runs`
--

DROP TABLE IF EXISTS `acal_cron_runs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_cron_runs` (
  `id_run` bigint(20) NOT NULL AUTO_INCREMENT,
  `run_date` datetime DEFAULT NULL,
  `latest_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_run`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_cron_runs`
--

LOCK TABLES `acal_cron_runs` WRITE;
/*!40000 ALTER TABLE `acal_cron_runs` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_cron_runs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_eventrepeats`
--

DROP TABLE IF EXISTS `acal_eventrepeats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_eventrepeats` (
  `id_repeat` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) DEFAULT NULL,
  `repeat_period` tinyint(1) NOT NULL DEFAULT '0',
  `repeat_order` tinyint(1) NOT NULL DEFAULT '1',
  `repeat_num` int(11) NOT NULL DEFAULT '0',
  `repeat_until` datetime DEFAULT NULL,
  `sun` tinyint(1) NOT NULL DEFAULT '0',
  `mon` tinyint(1) NOT NULL DEFAULT '0',
  `tue` tinyint(1) NOT NULL DEFAULT '0',
  `wed` tinyint(1) NOT NULL DEFAULT '0',
  `thu` tinyint(1) NOT NULL DEFAULT '0',
  `fri` tinyint(1) NOT NULL DEFAULT '0',
  `sat` tinyint(1) NOT NULL DEFAULT '0',
  `week_number` tinyint(1) DEFAULT NULL,
  `repeat_end` tinyint(1) NOT NULL DEFAULT '0',
  `excluded` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_repeat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_eventrepeats`
--

LOCK TABLES `acal_eventrepeats` WRITE;
/*!40000 ALTER TABLE `acal_eventrepeats` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_eventrepeats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_events`
--

DROP TABLE IF EXISTS `acal_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_str_id` varchar(255) DEFAULT NULL,
  `calendar_id` int(11) DEFAULT NULL,
  `event_timefrom` datetime DEFAULT NULL,
  `event_timetill` datetime DEFAULT NULL,
  `event_allday` tinyint(1) NOT NULL DEFAULT '0',
  `event_name` varchar(100) NOT NULL DEFAULT '',
  `event_text` text,
  `event_priority` tinyint(4) DEFAULT NULL,
  `event_repeats` tinyint(1) NOT NULL DEFAULT '0',
  `event_last_modified` datetime DEFAULT NULL,
  `event_owner_email` varchar(255) NOT NULL DEFAULT '',
  `event_appointment_access` tinyint(4) NOT NULL DEFAULT '0',
  `event_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_events`
--

LOCK TABLES `acal_events` WRITE;
/*!40000 ALTER TABLE `acal_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_exclusions`
--

DROP TABLE IF EXISTS `acal_exclusions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_exclusions` (
  `id_exclusion` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) DEFAULT NULL,
  `id_calendar` int(11) DEFAULT NULL,
  `id_repeat` int(11) DEFAULT NULL,
  `id_recurrence_date` datetime DEFAULT NULL,
  `event_timefrom` datetime DEFAULT NULL,
  `event_timetill` datetime DEFAULT NULL,
  `event_name` varchar(100) DEFAULT NULL,
  `event_text` text,
  `event_allday` tinyint(1) NOT NULL DEFAULT '0',
  `event_last_modified` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_exclusion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_exclusions`
--

LOCK TABLES `acal_exclusions` WRITE;
/*!40000 ALTER TABLE `acal_exclusions` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_exclusions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_publications`
--

DROP TABLE IF EXISTS `acal_publications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_publications` (
  `id_publication` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_calendar` int(11) DEFAULT NULL,
  `str_md5` varchar(32) DEFAULT NULL,
  `int_access_level` tinyint(4) NOT NULL DEFAULT '1',
  `access_type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_publication`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_publications`
--

LOCK TABLES `acal_publications` WRITE;
/*!40000 ALTER TABLE `acal_publications` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_publications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_reminders`
--

DROP TABLE IF EXISTS `acal_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_reminders` (
  `id_reminder` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `notice_type` tinyint(4) NOT NULL DEFAULT '0',
  `remind_offset` int(11) NOT NULL DEFAULT '0',
  `sent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_reminder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_reminders`
--

LOCK TABLES `acal_reminders` WRITE;
/*!40000 ALTER TABLE `acal_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_sharing`
--

DROP TABLE IF EXISTS `acal_sharing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_sharing` (
  `id_share` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_calendar` int(11) DEFAULT NULL,
  `id_to_user` int(11) DEFAULT NULL,
  `str_to_email` varchar(255) NOT NULL DEFAULT '',
  `int_access_level` tinyint(4) NOT NULL DEFAULT '2',
  `calendar_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_share`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_sharing`
--

LOCK TABLES `acal_sharing` WRITE;
/*!40000 ALTER TABLE `acal_sharing` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_sharing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acal_users_data`
--

DROP TABLE IF EXISTS `acal_users_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acal_users_data` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `showweekends` tinyint(1) NOT NULL DEFAULT '0',
  `workdaystarts` tinyint(4) NOT NULL DEFAULT '9',
  `workdayends` tinyint(4) NOT NULL DEFAULT '17',
  `showworkday` tinyint(1) NOT NULL DEFAULT '0',
  `weekstartson` tinyint(4) NOT NULL DEFAULT '0',
  `defaulttab` tinyint(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`settings_id`),
  KEY `ACAL_USERS_DATA_USER_ID_INDEX` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acal_users_data`
--

LOCK TABLES `acal_users_data` WRITE;
/*!40000 ALTER TABLE `acal_users_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `acal_users_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_addressbooks`
--

DROP TABLE IF EXISTS `adav_addressbooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_addressbooks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `principaluri` varchar(255) DEFAULT NULL,
  `displayname` varchar(255) DEFAULT NULL,
  `uri` varchar(200) DEFAULT NULL,
  `description` text,
  `ctag` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_addressbooks`
--

LOCK TABLES `adav_addressbooks` WRITE;
/*!40000 ALTER TABLE `adav_addressbooks` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_addressbooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_cache`
--

DROP TABLE IF EXISTS `adav_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `calendaruri` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `eventid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_cache`
--

LOCK TABLES `adav_cache` WRITE;
/*!40000 ALTER TABLE `adav_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_calendarobjects`
--

DROP TABLE IF EXISTS `adav_calendarobjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_calendarobjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `calendardata` mediumtext,
  `uri` varchar(255) DEFAULT NULL,
  `calendarid` int(11) unsigned NOT NULL,
  `lastmodified` int(11) DEFAULT NULL,
  `etag` varchar(32) NOT NULL DEFAULT '',
  `size` int(11) unsigned NOT NULL DEFAULT '0',
  `componenttype` varchar(8) NOT NULL DEFAULT '',
  `firstoccurence` int(11) unsigned DEFAULT NULL,
  `lastoccurence` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_calendarobjects`
--

LOCK TABLES `adav_calendarobjects` WRITE;
/*!40000 ALTER TABLE `adav_calendarobjects` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_calendarobjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_calendars`
--

DROP TABLE IF EXISTS `adav_calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_calendars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `principaluri` varchar(255) DEFAULT NULL,
  `displayname` varchar(100) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `ctag` int(11) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `calendarorder` int(11) unsigned NOT NULL DEFAULT '0',
  `calendarcolor` varchar(10) DEFAULT NULL,
  `timezone` text,
  `components` varchar(20) DEFAULT NULL,
  `transparent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_calendars`
--

LOCK TABLES `adav_calendars` WRITE;
/*!40000 ALTER TABLE `adav_calendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_calendarshares`
--

DROP TABLE IF EXISTS `adav_calendarshares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_calendarshares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `calendarid` int(11) unsigned DEFAULT NULL,
  `member` int(11) unsigned DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `summary` varchar(150) DEFAULT NULL,
  `displayname` varchar(100) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `principaluri` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_calendarshares`
--

LOCK TABLES `adav_calendarshares` WRITE;
/*!40000 ALTER TABLE `adav_calendarshares` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_calendarshares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_cards`
--

DROP TABLE IF EXISTS `adav_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_cards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `addressbookid` int(11) unsigned NOT NULL,
  `carddata` mediumtext,
  `uri` varchar(255) DEFAULT NULL,
  `lastmodified` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ADAV_CARDS_ADDRESSBOOKID_INDEX` (`addressbookid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_cards`
--

LOCK TABLES `adav_cards` WRITE;
/*!40000 ALTER TABLE `adav_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_groupmembers`
--

DROP TABLE IF EXISTS `adav_groupmembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_groupmembers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int(11) unsigned NOT NULL,
  `member_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ADAV_GROUPMEMBERS_MEMBER_ID_PRINCIPAL_ID_INDEX` (`principal_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_groupmembers`
--

LOCK TABLES `adav_groupmembers` WRITE;
/*!40000 ALTER TABLE `adav_groupmembers` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_groupmembers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_locks`
--

DROP TABLE IF EXISTS `adav_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_locks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner` varchar(100) DEFAULT NULL,
  `timeout` int(11) unsigned DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `scope` tinyint(4) DEFAULT NULL,
  `depth` tinyint(4) DEFAULT NULL,
  `uri` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_locks`
--

LOCK TABLES `adav_locks` WRITE;
/*!40000 ALTER TABLE `adav_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_principals`
--

DROP TABLE IF EXISTS `adav_principals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_principals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `vcardurl` varchar(80) DEFAULT NULL,
  `displayname` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ADAV_PRINCIPALS_URI_INDEX` (`uri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_principals`
--

LOCK TABLES `adav_principals` WRITE;
/*!40000 ALTER TABLE `adav_principals` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_principals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adav_reminders`
--

DROP TABLE IF EXISTS `adav_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adav_reminders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `calendaruri` varchar(255) DEFAULT NULL,
  `eventid` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `allday` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adav_reminders`
--

LOCK TABLES `adav_reminders` WRITE;
/*!40000 ALTER TABLE `adav_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `adav_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ahd_attachments`
--

DROP TABLE IF EXISTS `ahd_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahd_attachments` (
  `id_helpdesk_attachment` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_helpdesk_post` int(11) DEFAULT NULL,
  `id_helpdesk_thread` int(11) DEFAULT NULL,
  `id_tenant` int(11) DEFAULT NULL,
  `id_owner` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `size_in_bytes` int(11) unsigned DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `hash` text,
  PRIMARY KEY (`id_helpdesk_attachment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ahd_attachments`
--

LOCK TABLES `ahd_attachments` WRITE;
/*!40000 ALTER TABLE `ahd_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `ahd_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ahd_fetcher`
--

DROP TABLE IF EXISTS `ahd_fetcher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahd_fetcher` (
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `last_uid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ahd_fetcher`
--

LOCK TABLES `ahd_fetcher` WRITE;
/*!40000 ALTER TABLE `ahd_fetcher` DISABLE KEYS */;
/*!40000 ALTER TABLE `ahd_fetcher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ahd_online`
--

DROP TABLE IF EXISTS `ahd_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahd_online` (
  `id_helpdesk_thread` int(11) NOT NULL DEFAULT '0',
  `id_helpdesk_user` int(11) NOT NULL DEFAULT '0',
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `ping_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ahd_online`
--

LOCK TABLES `ahd_online` WRITE;
/*!40000 ALTER TABLE `ahd_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `ahd_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ahd_posts`
--

DROP TABLE IF EXISTS `ahd_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahd_posts` (
  `id_helpdesk_post` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_helpdesk_thread` int(11) DEFAULT NULL,
  `id_tenant` int(11) DEFAULT NULL,
  `id_owner` int(11) DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `system_type` smallint(6) NOT NULL DEFAULT '0',
  `text` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id_helpdesk_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ahd_posts`
--

LOCK TABLES `ahd_posts` WRITE;
/*!40000 ALTER TABLE `ahd_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `ahd_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ahd_reads`
--

DROP TABLE IF EXISTS `ahd_reads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahd_reads` (
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `id_owner` int(11) DEFAULT NULL,
  `id_helpdesk_thread` int(11) DEFAULT NULL,
  `last_post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ahd_reads`
--

LOCK TABLES `ahd_reads` WRITE;
/*!40000 ALTER TABLE `ahd_reads` DISABLE KEYS */;
/*!40000 ALTER TABLE `ahd_reads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ahd_threads`
--

DROP TABLE IF EXISTS `ahd_threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahd_threads` (
  `id_helpdesk_thread` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `str_helpdesk_hash` varchar(50) NOT NULL DEFAULT '',
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `id_owner` int(11) NOT NULL DEFAULT '0',
  `post_count` int(11) NOT NULL DEFAULT '0',
  `last_post_id` int(11) NOT NULL DEFAULT '0',
  `last_post_owner_id` int(11) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL DEFAULT '0',
  `has_attachments` tinyint(1) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `notificated` tinyint(1) NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id_helpdesk_thread`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ahd_threads`
--

LOCK TABLES `ahd_threads` WRITE;
/*!40000 ALTER TABLE `ahd_threads` DISABLE KEYS */;
/*!40000 ALTER TABLE `ahd_threads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ahd_users`
--

DROP TABLE IF EXISTS `ahd_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahd_users` (
  `id_helpdesk_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_system_user` int(11) NOT NULL DEFAULT '0',
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `is_agent` tinyint(1) NOT NULL DEFAULT '0',
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activate_hash` varchar(255) NOT NULL DEFAULT '',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `notification_email` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `social_id` varchar(255) NOT NULL DEFAULT '',
  `social_type` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(100) NOT NULL DEFAULT 'English',
  `date_format` varchar(50) NOT NULL DEFAULT '',
  `time_format` smallint(6) NOT NULL DEFAULT '0',
  `password_hash` varchar(255) NOT NULL DEFAULT '',
  `password_salt` varchar(255) NOT NULL DEFAULT '',
  `mail_notifications` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `signature` varchar(255) NOT NULL DEFAULT '',
  `signature_enable` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_helpdesk_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ahd_users`
--

LOCK TABLES `ahd_users` WRITE;
/*!40000 ALTER TABLE `ahd_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `ahd_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_account_quotas`
--

DROP TABLE IF EXISTS `awm_account_quotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_account_quotas` (
  `name` varchar(100) NOT NULL DEFAULT '',
  `quota_usage_messages` bigint(20) unsigned NOT NULL DEFAULT '0',
  `quota_usage_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  KEY `AWM_ACCOUNT_QUOTAS_NAME_INDEX` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_account_quotas`
--

LOCK TABLES `awm_account_quotas` WRITE;
/*!40000 ALTER TABLE `awm_account_quotas` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_account_quotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_accounts`
--

DROP TABLE IF EXISTS `awm_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_accounts` (
  `id_acct` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_domain` int(11) NOT NULL DEFAULT '0',
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `def_acct` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `quota` int(11) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `friendly_nm` varchar(255) DEFAULT NULL,
  `mail_protocol` tinyint(4) NOT NULL DEFAULT '1',
  `mail_inc_host` varchar(255) DEFAULT NULL,
  `mail_inc_port` int(11) NOT NULL DEFAULT '143',
  `mail_inc_login` varchar(255) DEFAULT NULL,
  `mail_inc_pass` varchar(255) DEFAULT NULL,
  `mail_inc_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `mail_out_host` varchar(255) DEFAULT NULL,
  `mail_out_port` int(11) NOT NULL DEFAULT '25',
  `mail_out_login` varchar(255) DEFAULT NULL,
  `mail_out_pass` varchar(255) DEFAULT NULL,
  `mail_out_auth` tinyint(4) NOT NULL DEFAULT '0',
  `mail_out_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `signature` mediumtext,
  `signature_type` tinyint(4) NOT NULL DEFAULT '1',
  `signature_opt` tinyint(4) NOT NULL DEFAULT '0',
  `mailbox_size` bigint(20) NOT NULL DEFAULT '0',
  `mailing_list` tinyint(1) NOT NULL DEFAULT '0',
  `hide_in_gab` tinyint(1) NOT NULL DEFAULT '0',
  `custom_fields` text,
  `is_password_specified` tinyint(1) NOT NULL DEFAULT '1',
  `allow_mail` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_acct`),
  KEY `AWM_ACCOUNTS_ID_USER_INDEX` (`id_user`),
  KEY `AWM_ACCOUNTS_ID_ACCT_ID_USER_INDEX` (`id_acct`,`id_user`),
  KEY `AWM_ACCOUNTS_MAIL_INC_LOGIN_INDEX` (`mail_inc_login`),
  KEY `AWM_ACCOUNTS_EMAIL_INDEX` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_accounts`
--

LOCK TABLES `awm_accounts` WRITE;
/*!40000 ALTER TABLE `awm_accounts` DISABLE KEYS */;
INSERT INTO `awm_accounts` VALUES (1,1,0,0,1,0,104857600,'dmitrytest@quakbox.com','',1,'quakbox.com',143,'dmitrytest@quakbox.com','74110700',0,'quakbox.com',25,'','',2,0,'',1,0,0,0,0,'',1,1);
/*!40000 ALTER TABLE `awm_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_addr_book`
--

DROP TABLE IF EXISTS `awm_addr_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_addr_book` (
  `id_addr` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_domain` int(11) NOT NULL DEFAULT '0',
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `str_id` varchar(255) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `type_id` varchar(100) NOT NULL DEFAULT '',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `view_email` varchar(255) NOT NULL DEFAULT '',
  `use_friendly_nm` tinyint(1) NOT NULL DEFAULT '1',
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `surname` varchar(100) NOT NULL DEFAULT '',
  `nickname` varchar(100) NOT NULL DEFAULT '',
  `skype` varchar(100) NOT NULL DEFAULT '',
  `facebook` varchar(255) NOT NULL DEFAULT '',
  `h_email` varchar(255) DEFAULT NULL,
  `h_street` varchar(255) DEFAULT NULL,
  `h_city` varchar(200) DEFAULT NULL,
  `h_state` varchar(200) DEFAULT NULL,
  `h_zip` varchar(10) DEFAULT NULL,
  `h_country` varchar(200) DEFAULT NULL,
  `h_phone` varchar(50) DEFAULT NULL,
  `h_fax` varchar(50) DEFAULT NULL,
  `h_mobile` varchar(50) DEFAULT NULL,
  `h_web` varchar(255) DEFAULT NULL,
  `b_email` varchar(255) DEFAULT NULL,
  `b_company` varchar(200) DEFAULT NULL,
  `b_street` varchar(255) DEFAULT NULL,
  `b_city` varchar(200) DEFAULT NULL,
  `b_state` varchar(200) DEFAULT NULL,
  `b_zip` varchar(10) DEFAULT NULL,
  `b_country` varchar(200) DEFAULT NULL,
  `b_job_title` varchar(100) DEFAULT NULL,
  `b_department` varchar(200) DEFAULT NULL,
  `b_office` varchar(200) DEFAULT NULL,
  `b_phone` varchar(50) DEFAULT NULL,
  `b_fax` varchar(50) DEFAULT NULL,
  `b_web` varchar(255) DEFAULT NULL,
  `other_email` varchar(255) DEFAULT NULL,
  `primary_email` tinyint(4) DEFAULT NULL,
  `birthday_day` tinyint(4) NOT NULL DEFAULT '0',
  `birthday_month` tinyint(4) NOT NULL DEFAULT '0',
  `birthday_year` smallint(6) NOT NULL DEFAULT '0',
  `id_addr_prev` bigint(20) DEFAULT NULL,
  `tmp` tinyint(1) NOT NULL DEFAULT '0',
  `use_frequency` int(11) NOT NULL DEFAULT '1',
  `auto_create` tinyint(1) NOT NULL DEFAULT '0',
  `notes` varchar(255) DEFAULT NULL,
  `etag` varchar(100) NOT NULL DEFAULT '',
  `shared_to_all` tinyint(1) NOT NULL DEFAULT '0',
  `hide_in_gab` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_addr`),
  KEY `AWM_ADDR_BOOK_ID_USER_INDEX` (`id_user`),
  KEY `AWM_ADDR_BOOK_DELETED_ID_USER_INDEX` (`id_user`,`deleted`),
  KEY `AWM_ADDR_BOOK_USE_FREQUENCY_INDEX` (`use_frequency`),
  KEY `AWM_ADDR_BOOK_VIEW_EMAIL_INDEX` (`view_email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_addr_book`
--

LOCK TABLES `awm_addr_book` WRITE;
/*!40000 ALTER TABLE `awm_addr_book` DISABLE KEYS */;
INSERT INTO `awm_addr_book` VALUES (1,0,0,0,NULL,2,'1',0,'2016-05-09 11:23:40','2016-05-09 11:23:40','','dmitrytest@quakbox.com',1,'','','','','','','','','','','','','','','','dmitrytest@quakbox.com','','','','','','','','','','','','','',1,0,0,0,NULL,0,1,0,'','',0,0),(2,1,0,0,NULL,0,'',0,'2016-05-09 12:52:48','2016-05-09 12:52:48','','dmitry@quakbox.com',1,'','','','','','dmitry@quakbox.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,0,NULL,0,1,1,NULL,'',0,0);
/*!40000 ALTER TABLE `awm_addr_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_addr_groups`
--

DROP TABLE IF EXISTS `awm_addr_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_addr_groups` (
  `id_group` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `group_nm` varchar(255) DEFAULT NULL,
  `group_str_id` varchar(100) DEFAULT NULL,
  `use_frequency` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `organization` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_group`),
  KEY `AWM_ADDR_GROUPS_ID_USER_INDEX` (`id_user`),
  KEY `AWM_ADDR_GROUPS_USE_FREQUENCY_INDEX` (`use_frequency`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_addr_groups`
--

LOCK TABLES `awm_addr_groups` WRITE;
/*!40000 ALTER TABLE `awm_addr_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_addr_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_addr_groups_contacts`
--

DROP TABLE IF EXISTS `awm_addr_groups_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_addr_groups_contacts` (
  `id_addr` bigint(20) NOT NULL DEFAULT '0',
  `id_group` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_addr_groups_contacts`
--

LOCK TABLES `awm_addr_groups_contacts` WRITE;
/*!40000 ALTER TABLE `awm_addr_groups_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_addr_groups_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_addr_groups_events`
--

DROP TABLE IF EXISTS `awm_addr_groups_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_addr_groups_events` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `id_group` int(11) NOT NULL DEFAULT '0',
  `id_calendar` varchar(250) DEFAULT NULL,
  `id_event` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_addr_groups_events`
--

LOCK TABLES `awm_addr_groups_events` WRITE;
/*!40000 ALTER TABLE `awm_addr_groups_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_addr_groups_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_channels`
--

DROP TABLE IF EXISTS `awm_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_channels` (
  `id_channel` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_channel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_channels`
--

LOCK TABLES `awm_channels` WRITE;
/*!40000 ALTER TABLE `awm_channels` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_columns`
--

DROP TABLE IF EXISTS `awm_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_column` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  `column_value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `AWM_COLUMNS_ID_USER_INDEX` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_columns`
--

LOCK TABLES `awm_columns` WRITE;
/*!40000 ALTER TABLE `awm_columns` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_columns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_domain_quotas`
--

DROP TABLE IF EXISTS `awm_domain_quotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_domain_quotas` (
  `name` varchar(100) NOT NULL DEFAULT '',
  `quota_usage_messages` bigint(20) unsigned NOT NULL DEFAULT '0',
  `quota_usage_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  KEY `AWM_DOMAIN_QUOTAS_NAME_INDEX` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_domain_quotas`
--

LOCK TABLES `awm_domain_quotas` WRITE;
/*!40000 ALTER TABLE `awm_domain_quotas` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_domain_quotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_domains`
--

DROP TABLE IF EXISTS `awm_domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_domains` (
  `id_domain` int(11) NOT NULL AUTO_INCREMENT,
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `user_quota` int(11) NOT NULL DEFAULT '0',
  `override_settings` tinyint(1) NOT NULL DEFAULT '0',
  `mail_protocol` tinyint(4) NOT NULL DEFAULT '1',
  `mail_inc_host` varchar(255) DEFAULT NULL,
  `mail_inc_port` int(11) NOT NULL DEFAULT '143',
  `mail_inc_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `mail_out_host` varchar(255) DEFAULT NULL,
  `mail_out_port` int(11) NOT NULL DEFAULT '25',
  `mail_out_auth` tinyint(4) NOT NULL DEFAULT '1',
  `mail_out_login` varchar(255) DEFAULT NULL,
  `mail_out_pass` varchar(255) DEFAULT NULL,
  `mail_out_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `mail_out_method` tinyint(4) NOT NULL DEFAULT '1',
  `quota_mbytes_limit` int(11) unsigned NOT NULL DEFAULT '0',
  `quota_usage_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `quota_usage_messages` bigint(20) unsigned NOT NULL DEFAULT '0',
  `allow_webmail` tinyint(1) NOT NULL DEFAULT '1',
  `site_name` varchar(255) DEFAULT NULL,
  `allow_change_interface_settings` tinyint(1) NOT NULL DEFAULT '0',
  `allow_users_add_acounts` tinyint(1) NOT NULL DEFAULT '0',
  `allow_change_account_settings` tinyint(1) NOT NULL DEFAULT '0',
  `allow_new_users_register` tinyint(1) NOT NULL DEFAULT '1',
  `allow_open_pgp` tinyint(1) NOT NULL DEFAULT '0',
  `def_user_timezone` int(11) NOT NULL DEFAULT '0',
  `def_user_timeformat` tinyint(4) NOT NULL DEFAULT '0',
  `def_user_dateformat` varchar(100) NOT NULL DEFAULT 'MM/DD/YYYY',
  `msgs_per_page` smallint(6) NOT NULL DEFAULT '20',
  `skin` varchar(255) DEFAULT NULL,
  `lang` varchar(255) DEFAULT NULL,
  `ext_imap_host` varchar(255) NOT NULL DEFAULT '',
  `ext_smtp_host` varchar(255) NOT NULL DEFAULT '',
  `ext_dav_host` varchar(255) NOT NULL DEFAULT '',
  `allow_contacts` tinyint(1) NOT NULL DEFAULT '1',
  `contacts_per_page` smallint(6) NOT NULL DEFAULT '20',
  `allow_calendar` tinyint(1) NOT NULL DEFAULT '1',
  `cal_week_starts_on` tinyint(4) NOT NULL DEFAULT '0',
  `cal_show_weekends` tinyint(1) NOT NULL DEFAULT '0',
  `cal_workday_starts` tinyint(4) NOT NULL DEFAULT '9',
  `cal_workday_ends` tinyint(4) NOT NULL DEFAULT '18',
  `cal_show_workday` tinyint(1) NOT NULL DEFAULT '0',
  `cal_default_tab` tinyint(4) NOT NULL DEFAULT '2',
  `layout` tinyint(4) NOT NULL DEFAULT '0',
  `xlist` tinyint(1) NOT NULL DEFAULT '1',
  `global_addr_book` tinyint(4) NOT NULL DEFAULT '0',
  `check_interval` int(11) NOT NULL DEFAULT '0',
  `allow_registration` tinyint(1) NOT NULL DEFAULT '0',
  `allow_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `allow_files` tinyint(1) NOT NULL DEFAULT '1',
  `allow_helpdesk` tinyint(1) NOT NULL DEFAULT '1',
  `use_threads` tinyint(1) NOT NULL DEFAULT '1',
  `is_internal` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `default_tab` varchar(255) NOT NULL DEFAULT 'mailbox',
  `is_default_for_tenant` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_domains`
--

LOCK TABLES `awm_domains` WRITE;
/*!40000 ALTER TABLE `awm_domains` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_fetchers`
--

DROP TABLE IF EXISTS `awm_fetchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_fetchers` (
  `id_fetcher` int(11) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_domain` int(11) NOT NULL DEFAULT '0',
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `mail_check_interval` int(11) NOT NULL DEFAULT '0',
  `mail_check_lasttime` int(11) NOT NULL DEFAULT '0',
  `leave_messages` tinyint(1) NOT NULL DEFAULT '1',
  `frienly_name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `signature` mediumtext,
  `signature_opt` tinyint(4) NOT NULL DEFAULT '0',
  `inc_host` varchar(255) NOT NULL DEFAULT '',
  `inc_port` int(11) NOT NULL DEFAULT '110',
  `inc_login` varchar(255) NOT NULL DEFAULT '',
  `inc_password` varchar(255) NOT NULL DEFAULT '',
  `inc_security` tinyint(4) NOT NULL DEFAULT '0',
  `out_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `out_host` varchar(255) NOT NULL DEFAULT '',
  `out_port` int(11) NOT NULL DEFAULT '110',
  `out_auth` tinyint(1) NOT NULL DEFAULT '1',
  `out_security` tinyint(4) NOT NULL DEFAULT '0',
  `dest_folder` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_fetcher`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_fetchers`
--

LOCK TABLES `awm_fetchers` WRITE;
/*!40000 ALTER TABLE `awm_fetchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_fetchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_filters`
--

DROP TABLE IF EXISTS `awm_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_filters` (
  `id_filter` int(11) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `field` tinyint(4) NOT NULL DEFAULT '0',
  `condition` tinyint(4) NOT NULL DEFAULT '0',
  `filter` varchar(255) DEFAULT NULL,
  `action` tinyint(4) NOT NULL DEFAULT '0',
  `id_folder` bigint(20) NOT NULL DEFAULT '0',
  `applied` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_filter`),
  KEY `AWM_FILTERS_ID_ACCT_ID_FOLDER_INDEX` (`id_acct`,`id_folder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_filters`
--

LOCK TABLES `awm_filters` WRITE;
/*!40000 ALTER TABLE `awm_filters` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_filters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_folders`
--

DROP TABLE IF EXISTS `awm_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_folders` (
  `id_folder` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_parent` bigint(20) NOT NULL DEFAULT '0',
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `full_path` varchar(255) DEFAULT NULL,
  `sync_type` tinyint(4) NOT NULL DEFAULT '0',
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `fld_order` smallint(6) NOT NULL DEFAULT '1',
  `flags` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_folder`),
  KEY `AWM_FOLDERS_ID_ACCT_ID_FOLDER_INDEX` (`id_acct`,`id_folder`),
  KEY `AWM_FOLDERS_ID_ACCT_ID_PARENT_INDEX` (`id_acct`,`id_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_folders`
--

LOCK TABLES `awm_folders` WRITE;
/*!40000 ALTER TABLE `awm_folders` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_folders_order`
--

DROP TABLE IF EXISTS `awm_folders_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_folders_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `folders_order` text,
  PRIMARY KEY (`id`),
  KEY `AWM_FOLDERS_ORDER_ID_ACCT_INDEX` (`id_acct`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_folders_order`
--

LOCK TABLES `awm_folders_order` WRITE;
/*!40000 ALTER TABLE `awm_folders_order` DISABLE KEYS */;
INSERT INTO `awm_folders_order` VALUES (1,1,'[\"INBOX\",\"Sent Messages\",\"Drafts\",\"Spam\",\"Trash\"]');
/*!40000 ALTER TABLE `awm_folders_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_folders_order_names`
--

DROP TABLE IF EXISTS `awm_folders_order_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_folders_order_names` (
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `real_name` varchar(255) NOT NULL DEFAULT '',
  `order_name` varchar(255) NOT NULL DEFAULT '',
  KEY `AWM_FOLDERS_ORDER_NAMES_ID_ACCT_INDEX` (`id_acct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_folders_order_names`
--

LOCK TABLES `awm_folders_order_names` WRITE;
/*!40000 ALTER TABLE `awm_folders_order_names` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_folders_order_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_folders_tree`
--

DROP TABLE IF EXISTS `awm_folders_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_folders_tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_folder` bigint(20) NOT NULL DEFAULT '0',
  `id_parent` bigint(20) NOT NULL DEFAULT '0',
  `folder_level` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `AWM_FOLDERS_TREE_ID_FOLDER_INDEX` (`id_folder`),
  KEY `AWM_FOLDERS_TREE_ID_FOLDER_ID_PARENT_INDEX` (`id_folder`,`id_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_folders_tree`
--

LOCK TABLES `awm_folders_tree` WRITE;
/*!40000 ALTER TABLE `awm_folders_tree` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_folders_tree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_identities`
--

DROP TABLE IF EXISTS `awm_identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_identities` (
  `id_identity` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `def_identity` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(255) NOT NULL DEFAULT '',
  `friendly_nm` varchar(255) NOT NULL DEFAULT '',
  `signature` mediumtext,
  `signature_type` tinyint(4) NOT NULL DEFAULT '1',
  `use_signature` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_identity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_identities`
--

LOCK TABLES `awm_identities` WRITE;
/*!40000 ALTER TABLE `awm_identities` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_mailaliases`
--

DROP TABLE IF EXISTS `awm_mailaliases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_mailaliases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) DEFAULT NULL,
  `alias_name` varchar(255) NOT NULL DEFAULT '',
  `alias_domain` varchar(255) NOT NULL DEFAULT '',
  `alias_to` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `AWM_MAILALIASES_ID_ACCT_INDEX` (`id_acct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_mailaliases`
--

LOCK TABLES `awm_mailaliases` WRITE;
/*!40000 ALTER TABLE `awm_mailaliases` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_mailaliases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_mailforwards`
--

DROP TABLE IF EXISTS `awm_mailforwards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_mailforwards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) DEFAULT NULL,
  `forward_name` varchar(255) NOT NULL DEFAULT '',
  `forward_domain` varchar(255) NOT NULL DEFAULT '',
  `forward_to` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `AWM_MAILFORWARDS_ID_ACCT_INDEX` (`id_acct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_mailforwards`
--

LOCK TABLES `awm_mailforwards` WRITE;
/*!40000 ALTER TABLE `awm_mailforwards` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_mailforwards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_mailinglists`
--

DROP TABLE IF EXISTS `awm_mailinglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_mailinglists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) DEFAULT NULL,
  `list_name` varchar(255) NOT NULL DEFAULT '',
  `list_to` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `AWM_MAILINGLISTS_ID_ACCT_INDEX` (`id_acct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_mailinglists`
--

LOCK TABLES `awm_mailinglists` WRITE;
/*!40000 ALTER TABLE `awm_mailinglists` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_mailinglists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_messages`
--

DROP TABLE IF EXISTS `awm_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_msg` bigint(20) NOT NULL DEFAULT '0',
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `id_folder_srv` bigint(20) NOT NULL DEFAULT '0',
  `id_folder_db` bigint(20) NOT NULL DEFAULT '0',
  `str_uid` varchar(255) DEFAULT NULL,
  `int_uid` bigint(20) NOT NULL DEFAULT '0',
  `from_msg` varchar(255) DEFAULT NULL,
  `to_msg` varchar(255) DEFAULT NULL,
  `cc_msg` varchar(255) DEFAULT NULL,
  `bcc_msg` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `msg_date` datetime DEFAULT NULL,
  `attachments` tinyint(1) NOT NULL DEFAULT '0',
  `size` bigint(20) NOT NULL DEFAULT '0',
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `flagged` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(4) NOT NULL DEFAULT '0',
  `downloaded` tinyint(1) NOT NULL DEFAULT '0',
  `x_spam` tinyint(1) NOT NULL DEFAULT '0',
  `rtl` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_full` tinyint(1) NOT NULL DEFAULT '1',
  `replied` tinyint(1) DEFAULT NULL,
  `forwarded` tinyint(1) DEFAULT NULL,
  `flags` int(11) DEFAULT NULL,
  `body_text` longtext,
  `grayed` tinyint(1) NOT NULL DEFAULT '0',
  `charset` int(11) NOT NULL DEFAULT '-1',
  `sensitivity` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `AWM_MESSAGES_ID_ACCT_ID_FOLDER_DB_INDEX` (`id_acct`,`id_folder_db`),
  KEY `AWM_MESSAGES_ID_ACCT_ID_FOLDER_DB_SEEN_INDEX` (`id_acct`,`id_folder_db`,`seen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_messages`
--

LOCK TABLES `awm_messages` WRITE;
/*!40000 ALTER TABLE `awm_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_messages_body`
--

DROP TABLE IF EXISTS `awm_messages_body`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_messages_body` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_msg` bigint(20) NOT NULL DEFAULT '0',
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `msg` longblob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `AWM_MESSAGES_BODY_ID_ACCT_ID_MSG_INDEX` (`id_acct`,`id_msg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_messages_body`
--

LOCK TABLES `awm_messages_body` WRITE;
/*!40000 ALTER TABLE `awm_messages_body` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_messages_body` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_min`
--

DROP TABLE IF EXISTS `awm_min`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_min` (
  `hash_id` varchar(32) NOT NULL DEFAULT '',
  `hash` varchar(20) NOT NULL DEFAULT '',
  `data` text,
  KEY `AWM_MIN_HASH_INDEX` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_min`
--

LOCK TABLES `awm_min` WRITE;
/*!40000 ALTER TABLE `awm_min` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_min` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_reads`
--

DROP TABLE IF EXISTS `awm_reads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_reads` (
  `id_read` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `str_uid` varchar(255) DEFAULT NULL,
  `tmp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_read`),
  KEY `AWM_READS_ID_ACCT_INDEX` (`id_acct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_reads`
--

LOCK TABLES `awm_reads` WRITE;
/*!40000 ALTER TABLE `awm_reads` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_reads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_senders`
--

DROP TABLE IF EXISTS `awm_senders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_senders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `safety` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `AWM_SENDERS_ID_USER_INDEX` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_senders`
--

LOCK TABLES `awm_senders` WRITE;
/*!40000 ALTER TABLE `awm_senders` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_senders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_settings`
--

DROP TABLE IF EXISTS `awm_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_settings` (
  `id_setting` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_subscription` int(11) NOT NULL DEFAULT '0',
  `id_helpdesk_user` int(11) NOT NULL DEFAULT '0',
  `msgs_per_page` smallint(6) NOT NULL DEFAULT '20',
  `contacts_per_page` smallint(6) NOT NULL DEFAULT '20',
  `created_time` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_now` datetime DEFAULT NULL,
  `logins_count` int(11) NOT NULL DEFAULT '0',
  `auto_checkmail_interval` int(11) NOT NULL DEFAULT '0',
  `def_skin` varchar(255) NOT NULL DEFAULT 'Default',
  `def_editor` tinyint(1) NOT NULL DEFAULT '1',
  `layout` tinyint(4) NOT NULL DEFAULT '0',
  `save_mail` tinyint(4) NOT NULL DEFAULT '0',
  `def_timezone` smallint(6) NOT NULL DEFAULT '0',
  `def_time_fmt` varchar(255) DEFAULT NULL,
  `def_lang` varchar(255) DEFAULT NULL,
  `def_date_fmt` varchar(100) NOT NULL DEFAULT 'MM/DD/YYYY',
  `mailbox_limit` bigint(20) NOT NULL DEFAULT '0',
  `incoming_charset` varchar(30) NOT NULL DEFAULT 'iso-8859-1',
  `question_1` varchar(255) DEFAULT NULL,
  `answer_1` varchar(255) DEFAULT NULL,
  `question_2` varchar(255) DEFAULT NULL,
  `answer_2` varchar(255) DEFAULT NULL,
  `sip_enable` tinyint(1) NOT NULL DEFAULT '1',
  `sip_impi` varchar(255) NOT NULL DEFAULT '',
  `sip_password` varchar(255) NOT NULL DEFAULT '',
  `twilio_number` varchar(255) NOT NULL DEFAULT '',
  `twilio_enable` tinyint(1) NOT NULL DEFAULT '1',
  `twilio_default_number` tinyint(1) NOT NULL DEFAULT '0',
  `files_enable` tinyint(1) NOT NULL DEFAULT '1',
  `helpdesk_signature` varchar(255) NOT NULL DEFAULT '',
  `helpdesk_signature_enable` tinyint(1) NOT NULL DEFAULT '0',
  `use_threads` tinyint(1) NOT NULL DEFAULT '1',
  `save_replied_messages_to_current_folder` tinyint(1) NOT NULL DEFAULT '0',
  `desktop_notifications` tinyint(1) NOT NULL DEFAULT '0',
  `allow_change_input_direction` tinyint(1) NOT NULL DEFAULT '0',
  `allow_helpdesk_notifications` tinyint(1) NOT NULL DEFAULT '0',
  `enable_open_pgp` tinyint(1) NOT NULL DEFAULT '0',
  `allow_autosave_in_drafts` tinyint(1) NOT NULL DEFAULT '1',
  `autosign_outgoing_emails` tinyint(1) NOT NULL DEFAULT '0',
  `capa` varchar(255) DEFAULT NULL,
  `client_timezone` varchar(100) NOT NULL DEFAULT '',
  `custom_fields` text,
  `email_notification` varchar(255) NOT NULL DEFAULT '',
  `password_reset_hash` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_setting`),
  UNIQUE KEY `AWM_SETTINGS_ID_USER_INDEX` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_settings`
--

LOCK TABLES `awm_settings` WRITE;
/*!40000 ALTER TABLE `awm_settings` DISABLE KEYS */;
INSERT INTO `awm_settings` VALUES (1,1,0,0,20,20,'2016-05-09 11:23:40','1970-01-01 00:00:00','2016-05-11 15:54:07',1,1,'Default',1,0,1,0,'1','English','MM/DD/YYYY',0,'iso-8859-1','','','','',1,'','','',1,0,1,'',0,1,0,0,0,0,0,1,0,'','Europe/Helsinki','','','');
/*!40000 ALTER TABLE `awm_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_social`
--

DROP TABLE IF EXISTS `awm_social`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_social` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `id_social` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `type_str` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `access_token` text,
  `refresh_token` varchar(255) DEFAULT NULL,
  `scopes` varchar(255) DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `AWM_SOCIAL_ID_ACCT_INDEX` (`id_acct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_social`
--

LOCK TABLES `awm_social` WRITE;
/*!40000 ALTER TABLE `awm_social` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_social` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_subscriptions`
--

DROP TABLE IF EXISTS `awm_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_subscriptions` (
  `id_subscription` int(11) NOT NULL AUTO_INCREMENT,
  `id_tenant` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `capa` varchar(255) NOT NULL DEFAULT '',
  `limit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_subscription`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_subscriptions`
--

LOCK TABLES `awm_subscriptions` WRITE;
/*!40000 ALTER TABLE `awm_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_system_folders`
--

DROP TABLE IF EXISTS `awm_system_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_system_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_acct` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  `folder_full_name` varchar(255) DEFAULT NULL,
  `system_type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `AWM_SYSTEM_FOLDERS_ID_ACCT_INDEX` (`id_acct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_system_folders`
--

LOCK TABLES `awm_system_folders` WRITE;
/*!40000 ALTER TABLE `awm_system_folders` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_system_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_tenant_quotas`
--

DROP TABLE IF EXISTS `awm_tenant_quotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_tenant_quotas` (
  `name` varchar(100) NOT NULL DEFAULT '',
  `quota_usage_messages` bigint(20) unsigned NOT NULL DEFAULT '0',
  `quota_usage_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  KEY `AWM_TENANT_QUOTAS_NAME_INDEX` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_tenant_quotas`
--

LOCK TABLES `awm_tenant_quotas` WRITE;
/*!40000 ALTER TABLE `awm_tenant_quotas` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_tenant_quotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_tenant_socials`
--

DROP TABLE IF EXISTS `awm_tenant_socials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_tenant_socials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tenant` int(11) DEFAULT NULL,
  `social_allow` tinyint(1) NOT NULL DEFAULT '0',
  `social_name` varchar(255) DEFAULT NULL,
  `social_id` varchar(255) DEFAULT NULL,
  `social_secret` varchar(255) DEFAULT NULL,
  `social_api_key` varchar(255) DEFAULT NULL,
  `social_scopes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_tenant_socials`
--

LOCK TABLES `awm_tenant_socials` WRITE;
/*!40000 ALTER TABLE `awm_tenant_socials` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_tenant_socials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `awm_tenants`
--

DROP TABLE IF EXISTS `awm_tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awm_tenants` (
  `id_tenant` int(11) NOT NULL AUTO_INCREMENT,
  `id_channel` int(11) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `login_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `login` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quota` int(11) NOT NULL DEFAULT '0',
  `files_usage_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_count_limit` int(11) NOT NULL DEFAULT '0',
  `domain_count_limit` int(11) NOT NULL DEFAULT '0',
  `capa` varchar(255) NOT NULL DEFAULT '',
  `allow_change_email` tinyint(1) NOT NULL DEFAULT '1',
  `allow_change_password` tinyint(1) NOT NULL DEFAULT '1',
  `expared_timestamp` int(11) unsigned NOT NULL DEFAULT '0',
  `pay_url` varchar(255) NOT NULL DEFAULT '',
  `is_trial` tinyint(1) NOT NULL DEFAULT '0',
  `hd_admin_email_account` varchar(255) NOT NULL DEFAULT '',
  `hd_client_iframe_url` varchar(255) NOT NULL DEFAULT '',
  `hd_agent_iframe_url` varchar(255) NOT NULL DEFAULT '',
  `hd_site_name` varchar(255) NOT NULL DEFAULT '',
  `hd_style_allow` tinyint(1) NOT NULL DEFAULT '0',
  `hd_style_image` varchar(255) NOT NULL DEFAULT '',
  `hd_style_text` text,
  `login_style_image` varchar(255) NOT NULL DEFAULT '',
  `app_style_image` varchar(255) NOT NULL DEFAULT '',
  `hd_facebook_allow` tinyint(1) NOT NULL DEFAULT '0',
  `hd_facebook_id` varchar(255) NOT NULL DEFAULT '',
  `hd_facebook_secret` varchar(255) NOT NULL DEFAULT '',
  `hd_google_allow` tinyint(1) NOT NULL DEFAULT '0',
  `hd_google_id` varchar(255) NOT NULL DEFAULT '',
  `hd_google_secret` varchar(255) NOT NULL DEFAULT '',
  `hd_twitter_allow` tinyint(1) NOT NULL DEFAULT '0',
  `hd_twitter_id` varchar(255) NOT NULL DEFAULT '',
  `hd_twitter_secret` varchar(255) NOT NULL DEFAULT '',
  `hd_allow_fetcher` tinyint(1) NOT NULL DEFAULT '0',
  `hd_fetcher_type` int(11) NOT NULL DEFAULT '0',
  `hd_fetcher_timer` int(11) NOT NULL DEFAULT '0',
  `social_facebook_allow` tinyint(1) NOT NULL DEFAULT '0',
  `social_facebook_id` varchar(255) NOT NULL DEFAULT '',
  `social_facebook_secret` varchar(255) NOT NULL DEFAULT '',
  `social_google_allow` tinyint(1) NOT NULL DEFAULT '0',
  `social_google_id` varchar(255) NOT NULL DEFAULT '',
  `social_google_secret` varchar(255) NOT NULL DEFAULT '',
  `social_google_api_key` varchar(255) NOT NULL DEFAULT '',
  `social_twitter_allow` tinyint(1) NOT NULL DEFAULT '0',
  `social_twitter_id` varchar(255) NOT NULL DEFAULT '',
  `social_twitter_secret` varchar(255) NOT NULL DEFAULT '',
  `social_dropbox_allow` tinyint(1) NOT NULL DEFAULT '0',
  `social_dropbox_secret` varchar(255) NOT NULL DEFAULT '',
  `social_dropbox_key` varchar(255) NOT NULL DEFAULT '',
  `sip_allow` tinyint(1) NOT NULL DEFAULT '0',
  `sip_allow_configuration` tinyint(1) NOT NULL DEFAULT '0',
  `sip_realm` varchar(255) NOT NULL DEFAULT '',
  `sip_websocket_proxy_url` varchar(255) NOT NULL DEFAULT '',
  `sip_outbound_proxy_url` varchar(255) NOT NULL DEFAULT '',
  `sip_caller_id` varchar(255) NOT NULL DEFAULT '',
  `twilio_allow` tinyint(1) NOT NULL DEFAULT '0',
  `twilio_allow_configuration` tinyint(1) NOT NULL DEFAULT '0',
  `twilio_phone_number` varchar(255) NOT NULL DEFAULT '',
  `twilio_account_sid` varchar(255) NOT NULL DEFAULT '',
  `twilio_auth_token` varchar(255) NOT NULL DEFAULT '',
  `twilio_app_sid` varchar(255) NOT NULL DEFAULT '',
  `calendar_notification_email_account` varchar(255) NOT NULL DEFAULT '',
  `invite_notification_email_account` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awm_tenants`
--

LOCK TABLES `awm_tenants` WRITE;
/*!40000 ALTER TABLE `awm_tenants` DISABLE KEYS */;
/*!40000 ALTER TABLE `awm_tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twofa_accounts`
--

DROP TABLE IF EXISTS `twofa_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twofa_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `auth_type` varchar(255) NOT NULL DEFAULT 'authy',
  `data_type` int(11) NOT NULL DEFAULT '1',
  `data_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twofa_accounts`
--

LOCK TABLES `twofa_accounts` WRITE;
/*!40000 ALTER TABLE `twofa_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `twofa_accounts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-11 18:56:17
