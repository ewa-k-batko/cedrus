<?php

class Model_Db_Mysql {

    private static $_db,
            $_instance,
            $_cacheObj,
            $_baseName;
    public $_error;

    //private static $instance;
    //public $_rows;

    private function __construct($base, $param = null) {

        $this->_error = false;
        //polaczenie bez dodatkowych parametrow
        if ($param == null) {
            try {
                self::$_db = new mysqli($base['server'], $base['user'], $base['password']);
                //mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", self::$_db);
                self::$_baseName = $base['database'];
                if (mysqli_connect_errno()) {
                    $this->_error = true;
                    throw new Model_Db_Exception_Unavailable('Błąd podstawowego połączenia z baza DB: ' . mysqli_connect_errno() . '  :: ' . mysqli_connect_error());
                }
            } catch (Exception $e) {
                if (Manager_Config::isDev()) {
                    $this->showErrorsDB($e->getMessage());
                }
                return false;
            }
            if (false === self::$_db->set_charset("utf8")) {
                return $this->throwErrorDB(null, 'Błąd nadania kodowania: ' . $base['charset'] . ' dla bazy DB.');
            }
            if (false === self::$_db->select_db(self::$_baseName)) {
                $this->_error = true;
                return $this->throwErrorDB(null, 'Błąd nie wybrano bazy DB: ' . self::$_baseName . '.');
            }
            //parametry dodatkowe
        } elseif (is_array($param)) {
            $this->_db = mysqli_init();
            if (!is_object(self::$_db)) {
                $this->_error = true;
                return $this->throwErrorDB(null, 'Błąd zainicjowania obiektu mysqli.');
            }
            /*             * **   parametry dodatkowe ***********
              MYSQLI_OPT_CONNECT_TIMEOUT - connection timeout in seconds
              MYSQLI_OPT_LOCAL_INFILE - enable/disable use of LOAD LOCAL INFILE
              MYSQLI_INIT_COMMAND - command to execute after when connecting to MySQL server
              MYSQLI_READ_DEFAULT_FILE - Read options from named option file instead of my.cnf
              MYSQLI_READ_DEFAULT_GROUP - Read options from the named group from my.cnf or the file specified with MYSQL_READ_DEFAULT_FILE.
             */
            if (isset($param['options']) && is_array($param['options'])) {
                $size = count($param['options']);
                for ($i = 0; $i < $size; $i++) {
                    $res = $this->_db->options($param['options'][$i]['name'], $param['options'][$i]['value']);
                    if (true !== $res) {
                        $this->_error = true;
                        return $this->throwErrorDB(null, 'Błąd nadania dodatkowych opcji dla bazy DB.');
                    }
                }
            }
            /*             * **   parametry dodatkowe ***********
              MYSQLI_CLIENT_COMPRESS - Use compression protocol
              MYSQLI_CLIENT_FOUND_ROWS - return number of matched rows, not the number of affected rows
              MYSQLI_CLIENT_IGNORE_SPACE - Allow spaces after function names. Makes all function names reserved words.
              MYSQLI_CLIENT_INTERACTIVE - Allow interactive_timeout seconds (instead of wait_timeout seconds) of inactivity before closing the connection
              MYSQLI_CLIENT_SSL - Use SSL (encryption)
              np.  mysql::getInstance( array('port'=> 3306, 'socket'=>null, 'flags' =>MYSQLI_CLIENT_SSL, 'options' => array ( array( 'name'=>MYSQLI_OPT_CONNECT_TIMEOUT, 'value'=> 120)  ) ) ); dziala
             */
            $port = isset($param['port']) ? $param['port'] : 3306;
            $socket = isset($param['socket']) ? $param['socket'] : null;
            $flags = isset($param['flags']) ? $param['flags'] : null;
            self::$_db->real_connect($base['server'], $base['user'], $base['password'], self::$_baseName, $port, $socket, $flags);
            if (mysqli_connect_errno()) {
                $this->_error = true;
                $this->throwErrorDB(null, 'Błąd połączenia z baza DB: z dodatkowymi parametrami');
                return false;
            }
        } else {//gdy $param ma nieprawidlowa postac
            $this->_error = true;
            $this->showErrorsDB('nieprawidłowe parametry dla bazy DB podano: ' . $param);
            return false;
        }

        //latin2 - ISO 8859-2 Central European
        //utf8 - UTF-8 Unicode
    }

//mysql::__constructor__

    public function __destruct() {
        self::$_db->close();
    }

//mysql::__destruct

    public function closeDb() {
        self::$_db->close();
    }

//mysql::__destruct

    public static function getInstance($base, $param = null) {
        if (empty(self::$_instance)) {
            self::$_instance = new self($base, $param);
        }
        return self::$_instance;
    }

//mysql::getInstance

    public function showErrorsDB($query, $message) {
        if (Manager_Config::isDev()) {
            echo '<pre style="font-size:12px;padding:10px 40px;text-align:left;color:#1E55F5;width:100%;background:#000;">';
            echo '<br/>**************  >>  START BLEDY DB  <<   ************<br/><br/>';
            try {
                echo $message . ', MySQL error: ' . self::$_db->error . ' <br/> Query:<br/> ' . $query, self::$_db->errno;
            } catch (Exception $e) {
                echo $message;
            }
            echo '<br/><br/>*********** >>  KONIEC BLEDOW DB  <<  **************';
            echo '</pre>';
        }
    }

//mysql::showErrorsDB

    public function throwErrorDB($query = null, $message = null) {
        if (self::$_db->error) {
            /* try {
              throw new Exception( $message.' MySQL error: '.self::$_db->error.' <br/> Query:<br/> '.$aQuery,  self::$_db->errno );
              } catch( Exception $e ) {
              //printuje bledy gdy ustawienie w config na to zezwala
              if( Manager_Config::isDev() ){
              $this->showErrorsDB( "Error No: ".$e->getCode(). " - ". $e->getMessage()) ;
              $this->showErrorsDB(  nl2br( $e->getTraceAsString() ) );
              }else{
              $this->showErrorsDB( 'Wystąpił błąd prosimy ponowić' );
              }

              $this->_error = true;
              return false;
              } */

            //$this->showErrorsDB("Error No: " . $e->getCode() . " - " . $e->getMessage());
            //$this->showErrorsDB(nl2br($e->getTraceAsString()));
            //$this->showErrorsDB('Wystąpił błąd prosimy ponowić');
            $this->showErrorsDB($query, $message);
            throw new Model_Db_Exception_Unavailable();
        }
        throw new Model_Db_Exception_NotFound();
    }

//mysql::throwErrorDB

    public function _query($aQuery = null, $intVarbs = null, $outVarbs = null, $cache = 0) {

        if ($this->_error === true || $aQuery == null)
            return false;

        $stmt = self::$_db->stmt_init();

        if (false === $stmt->prepare($aQuery)) {
            return $this->throwErrorDB($aQuery, 'Błąd podczas przygotowania zapytania.');
        }
        /* i - integer
          d - double
          s - string
          b - blob
         */

        if ($intVarbs <> null) {
            $size = count($intVarbs);
            $setValue = null;
            $code = "\$stmt->bind_param(";
            $type = '"';
            $name = null;
            for ($i = 0; $i < $size; $i++) {
                $type .= $intVarbs[$i]['type']; //typty
                $temp = $intVarbs[$i]['varbl']; //nazwy zmiennych
                $name .= '$' . "$temp" . ',';
                $setValue .= '$' . "$temp" . ' = ' . $intVarbs[$i]['value'] . ';';
            }
            $name = substr($name, 0, strlen($name) - 1);
            $code .= $type . '",' . $name . ');';

            //pre($setValue, 'setValue');
            //pre($code, 'codeIn');

            $res = eval($code); //bindowanie parametrow wejsciowych

            if (false === $res)
                return $this->throwErrorDB($aQuery, 'Błąd podczas bindowania parametrów wejściowych zapytania w bazie DB.');

            eval($setValue); //przypisanie wartosci zmiennycm wejsciowym
        }

        if (false === $stmt->execute())
            return $this->throwErrorDB($aQuery, 'Błąd podczas wykonywania zapytania w bazie DB.');


        if ($outVarbs <> null) {
            $size = count($outVarbs);
            $code = "\$stmt->bind_result(";
            for ($i = 0; $i < $size; $i++) {
                $name = $outVarbs[$i];
                $code .= '$' . "$name" . ',';
            }
            $code = substr($code, 0, strlen($code) - 1);
            $code .= ');';

            //pre($code, 'codeOut');

            $res = eval($code);
            if (false === $res)
                return $this->throwErrorDB($aQuery, 'Błąd podczas bindowania parametrów wyjściowych zapytania w bazie DB.');
        } else
            return true; //brak parametrow/zmiennych wyjsciowych

        $row = null;
        $temp = null;
        while ($stmt->fetch()) {
            for ($i = 0; $i < $size; $i++)
                $temp[$outVarbs[$i]] = $$outVarbs[$i];
            $row[] = $temp;
        }
        //pre();
        //Panda_Exam::pre($row ,'wynikdb');
        $stmt->close();

        return $row;
    }

//mysql::_query

    public function simpleQuery($aQuery = null, $cache = 0) {
        if ($this->_error === true || $aQuery == null)
            return false;

        $res = self::$_db->query($aQuery, $cache);
        //var_dump($res);
        if ($res === false) {
            return $this->throwErrorDB($aQuery);
            return false;
        }
        $row = array();
        while ($obj = $res->fetch_assoc())
            $row[] = $obj;
        $res->close();
        return $row;
    }

//mysql::simpleQuery

    public function multiQuery($aQuery = null) {
        if ($this->_error === true || $aQuery == null) {
            return false;
        }

        $res = self::$_db->multi_query($aQuery);
        if ($res === false) {
            return $this->throwErrorDB($aQuery);
            return false;
        }
        $row = array();

        do {
            /* store first result set */
            if ($res = self::$_db->store_result()) {
                while ($obj = $res->fetch_object()) {
                    $row[] = $obj;
                }
                $res->free();
            }

            //$this->_db->more_results();//sprawdza czy sa nastepne rekordy
        } while (self::$_db->next_result());

        //$this->_db->close();
        return $row;
    }

//mysql::simpleQuery

    public static function propertyInCondition($arrayValue) {
        $temp = str_repeat(" ? ,", count($arrayValue));
        return substr($temp, 0, strlen($temp) - 1);
    }

//mysql::propertyInCondition
}

//mysql
?>