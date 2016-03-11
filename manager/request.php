<?php

class Manager_Request
{

    private $module;
    private $route;
    private $get, $post, $raw;
    private $params;

    private static $instance;

    private function __construct()
    {
        $this->setRoute();
        $_POST = is_array($_POST) ? $_POST : array();
        $_GET = is_array($_GET) ? $_GET : array();
        $this->raw = array_merge($_GET, $_POST);
        $_POST = null;
        $_GET = null;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function stripUri($string)
    {
        $string = Manager_Validate::bind($string);

        $string = strtolower($string);
        $tmp = explode(',', $string);

        if (isset($tmp[0])) {
            $last = strrpos($tmp[0], '/');
            $this->route = substr($tmp[0], 0, $last);
            $end = substr($tmp[0], $last, strlen($tmp[0]));
            $concat = substr($end, 0, strpos($end, '-'));
            if (!empty($concat)) {
                $this->route .= $concat;
            }

            if (empty($this->route) && !empty($tmp[0])) {
                $this->route = $tmp[0];
            }

            if (empty($this->route)) {
                $this->route = '/';
            }
        } else {
            $this->route = '/';
        }

        $tmp2 = explode('/', $this->route);
        $this->module = isset($tmp2[1]) && !empty($tmp2[1]) ? $tmp2[1] : Manager_Config::ROOT_PAGE;

        unset($tmp[0]);

        $this->params = array_values($tmp);
    }

    private function setRoute()
    {

        if (isset($_SERVER['REQUEST_URI'])) {
            $this->stripUri($_SERVER['REQUEST_URI']);
            return;
        }
        if (isset($_SERVER['REDIRECT_SCRIPT_URL'])) {
            $this->stripUri($_SERVER['REDIRECT_SCRIPT_URL']);
            return;
        }
        if (isset($_SERVER['REDIRECT_URL'])) {
            $this->stripUri($_SERVER['REDIRECT_URL']);
            return;
        }
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function get($name, $how = 'html')
    {
        if (isset($this->get[$name])) {
            return $this->get[$name];
        }

        $key = array_search($name, $this->params);
        if ($key === false) {
            $this->get[$name] = null;
            return $this->get[$name];
        }

        $key2 = $key + 1;
        if (isset($this->params[$key2])) {
            $this->get[$name] = Manager_Validate::bind($this->params[$key2], $how);
            unset($this->params[$key], $this->params[$key2]);
            return $this->get[$name];
        }
    }

    public function post($name, $how = 'html')
    {
        if (isset($this->post[$name])) {
            return $this->post[$name];
        }
        if (isset($this->raw[$name])) {
            $this->post[$name] = Manager_Validate::bind($this->raw[$name], $how);
            unset($this->raw[$name]);
            return $this->post[$name];
        }
    }
    
    public function isAjax()
    { 
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}
