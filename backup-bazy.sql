-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12 Mar 2016, 16:04
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `plant`
--
CREATE DATABASE IF NOT EXISTS `plant` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `plant`;

DELIMITER $$
--
-- Procedury
--
DROP PROCEDURE IF EXISTS `CSV`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CSV`(IN  p_id  INT(10))
BEGIN
DECLARE done INT DEFAULT 0;
DECLARE p_data TEXT;
DECLARE getCsvO CURSOR FOR SELECT  csv
                                   FROM 
                                     csv
                                   WHERE  
                                      id = p_id                                    
                         LIMIT 0,100;
                                  
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
OPEN getCsvO;
outers: LOOP
FETCH getCsvO INTO p_data;
IF (done=1) THEN
  LEAVE outers;
END IF;
select p_data;
END LOOP outers;
CLOSE getCsvO;
    END$$

DROP PROCEDURE IF EXISTS `PL_CAT_ADD`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_CAT_ADD`(
        IN name VARCHAR(255), 
        IN description TEXT, 
        IN url VARCHAR(48),
        IN icon VARCHAR(48),
        IN status enum('C', 'A', 'D'), 
        IN user_id INTEGER
    )
BEGIN


insert into cdr_plant_category (cpc_name, cpc_desc, cpc_url, cpc_icon, cpc_status,cpc_create,cpc_user ) 
values (name,description,url,icon,status,NOW(),user_id);    

        
END$$

DROP PROCEDURE IF EXISTS `PL_CAT_BY_ID`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_CAT_BY_ID`(
        IN id INT
    )
BEGIN
 
 set @querySt =  'SELECT  cpc_id,cpc_name,cpc_desc,cpc_url,cpc_icon,cpc_status,cpc_create,cpc_mod,cpc_user
                                   FROM 
                                     cdr_plant_category where cpc_id =?';
set @id = id;      

        prepare ps from @querySt;
        execute ps using @id;
        deallocate prepare ps;  

END$$

DROP PROCEDURE IF EXISTS `PL_CAT_LIST_ALL`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_CAT_LIST_ALL`(
        IN p_noPack INT,
        IN p_limitPack INT,
        IN p_typeSort enum('c_id','c_name','c_desc','c_status' ),
        IN p_orderSort enum('asc', 'desc')
    )
BEGIN
 
 set @querySt =  'SELECT  cpc_id,cpc_name,cpc_desc,cpc_url,cpc_icon,cpc_status,cpc_create,cpc_mod,cpc_user
                                   FROM 
                                     cdr_plant_category';
     if p_typeSort = 'c_id' then
          set @querySt = concat(@querySt, ' order by cpc_id ');
     elseif p_typeSort = 'c_name' then
          set @querySt = concat(@querySt, ' order by cpc_name ');
     elseif p_typeSort = 'c_desc' then
          set @querySt = concat(@querySt, ' order by cpc_desc ');
     elseif p_typeSort = 'c_status' then
          set @querySt = concat(@querySt, ' order by cpc_status ');    
     end if;
                                      
     if p_orderSort = 'desc' then
           set @querySt = concat(@querySt, ' desc');
     end if;     
     set @querySt = concat(@querySt, ' limit ?, ?');     
     
     set @noPack = (p_noPack-1) * p_limitPack;
     set @limitPack = p_limitPack;     

        prepare ps from @querySt;
        execute ps using @noPack, @limitPack;
        deallocate prepare ps;  

END$$

DROP PROCEDURE IF EXISTS `PL_CAT_UPDATE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_CAT_UPDATE`(
        IN id INTEGER, 
        IN name VARCHAR(255), 
        IN description TEXT, 
        IN url VARCHAR(48),
        IN icon VARCHAR(48),
        IN status enum('C', 'A', 'D'), 
        IN user_id INTEGER
    )
BEGIN  

update cdr_plant_category set 
          cpc_name = name,
          cpc_desc = description,
          cpc_url = url,
          cpc_icon = icon,
          cpc_status = status, 
          cpc_mod= NOW(),
          cpc_user=user_id 
          where cpc_id=id;
        
END$$

DROP PROCEDURE IF EXISTS `PL_PLANT_BY_ID`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_PLANT_BY_ID`(
        IN id INT
    )
BEGIN
 
 set @querySt =  'SELECT  cpp_id,cpp_cpc_id, cpp_name_pl, cpp_name_lt, cpp_desc, cpp_url, cpp_icon, cpp_status, cpp_create, cpp_mod, cpp_user_create, cpp_user_mod
                                   FROM 
                                     cdr_plant_plant where cpp_id =?';
set @id = id;      

        prepare ps from @querySt;
        execute ps using @id;
        deallocate prepare ps;  

END$$

DROP PROCEDURE IF EXISTS `PL_PLANT_LIST_ALL`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_PLANT_LIST_ALL`(
        IN p_noPack INT,
        IN p_limitPack INT,
        IN p_typeSort enum('p_id','p_cat_id','p_name_pl','p_name_lt', 'p_desc','p_status' ),
        IN p_orderSort enum('asc', 'desc')
    )
BEGIN
 
 set @querySt =  'SELECT  cpp_id,cpp_cpc_id, cpp_name_pl, cpp_name_lt, cpp_desc, cpp_url, cpp_icon, cpp_status, cpp_create, cpp_mod, cpp_user_create, cpp_user_mod
                                   FROM 
                                     cdr_plant_plant';
     if p_typeSort = 'p_id' then
          set @querySt = concat(@querySt, ' order by cpp_id ');
     elseif p_typeSort = 'p_cat_id' then
          set @querySt = concat(@querySt, ' order by cpp_cpc_id ');     
     elseif p_typeSort = 'p_name_pl' then
          set @querySt = concat(@querySt, ' order by cpp_name_pl ');
     elseif p_typeSort = 'p_name_lt' then
          set @querySt = concat(@querySt, ' order by cpp_name_lt ');     
     elseif p_typeSort = 'p_desc' then
          set @querySt = concat(@querySt, ' order by cpp_desc ');
     elseif p_typeSort = 'p_status' then
          set @querySt = concat(@querySt, ' order by cpp_status ');    
     end if;
                                      
     if p_orderSort = 'desc' then
           set @querySt = concat(@querySt, ' desc');
     end if;     
     set @querySt = concat(@querySt, ' limit ?, ?');     
     
     set @noPack = (p_noPack-1) * p_limitPack;
     set @limitPack = p_limitPack;     

        prepare ps from @querySt;
        execute ps using @noPack, @limitPack;
        deallocate prepare ps;  

END$$

DROP PROCEDURE IF EXISTS `PL_PLANT_SET`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_PLANT_SET`(       
        IN pl_id INTEGER,
        IN cat_id INTEGER,
        IN name_pl VARCHAR(128), 
        IN name_lt VARCHAR(128),
        IN description TEXT, 
        IN url VARCHAR(48),
        IN icon VARCHAR(48),
        IN status enum('C', 'A', 'D'), 
        IN user_id INTEGER
    )
BEGIN  

if pl_id = 0 then
    insert into cdr_plant_plant (cpp_cpc_id,cpp_name_pl, cpp_name_lt,cpp_desc, cpp_url, cpp_icon, cpp_status,cpp_create,cpp_user_create ) 
    values (cat_id,name_pl,name_lt,description,url,icon,status,NOW(),user_id);

    SET pl_id = LAST_INSERT_ID();
    
else
    update cdr_plant_plant set 
              cpp_cpc_id = cat_id,
              cpp_name_pl = name_pl,
              cpp_name_lt = name_lt,
              cpp_desc = description,
              cpp_url = url,
              cpp_icon = icon,
              cpp_status = status,
              cpp_mod= NOW(),
              cpp_user_mod=user_id 
              where cpp_id=pl_id;
end if;


SELECT pl_id;

        
END$$

DROP PROCEDURE IF EXISTS `TEST`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `TEST`()
BEGIN
    END$$

DROP PROCEDURE IF EXISTS `TESTRY`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `TESTRY`(IN  p_id  INT(10))
BEGIN
DECLARE done INT DEFAULT 0;
DECLARE p_data TEXT;
DECLARE getCsvO CURSOR FOR SELECT  csv
                                   FROM 
                                     csv
                                   WHERE  
                                      id = p_id                                    
                         LIMIT 0,100;
                                  
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
OPEN getCsvO;
outers: LOOP
FETCH getCsvO INTO p_data;
IF (done=1) THEN
  LEAVE outers;
END IF;
select p_data;
END LOOP outers;
CLOSE getCsvO;
    END$$

DROP PROCEDURE IF EXISTS `TESTY`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `TESTY`(IN  p_id  INT(10))
BEGIN
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cdr_plant_category`
--

DROP TABLE IF EXISTS `cdr_plant_category`;
CREATE TABLE IF NOT EXISTS `cdr_plant_category` (
  `cpc_id` int(11) NOT NULL AUTO_INCREMENT,
  `cpc_name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `cpc_desc` text COLLATE utf8_polish_ci NOT NULL,
  `cpc_url` varchar(48) COLLATE utf8_polish_ci NOT NULL,
  `cpc_icon` varchar(48) COLLATE utf8_polish_ci NOT NULL,
  `cpc_status` enum('C','A','D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
  `cpc_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpc_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpc_user` int(11) NOT NULL,
  PRIMARY KEY (`cpc_id`),
  KEY `cpc_name_f_i` (`cpc_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci PACK_KEYS=0 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cdr_plant_plant`
--

DROP TABLE IF EXISTS `cdr_plant_plant`;
CREATE TABLE IF NOT EXISTS `cdr_plant_plant` (
  `cpp_id` int(11) NOT NULL AUTO_INCREMENT,
  `cpp_cpc_id` int(11) NOT NULL,
  `cpp_name_pl` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `cpp_name_lt` varchar(128) COLLATE utf8_polish_ci DEFAULT NULL,
  `cpp_desc` text COLLATE utf8_polish_ci NOT NULL,
  `cpp_url` varchar(48) COLLATE utf8_polish_ci NOT NULL,
  `cpp_icon` varchar(48) COLLATE utf8_polish_ci NOT NULL,
  `cpp_status` enum('C','A','D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
  `cpp_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpp_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpp_user_create` int(11) NOT NULL,
  `cpp_user_mod` int(11) NOT NULL,
  PRIMARY KEY (`cpp_id`),
  KEY `cpp_name_f_i` (`cpp_name_pl`),
  KEY `cpp_cpc_id_f_i` (`cpp_cpc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci PACK_KEYS=0 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `csv`
--

DROP TABLE IF EXISTS `csv`;
CREATE TABLE IF NOT EXISTS `csv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `csv` text CHARACTER SET latin1 NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=6 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
