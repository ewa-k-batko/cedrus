CREATE TABLE `cdr_plant_category` (
  `cpc_id` int(11) NOT NULL AUTO_INCREMENT,
  `cpc_name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `cpc_desc` text COLLATE utf8_polish_ci NOT NULL,
  `cpc_gal_id` int(11) DEFAULT NULL,
  `cpc_icon` varchar(48) COLLATE utf8_polish_ci NOT NULL,
  `cpc_status` enum('C','A','D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
  `cpc_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpc_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpc_user_create` int(11) NOT NULL,
  `cpc_user_mod` int(11) NOT NULL,
  PRIMARY KEY (`cpc_id`),
  UNIQUE KEY `cpc_name_f_i` (`cpc_name`),
  KEY `cpc_gal_id` (`cpc_gal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci PACK_KEYS=0;


 ####



DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_CATEGORY_SET`;
CREATE PROCEDURE `PL_CATEGORY_SET`( 
        IN cat_id INTEGER,
        IN name_pl VARCHAR(255),
        IN description TEXT, 
        IN gal_id INTEGER,
        IN icon VARCHAR(48),
        IN status enum('C', 'A', 'D'), 
        IN user_id INTEGER
    )
BEGIN  

if cat_id = 0 then    
    
    insert into cdr_plant_category (cpc_name, cpc_desc, cpc_gal_id, cpc_icon, cpc_status,cpc_create,cpc_user_create ) 
    values (name_pl,description,gal_id,icon,status,NOW(),user_id);

    SET cat_id = LAST_INSERT_ID();
    
else
    update cdr_plant_category set 
          cpc_name = name_pl,
          cpc_desc = description,
          cpc_gal_id = gal_id,
          cpc_icon = icon,
          cpc_status = status, 
          cpc_mod= NOW(),
          cpc_user_mod=user_id 
          where cpc_id=cat_id;
end if;


SELECT cat_id;

        
END$$
DELIMITER ;


####

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_CATEGORY_LIST_ALL`;
CREATE PROCEDURE `PL_CATEGORY_LIST_ALL`(
        IN p_pack INT,
        IN p_limit INT,
        IN p_type_sort enum('c_id','c_name','c_desc','c_status' ),
        IN p_order_sort enum('asc', 'desc')
    )
BEGIN
 
 set @querySt =  'SELECT  cpc_id,cpc_name,cpc_desc,cpc_gal_id,cpc_icon,cpc_status,cpc_create,cpc_mod,cpc_user_create,cpc_user_mod
                                   FROM 
                                     cdr_plant_category';
     if p_type_sort = 'c_id' then
          set @querySt = concat(@querySt, ' order by cpc_id ');
     elseif p_type_sort = 'c_name' then
          set @querySt = concat(@querySt, ' order by cpc_name ');
     elseif p_type_sort = 'c_desc' then
          set @querySt = concat(@querySt, ' order by cpc_desc ');
     elseif p_type_sort = 'c_status' then
          set @querySt = concat(@querySt, ' order by cpc_status ');    
     end if;
                                      
     if p_order_sort = 'desc' then
           set @querySt = concat(@querySt, ' desc');
     end if;     
     set @querySt = concat(@querySt, ' limit ?, ?');     
     
     set @noPack = (p_pack-1) * p_limit;
     set @limitPack = p_limit;     

        prepare ps from @querySt;
        execute ps using @noPack, @limitPack;
        deallocate prepare ps;  

END$$
DELIMITER ;

###

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_CATEGORY_BY_ID`;
CREATE PROCEDURE `PL_CATEGORY_BY_ID`(
        IN id INT
    )
BEGIN
 
set @querySt =  'SELECT  cpc_id,cpc_name,cpc_desc,cpc_gal_id,cpc_icon,cpc_status,cpc_create,cpc_mod,cpc_user_create,cpc_user_mod
                                   FROM 
                                     cdr_plant_category where cpc_id =?';
set @id = id;      

        prepare ps from @querySt;
        execute ps using @id;
        deallocate prepare ps;  

END$$
DELIMITER ;

#########################

CREATE TABLE `cdr_plant_plant` (
  `cpp_id` int(11) NOT NULL AUTO_INCREMENT,
  `cpp_no_isn` varchar(48) COLLATE utf8_polish_ci NOT NULL,
  `cpp_cpc_id` int(11) NOT NULL,
  `cpp_gal_id` int(11) DEFAULT NULL,
  `cpp_pot_id` int(11) NOT NULL,
  `cpp_name_pl` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `cpp_name_lt` varchar(128) COLLATE utf8_polish_ci DEFAULT NULL,
  `cpp_species` varchar(48) COLLATE utf8_polish_ci NOT NULL,
  `cpp_desc` text COLLATE utf8_polish_ci NOT NULL,
  `cpp_height` int(4) NOT NULL,
  `cpp_icon` varchar(48) COLLATE utf8_polish_ci NOT NULL,
  `cpp_price` varchar(7) DEFAULT NULL,
  `cpp_status` enum('C','A','D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
  `cpp_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpp_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpp_user_create` int(11) NOT NULL,
  `cpp_user_mod` int(11) NOT NULL,
  PRIMARY KEY (`cpp_id`),
  UNIQUE KEY `cpp_no_isn_u_i` (`cpp_no_isn`),
  UNIQUE KEY `cpp_name_sp_u_i` (`cpp_name_pl`, `cpp_species`),
  KEY `cpp_cpc_id_f_i` (`cpp_cpc_id`) ,
  KEY `cpp_gal_id_f_i` (`cpp_gal_id`),
  KEY `cpp_pot_id_f_i` (`cpp_pot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci PACK_KEYS=0;


###

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_PLANT_BY_ID`;
CREATE PROCEDURE `PL_PLANT_BY_ID`(
        IN id INT
    )
BEGIN
 
set @querySt =  'SELECT cpp_id,cpp_no_isn,cpp_cpc_id, cpp_gal_id, cpp_pot_id, cpp_name_pl, cpp_name_lt, cpp_desc, cpp_height,cpp_icon,cpp_price,cpp_status,cpp_create, cpp_mod, cpp_user_create, cpp_user_mod
                FROM cdr_plant_plant where cpp_id =?';
set @id = id;      

        prepare ps from @querySt;
        execute ps using @id;
        deallocate prepare ps;  

END$$
DELIMITER ;


###

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_PLANT_LIST_ALL`;
CREATE PROCEDURE `PL_PLANT_LIST_ALL`(
        IN p_pack INT,
        IN p_limit INT,
        IN p_type_sort enum('p_id','p_cat_id','p_name_pl','p_name_lt', 'p_desc','p_status' ),
        IN p_order_sort enum('asc', 'desc')
    )
BEGIN
 
set @querySt =  'SELECT cpp_id,cpp_no_isn,cpp_cpc_id, cpp_gal_id, cpp_pot_id, cpp_name_pl, cpp_name_lt, cpp_desc, cpp_height, cpp_icon, cpp_price, cpp_status, cpp_create, cpp_mod, cpp_user_create, cpp_user_mod
                  FROM cdr_plant_plant';
     if p_type_sort = 'p_id' then
          set @querySt = concat(@querySt, ' order by cpp_id ');
     elseif p_type_sort = 'p_cat_id' then
          set @querySt = concat(@querySt, ' order by cpp_cpc_id ');     
     elseif p_type_sort = 'p_name_pl' then
          set @querySt = concat(@querySt, ' order by cpp_name_pl ');
     elseif p_type_sort = 'p_name_lt' then
          set @querySt = concat(@querySt, ' order by cpp_name_lt ');     
     elseif p_type_sort = 'p_desc' then
          set @querySt = concat(@querySt, ' order by cpp_desc ');
     elseif p_type_sort = 'p_status' then
          set @querySt = concat(@querySt, ' order by cpp_status ');    
     end if;
                                      
     if p_order_sort = 'desc' then
           set @querySt = concat(@querySt, ' desc');
     end if;     
     set @querySt = concat(@querySt, ' limit ?, ?');     
     
     set @noPack = (p_pack-1) * p_limit;
     set @limitPack = p_limit;     

        prepare ps from @querySt;
        execute ps using @noPack, @limitPack;
        deallocate prepare ps;  

END$$
DELIMITER ;

###

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_PLANT_SET`;
CREATE PROCEDURE `PL_PLANT_SET`(       
        IN pl_id INTEGER,
        IN no_isn VARCHAR(48),
        IN cat_id INTEGER,
        IN gal_id INTEGER,
        IN pot_id INTEGER,
        IN name_pl VARCHAR(128), 
        IN name_lt VARCHAR(128),
        IN species VARCHAR(48),
        IN description TEXT, 
        IN height INTEGER,
        IN icon VARCHAR(48),
        IN price VARCHAR(7),
        IN status enum('C', 'A', 'D'), 
        IN user_id INTEGER
    )
BEGIN  

if pl_id = 0 then
    insert into cdr_plant_plant (cpp_no_isn,cpp_cpc_id, cpp_gal_id, cpp_pot_id, cpp_name_pl, cpp_name_lt, cpp_species, cpp_desc, cpp_height, cpp_icon, cpp_price, cpp_status,cpp_create,cpp_user_create ) 
    values (no_isn,cat_id,gal_id,pot_id,name_pl,name_lt,species,description,height,icon,price,status,NOW(),user_id);

    SET pl_id = LAST_INSERT_ID();
    
else
    update cdr_plant_plant set 
              cpp_no_isn = no_isn,
              cpp_cpc_id = cat_id,
              cpp_gal_id = gal_id,
              cpp_pot_id = pot_id,
              cpp_name_pl = name_pl,
              cpp_name_lt = name_lt,
              cpp_species = species,
              cpp_desc = description,
              cpp_height = height,
              cpp_icon = icon,
              cpp_price = price,
              cpp_status = status,
              cpp_mod= NOW(),
              cpp_user_mod=user_id 
              where cpp_id=pl_id;
end if;


SELECT pl_id;

        
END$$
DELIMITER ;

####

CREATE TABLE `cdr_plant_pot` (
  `cpt_id` int(11) NOT NULL AUTO_INCREMENT,
  `cpt_name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `cpt_desc` text COLLATE utf8_polish_ci NOT NULL,
  `cpt_color` varchar(28) COLLATE utf8_polish_ci DEFAULT NULL,
  `cpt_height` int(4) NOT NULL,
  `cpt_diameter` int(4) NOT NULL,
  `cpt_status` enum('C','A','D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
  `cpt_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpt_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpt_user_create` int(11) NOT NULL,
  `cpt_user_mod` int(11) NOT NULL,
  PRIMARY KEY (`cpt_id`),
  UNIQUE KEY `cpt_name_f_i` (`cpt_name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci PACK_KEYS=0;


###

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_POT_BY_ID`;
CREATE PROCEDURE `PL_POT_BY_ID`(
        IN id INT
    )
BEGIN
 set @querySt =  'SELECT cpt_id, cpt_name, cpt_desc, cpt_color,cpt_height,cpt_diameter,cpt_status,cpt_create, cpt_mod, cpt_user_create, cpt_user_mod
                FROM cdr_plant_pot where cpt_id =?';
set @id = id;      

        prepare ps from @querySt;
        execute ps using @id;
        deallocate prepare ps;  

END$$
DELIMITER ;


###

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_POT_LIST_ALL`;
CREATE PROCEDURE `PL_POT_LIST_ALL`(
        IN p_pack INT,
        IN p_limit INT,
        IN p_type_sort enum('p_id','p_name','p_status' ),
        IN p_order_sort enum('asc', 'desc')
    )
BEGIN
 
set @querySt =  'SELECT cpt_id, cpt_name, cpt_desc, cpt_color,cpt_height,cpt_diameter,cpt_status,cpt_create, cpt_mod, cpt_user_create, cpt_user_mod
                  FROM cdr_plant_pot';
     if p_type_sort = 'p_id' then
          set @querySt = concat(@querySt, ' order by cpt_id ');    
     elseif p_type_sort = 'p_name' then
          set @querySt = concat(@querySt, ' order by cpt_name ');
     elseif p_type_sort = 'p_status' then
          set @querySt = concat(@querySt, ' order by cpt_status ');    
     end if;
                                      
     if p_order_sort = 'desc' then
           set @querySt = concat(@querySt, ' desc');
     end if;     
     set @querySt = concat(@querySt, ' limit ?, ?');     
     
     set @noPack = (p_pack-1) * p_limit;
     set @limitPack = p_limit;     

        prepare ps from @querySt;
        execute ps using @noPack, @limitPack;
        deallocate prepare ps;  

END$$
DELIMITER ;

###

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_POT_SET`;
CREATE PROCEDURE `PL_POT_SET` (       
IN p_id INTEGER,
IN p_name VARCHAR(255),
IN description TEXT, 
IN color VARCHAR(28),
IN height INTEGER,
IN diameter INTEGER,
IN p_status enum('C', 'A', 'D'), 
IN user_id INTEGER

)
BEGIN  

if p_id = 0 then
insert into cdr_plant_pot (cpt_name, cpt_desc, cpt_color,cpt_height,cpt_diameter, cpt_status,cpt_create,cpt_user_create )  
values (p_name,description,color,height,diameter,p_status,NOW(),user_id);

SET p_id = LAST_INSERT_ID();
    
else
    update cdr_plant_pot set 
              cpt_name = p_name,
              cpt_desc = description,
              cpt_color = color,
              cpt_height = height,
              cpt_diameter = diameter,
              cpt_status = p_status,
              cpt_mod= NOW(),
              cpt_user_mod=user_id 
              where cpt_id=p_id;
end if;

SELECT p_id;        
END$$
DELIMITER ;

####

CREATE TABLE `cdr_stuff` (
  `csf_id` int(11) NOT NULL AUTO_INCREMENT,
  `csf_name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `csf_desc` text COLLATE utf8_polish_ci NOT NULL,
  `csf_type` enum('G','N','M','A', 'T') COLLATE utf8_polish_ci NOT NULL DEFAULT 'G',
  `csf_status` enum('C','A','D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
  `csf_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `csf_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `csf_user_create` int(11) NOT NULL,
  `csf_user_mod` int(11) NOT NULL,
  PRIMARY KEY (`csf_id`),
  UNIQUE KEY `csf_name_f_i` (`csf_name`),
  KEY `csf_type_f_i` (`csf_type`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci PACK_KEYS=0;

###

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_STUFF_BY_ID`;
CREATE PROCEDURE `PL_STUFF_BY_ID`(
IN id INT
)
BEGIN
set @querySt =  'SELECT csf_id, csf_name, csf_desc, csf_type,csf_status,csf_create, csf_mod, csf_user_create, csf_user_mod
                FROM cdr_stuff where csf_id =?';
set @id = id;      

        prepare ps from @querySt;
        execute ps using @id;
        deallocate prepare ps;  

END$$
DELIMITER ;


####

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_STUFF_LIST_ALL`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_STUFF_LIST_ALL`(
IN p_type enum('G','N','M','A', 'T'),
IN p_pack INT,
IN p_limit INT,
IN p_type_sort enum('p_id','p_name','p_status' ),
IN p_order_sort enum('asc', 'desc')
)
BEGIN
 
set @querySt =  'SELECT csf_id, csf_name, csf_desc, csf_status,csf_create, csf_mod, csf_user_create, csf_user_mod
                  FROM cdr_stuff where csf_type = ? ';
     if p_type_sort = 'p_id' then
          set @querySt = concat(@querySt, ' order by csf_id ');    
     elseif p_type_sort = 'p_name' then
          set @querySt = concat(@querySt, ' order by csf_name ');
     elseif p_type_sort = 'p_status' then
          set @querySt = concat(@querySt, ' order by csf_status ');    
     end if;
                                      
     if p_order_sort = 'desc' then
           set @querySt = concat(@querySt, ' desc');
     end if;   
     
      set @p_type = p_type;
     
     set @querySt = concat(@querySt, ' limit ?, ?'); 
     
     
     set @noPack = (p_pack-1) * p_limit;
     set @limitPack = p_limit;  
    

        prepare ps from @querySt;
        execute ps using  @p_type, @noPack, @limitPack;
        deallocate prepare ps;  

END$$
DELIMITER ;

####

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_STUFF_SET`;
CREATE PROCEDURE `PL_STUFF_SET` (       
IN p_id INTEGER,
IN p_name VARCHAR(255),
IN description TEXT, 
IN p_type enum('G','N','M','A', 'T'),
IN p_status enum('C', 'A', 'D'), 
IN user_id INTEGER
)
BEGIN  

if p_id = 0 then
insert into cdr_stuff (csf_name, csf_desc, csf_type, csf_status,csf_create,csf_user_create )  
values (p_name,description,p_type,p_status,NOW(),user_id);

SET p_id = LAST_INSERT_ID();
    
else
    update cdr_stuff set 
              csf_name = p_name,
              csf_desc = description,
              csf_type = p_type,
              csf_status = p_status,
              csf_mod= NOW(),
              csf_user_mod=user_id 
              where csf_id=p_id;
end if;

SELECT p_id;        
END$$
DELIMITER ;

####

CREATE TABLE `cdr_photo` (
  `cph_id` int(11) NOT NULL AUTO_INCREMENT,
  `cph_name` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `cph_desc` text COLLATE utf8_polish_ci NOT NULL,
  `cph_file_src` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `cph_file_width` int(4) NOT NULL,
  `cph_file_height` int(4) NOT NULL,
  `cph_file_size` int(6) NOT NULL,
  `cph_file_ext` int(4) NOT NULL,
  `cph_status` enum('C','A','D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
  `cph_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cph_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cph_user_create` int(11) NOT NULL,
  `cph_user_mod` int(11) NOT NULL,
  PRIMARY KEY (`cph_id`),
  UNIQUE KEY `cph_file_src_f_i` (`cph_file_src`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci PACK_KEYS=0;


####

CREATE TABLE `cdr_gallery_bind` (
  `cbi_id` int(11) NOT NULL AUTO_INCREMENT,
  `cbi_csf_id` int(11) NOT NULL,
  `cbi_cph_id` int(11) NOT NULL,
  `cbi_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cbi_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cbi_user_create` int(11) NOT NULL,
  `cbi_user_mod` int(11) NOT NULL,
  PRIMARY KEY (`cbi_id`),
  UNIQUE KEY `cdr_gallery_bind_u_i` (`cbi_csf_id`,`cbi_cph_id`),
  KEY `cdr_gallery_bind_parent_id_f_i` (`cbi_csf_id`),
  KEY `cdr_gallery_bind_child_id_f_i` (`cbi_cph_id`),
  CONSTRAINT `cdr_gallery_bind_fk1` FOREIGN KEY (`cbi_csf_id`) REFERENCES `cdr_stuff` (`csf_id`),
  CONSTRAINT `cdr_gallery_bind_fk2` FOREIGN KEY (`cbi_cph_id`) REFERENCES `cdr_photo` (`cph_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 PACK_KEYS=0;


#####

