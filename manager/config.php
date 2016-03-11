<?php

class Manager_Config {

    const ROOT_PATH = ROOT_PATH;
    const ENVIRONMENT = ENVIRONMENT;
    const DEV = 'dev';
    const DOMAIN = 'sadzonka.eu';
    const DIR_VIEW = 'Module/';
    const DIR_CONFIG = 'Config/';
    const DIR_CONFIG_MODULE = 'Module/';
    const TYPE_ROUTE_MODULE = 'Module';
    const TYPE_ROUTE_ROUTE = 'Route';
    const TYPE_ROUTE_DEFAULT = self::TYPE_ROUTE_ROUTE;
    const ROOT_PAGE = '/index';
    const ROOT_MAP_CONFIG = 'Route/Map.php';

    //const LAYOUT = 'common/view/layout.phtml';

    public static function isDev() {

        if (isset($_SERVER['APPLICATION_ENV'])) {
            return (($_SERVER['APPLICATION_ENV'] == 'production') ? false : true);
        }
        return self::ENVIRONMENT == self::DEV ? true : false;
    }

    public function getTypeRoute() {
        return self::TYPE_ROUTE_DEFAULT;
    }

    /* ublic function getOrderEvents()
      {
      return array('init', 'fluid', 'main', 'aside', 'header', 'nav', 'footer');
      } */

    public function getRouteMapEvents($route) {
        $config = include_once self::ROOT_PATH . self::ROOT_MAP_CONFIG;
        return $config;
    }

    public static function configModule($name) {
        return self::ROOT_PATH . self::DIR_CONFIG_MODULE . $name . '.php';
    }

    public static function iphotUrl() {
        if (self::isDev()) {
            return '//iphot.dv/';
        } else {
            return '//iphot.sadzonka.eu/';
        }
    }

    public static function iphotDir() {
        if (self::isDev()) {
            return self::ROOT_PATH . '/../' . 'iphot/';
        } else {
            return '../../../../../' . 'iphot/';
        }
    }

    public static function istatUrl() {
        if (self::isDev()) {
            return '//istat.dv/';
        } else {
            return '//istat.sadzonka.eu/';
        }
    }

    public static function istatDir() {
        if (self::isDev()) {
            return self::ROOT_PATH . '/../' . 'istat/';
        } else {
            return '../../../../../' . 'istat/';
        }
    }

    public static function dbCnf() {
        $cnf = parse_ini_file('/Config/cnf.ini', true);
        if (self::isDev()) {
            return $cnf['db-dv'];
        } else {
            return $cnf['db-prod'];
        }
    }

}

function pr($variable, $name = null, $color = 'fff') {
    if (!Manager_Config::isDev()) {
        return;
    }

    // Panda_Exam::vrd();
    echo '<br  style="clear:both;" />'
    . '<pre style="width:100%;clear:both;height: 100px;overflow: auto;font-size:12px;margin:10px 40px;text-align:left;;color:red;z-index:1000;width:100%;background:#000;position: fixed;bottom:0;;">';
    echo '<br/>**************************         ';
    if ($name <> null)
        echo '<span style="color:#fff;">' . $name . '</span>';


    if (is_array($variable)) {
        echo '   [tablica] *******************<br/>';
        print_r($variable);
    } elseif (is_object($variable)) {
        echo '   [object] *******************<br/>';
        print_r($variable);
    } elseif (is_bool($variable)) {
        echo '   [boolean] *******************<br/>';
        var_dump($variable);
    } else {
        if (is_string($variable))
            echo '   [string] *******************<br/>';
        elseif (is_int($variable))
            echo '   [integer] *******************<br/>';
        elseif (is_float($variable))
            echo '   [float] *******************<br/>';
        elseif (is_null($variable))
            echo '   [null] *******************<br/>';
        else
            echo '   [nierozpoznany] *******************<br/>';
        echo $variable;
    }
    echo '<br/>********************************************************* <br/>';
    echo '</pre>';
}
