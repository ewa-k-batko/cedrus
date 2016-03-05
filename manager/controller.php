<?php

set_include_path(ROOT_PATH);

/**
 * @param $class_name
 * @return bool
 */
function __autoload($class_name) {
    $n_class = $class_name;
    if (stripos($class_name, 'Module_') > 0) {
        $class_name = 'Module_' . $class_name;
    }
    $tmp = explode('_', $class_name);
    $class_name = $n_class;

    $size = count($tmp);
    $pathClass = ROOT_PATH;
    for ($i = 0; $i < $size; $i++) {
        // $tmp[$i] = str_replace(array('Manager', 'Model', 'Module'), array('manager', 'model', 'module'), $tmp[$i]);
        $pathClass .= strtolower($tmp[$i]) . '/';
    }
    $pathClass = rtrim($pathClass, '/') . '.php';
    $dev = true;
    if (isset($_SERVER['APPLICATION_ENV']) && $_SERVER['APPLICATION_ENV'] == 'production') {
        $dev = false;
    }
    if (file_exists($pathClass)) {
        require_once $pathClass;
    } else {
        //http_response_code(503);
        if ($dev) {

            debug_print_backtrace();
            echo('Path to file: ' . $pathClass . ' not found');
        }
        exit;
    }
    if (!class_exists($class_name) ) {
        if (interface_exists($class_name)) {
            return true;
        }
        if( trait_exists($class_name)) {
            return true;
        }
        // http_response_code(503);
        if ($dev) {
            echo('Class: ' . $class_name . ' not found');
        }
        exit;
    } else {
        return true;
    }
}

/**
 * Class Manager_Controller
 */
class Manager_Controller {
    /**
     * @var Manager_Config
     */
    /**
     * @var Manager_Config|Manager_Storage
     */
    /**
     * @var Manager_Config|Manager_Storage
     */

    /**
     * @var int|Manager_Config|Manager_Storage
     */
    private $config, $storage, $events, $errors, $layout;
    /**
     * @var
     */

    /**
     * @var array
     */
    private static $instance, $orderEvent;

    /**
     *
     */
    private function __construct() {
        $this->config = new Manager_Config();
        $this->storage = Manager_Storage::getInstance();
        //self::$order = $this->config->getOrderEvents();
        $this->errors = 0;
    }

    /**
     * @return array|Manager_Controller
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param Manager_Event $event
     * @return $this
     * @throws Exception
     */
    private function add(Manager_Event $event) {
        if (in_array($event->getName(), self::$orderEvent)) {
            $this->events[$event->getName()] = $event;
            return $this;
        }
        throw new Exception('brak takiej nazwy eventu w konfiguracji');
    }

    /** czy nie usunac ?? */
    /* private function get($name) {
      if (isset($this->events[$name])) {
      return $this->events[$name];
      }
      throw new Exception('brak takiej nazwy eventu w konfiguracji');
      } */

    /**
     * @return mixed
     */
    private function route() {
        $typeRoute = $this->config->getTypeRoute();
        $request = Manager_Request::getInstance();
        if ($typeRoute == Manager_Config::TYPE_ROUTE_ROUTE) {
            $route = $request->getRoute();
        } else {
            $route = $request->getModule();
        }
        return $route;
    }

    /**
     * @param $name
     */
    private function config($name) {
        include $this->config->configModule($name);
    }

    /**
     *
     */
    private function load() {
        foreach (self::$orderEvent as $name) {
            if (!isset($this->events[$name])) {
                continue;
            }
            $class = $this->events[$name]->getClass();
            $instance = new $class($this->storage);
            $instance->setIn($this->events[$name]->getIn());
            $instance->setOut($this->events[$name]->getOut());
            $instance->setTemplate($this->events[$name]->getTemplate());
            $instance->execute();
            $this->events[$name] = $instance;
        }
    }

    /**
     *
     */
    private function renderLayout() {
        $view = new Manager_View();
        $view->assign(array_merge($this->events, array('pageId' => $this->storage->pageId,
            'scripts' => $this->storage->scripts,
            'metatags' => $this->storage->metatags,
            'breadcrumbs' => $this->storage->breadcrumbs)));
        $this->events = null;
        $this->storage = null;
        //$view->render(Manager_Config::LAYOUT);$layout
        $view->render($this->layout);
    }

    /**
     * @param $map
     */
    private function changeRooteMap($map) {
        if ($this->errors < 2) {
            $this->storage->reset();
            $this->events = array();
            $this->config($map);
            $this->load();
            $this->renderLayout();
        } else {
            http_response_code(503);
            ob_end_flush();
            exit;
        }
    }

    /**
     *
     */
    public function run() {

        if (Manager_Config::isDev()) {
            $time = microtime();
        }
        ob_start(null, 0, PHP_OUTPUT_HANDLER_FLUSHABLE ^ PHP_OUTPUT_HANDLER_REMOVABLE);
        try {
            $page = $this->config->getRouteMapEvents($this->route());
            $this->config($page);
            $this->load();
            $this->renderLayout();
        } catch (Manager_Exception_NotFound $e) {
            $this->errors++;
            $this->changeRooteMap('common/config/error404');
        } catch (Manager_Exception_Unavailable $e) {
            $this->errors++;
            $this->changeRooteMap('common/config/error503');
        } catch (Manager_Config_Exception $e) {
            if (Manager_Config::isDev()) {
                echo $e->getMessage();
            }
        } catch (Exception $e) {
            $this->errors++;
            $this->changeRooteMap('common/config/error503');
        }

        ob_end_flush();

        if (Manager_Config::isDev()) {
            //echo microtime() - $time . '<br>';
            //echo round(memory_get_peak_usage(true) / 1024, 2) . '|' . round(memory_get_usage(true) / 1024, 2) . ' kB';
        }
    }

}
