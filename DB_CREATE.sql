CREATE TABLE cdr_plant_category (
        cpc_id int(11) NOT NULL AUTO_INCREMENT,
        cpc_name varchar(255) COLLATE utf8_polish_ci NOT NULL,
        cpc_desc text COLLATE utf8_polish_ci NOT NULL,
        cpc_url varchar(48) COLLATE utf8_polish_ci NOT NULL,
        cpc_icon varchar(48) COLLATE utf8_polish_ci NOT NULL,
        cpc_status enum('C', 'A', 'D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
        cpc_create timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        cpc_mod timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        cpc_user_create int(11) NOT NULL,
        cpc_user_mod int(11) NOT NULL,
        PRIMARY KEY (cpc_id),
        INDEX cpc_name_f_i (cpc_name)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_polish_ci PACK_KEYS = 0


###


CREATE TABLE cdr_plant_plant (
        cpp_id int(11) NOT NULL AUTO_INCREMENT,
        cpp_cpc_id int(11) NOT NULL,
        cpp_name_pl varchar(128) COLLATE utf8_polish_ci NOT NULL,
        cpp_name_lt varchar(128) COLLATE utf8_polish_ci NULL,
        cpp_desc text COLLATE utf8_polish_ci NOT NULL,
        cpp_url varchar(48) COLLATE utf8_polish_ci NOT NULL,
        cpp_icon varchar(48) COLLATE utf8_polish_ci NOT NULL,
        cpp_status enum('C', 'A', 'D') COLLATE utf8_polish_ci NOT NULL DEFAULT 'D',
        cpp_create timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        cpp_mod timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        cpp_user_create int(11) NOT NULL,
        cpp_user_mod int(11) NOT NULL,
        PRIMARY KEY (cpp_id),
        INDEX cpp_name_f_i (cpp_name_pl),
        INDEX cpp_cpc_id_f_i (cpp_cpc_id)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_polish_ci PACK_KEYS = 0

#####

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_PLANT_SET`;
CREATE PROCEDURE `PL_PLANT_SET`(
        OUT err INT,
        OUT msg TEXT,
        INOUT pl_id INTEGER,
        IN cat_id INTEGER,
        IN name_pl VARCHAR(128), 
        IN name_lt VARCHAR(128),
        IN description TEXT, 
        IN url VARCHAR(48),
        IN icon VARCHAR(48),
        IN status enum('C', 'A', 'D'), 
        IN user_create INTEGER,
        IN user_mod INTEGER
    )

SET err= 0;
SET msg= 'ok';
DECLARE EXIT HANDLER FOR SQLEXCEPTION

BEGIN  

if pl_id is null then
    insert into cdr_plant_plant (cpp_cpc_id,cpp_name_pl, cpp_name_lt,cpp_desc, cpp_url, cpp_icon, cpp_status,cpp_create,cpp_mod,cpp_user_create,cpp_user_mod ) 
    values (cat_id,name_pl,name_lt,description,url,icon,status,NOW(),NOW(),user_create,user_mod);

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
              cpp_create=  NOW(),
              cpp_mod= NOW(),
              cpp_user_create=user_create,
              cpp_user_mod=user_mod 
              where cpp_id=pl_id;
end if;


DECLARE EXIT handler for 1062 set err := -2;
DECLARE EXIT handler for 1048 set err := -3;
DECLARE EXIT handler for sqlexception set err :=  -1; 



BEGIN
GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
 @err = MYSQL_ERRNO, @msg = MESSAGE_TEXT;
SET @full_error = CONCAT("ERROR ", @err, " (", @sqlstate, "): ", @msg);
END;

SELECT pl_id, err,msg, full_error;

SELECT pl_id,  err, msg;
        
END$$
DELIMITER;

##########
CALL `plant`.`PL_PLANT_SET`(@ERR,@MSG, @CD, 1, 'TEST','' , 'DESC', 'URL', 'ICON', 'D',5, 5);

####

DELIMITER $$
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
DELIMITER ;


#####

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_CAT_UPDATE`;
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
DELIMITER ;

#####

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_CAT_ADD`;
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
DELIMITER ;


 ###########################

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_CAT_BY_ID`;
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
DELIMITER ;





###########    NIE DZIALA ######

DELIMITER $$
DROP PROCEDURE IF EXISTS `PL_CAT_ADD`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `PL_CAT_ADD`(
        IN name VARCHAR(255), 
        IN description TEXT, 
        IN url VARCHAR(48),
        IN icon VARCHAR(48),
        IN status enum('C', 'A', 'D'), 
        IN user_id INTEGER
    )
BEGIN


set @querySt =  'insert into cdr_plant_category (cpc_name, cpc_desc, cpc_url, cpc_icon, cpc_status,cpc_create,cpc_user ) values ("?","?","?","?","?",?,?);';    

prepare ps from @querySt; 
execute ps using @name, @description, @url, @icon, @status, @now_t, @user_id;
deallocate prepare ps; 
        
END$$
DELIMITER ;

#####

















brudnopis
====================


#####


























-------------
DELIMITER $$
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

set @now_t = NOW();

set @querySt =  'update cdr_plant_category set 
          cpc_name = ?,
          cpc_desc = ?,
          cpc_url = ?,
          cpc_icon = ?,
          cpc_status = ?, ';
          
          if id > 0 then
            set @querySt = concat(@querySt, 'cpc_mod=?,');
		  elseif id = 0 then
            set @querySt = concat(@querySt, 'cpc_create=?,');  
          end if;
          
         
          set @querySt = concat(@querySt, 'cpc_user=?');
          
          if id > 0 then
            set @querySt = concat(@querySt, ' where cpc_id=?');
          end if;

prepare ps from @querySt;
execute ps using @name, @desc, @url, @icon, @status, @now_t, @user_id, @id;
deallocate prepare ps; 
        
END$$
DELIMITER ;


=========================

DROP PROCEDURE IF EXISTS `categoryInsert`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `categoryInsert`(        
        IN id_parent INTEGER, 
        IN name_pl VARCHAR(100), 
        IN name_lt VARCHAR(100), 
        IN state ENUM('Y','N'), 
        IN lead VARCHAR(255),
        IN descript TEXT     
     )
BEGIN 

    INSERT INTO PL_CATEGORIES
         (           
           `PLC_ID_PARENT`,
           `PLC_NAME_PL`,
           `PLC_NAME_LT`,
           `PLC_STATUS`,
           `PLC_LEAD`,
           `PLC_DESCRIPT`                
         )
    VALUES 
         (            
           id_parent, 
           name_pl, 
           name_lt, 
           state, 
           lead,
           descript        
         ) ; 
END;

###
DROP PROCEDURE IF EXISTS `PL_CAT_LIST_ALL` ;

DELIMITER $$

CREATE
    
    PROCEDURE `plant`.`PL_CAT_LIST_BY_ID`(IN  p_id  INT(10))
   
    BEGIN
DECLARE done INT DEFAULT 0;
DECLARE p_data TEXT;
DECLARE getRows CURSOR FOR SELECT  cpc_id,cpc_name,cpc_desc,cpc_url,cpc_icon,cpc_status,cpc_create,cpc_mod,cpc_user
                                   FROM 
                                     cdr_plant_category
                                   WHERE  
                                      cpc_id = p_id                                    
                         LIMIT 0,100;
                                  
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
OPEN getRows;
outers: LOOP
FETCH getRows INTO p_data;
IF (done=1) THEN
  LEAVE outers;
END IF;
select p_data;
END LOOP outers;
CLOSE getRows;
    END$$

DELIMITER ;


###
DROP PROCEDURE IF EXISTS `PL_CAT_LIST_ALL` ;
CREATE PROCEDURE `plant`.`PL_CAT_LIST_ALL`(IN  p_id  INT(10))
READS SQL DATA
BEGIN
DECLARE done INT DEFAULT 0;
DECLARE c_id INTEGER;
DECLARE c_name VARCHAR(255);
DECLARE c_desc TEXT;
DECLARE c_url VARCHAR(48);
DECLARE c_icon VARCHAR(48); 
DECLARE c_status ENUM('C', 'A', 'D');
DECLARE c_create timestamp;
DECLARE c_mod timestamp;
DECLARE c_user INTEGER;
DECLARE getRows CURSOR FOR SELECT  cpc_id,cpc_name,cpc_desc,cpc_url,cpc_icon,cpc_status,cpc_create,cpc_mod,cpc_user
                                   FROM 
                                     cdr_plant_category              
                         LIMIT 0,100;
                                  
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
OPEN getRows;
outers: LOOP
FETCH getRows INTO c_id, c_name,c_desc, c_url, c_icon, c_status, c_create, c_mod, c_user;
IF (done=1) THEN
  LEAVE outers;
END IF;
select c_id, c_name,c_desc, c_url, c_icon, c_status, c_create, c_mod, c_user;
END LOOP outers;
CLOSE getRows;
END;



============== postgres ==================

CREATE OR REPLACE FUNCTION xxxxx (
  out err integer,
  out msg text,
  inout p_ id integer,
status text, …………
 
 
 
 
 
 
RETURNS record AS
$body$
Begin
 
  perform global_owner._ global_var_set(‘ip', ip);………..
 
……………….
 
if p_ id is null then
 
Insert ….   returning id          into p_id;
 
Else
 
Update
…………….
 
err:= 1;
  msg  := 'ok'
 
exception
  when others (???) then
err:= 11;
msg  := '['|| SQLSTATE ||']' || SQLERRM;
 
raise notice '[%] %', SQLSTATE, SQLERRM;
end;
$body$
 
 
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY DEFINER
COST 100;
 
==
 
Indices
 
Sequence
 
 
Cursor:
 
Param wejsciowe …
out   cur refcursor,
  out cur_is integer,
………………….
RETURNS record AS
$body$
declare
sql text;
begin
 
cur_is := 0; (zadeklarowany jako param wejsciowy)
 
sql := 'select………..
sql := sql || ' order………………..
……….
  open cur for execute sql  (cur zadeklarowany jako param wejsciowy)
    using  pack, (no - 1) * pack;
 
  cur_is := 1;
 
  err := 1; ………….
---

Select ….
 
where id=any(string_to_array(ids, ',')::integer[])
 
po delete:
 
GET DIAGNOSTICS i = ROW_COUNT;
 
   if i=0 then…………..
err := 0;
    err  := 'not found';
   else
    err := 1;
    msg  := 'ok';
   end if;

CREATE TRIGGER xxx
  AFTER INSERT OR UPDATE OR DELETE
  ON yyy FOR EACH ROW
  EXECUTE PROCEDURE xxx