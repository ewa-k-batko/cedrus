<?php
use Zend\Form\Element\Csrf as Csrf;

class Model_Form_Csrf {

    private static $instance;
    private $csrf;

    public function __construct(array $option = array()) {
        $this->csrf = new Csrf(isset($option['name']) ? $option['name'] : 'token', array('options' => array('csrf_options' => array(
                    'timeout' => isset($option['timeout']) ? $option['timeout'] : 600,
                    'salt' => isset($option['salt']) ? $option['salt'] : 'unique'
        ))));
    }

    public static function getInstance(array $option = array()) {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        self::$instance = new self($option);
        return self::$instance;
    }

    public function get() {
        return $this->csrf;
    }

    public function isValid($token) {
        if ($this->csrf->getCsrfValidator()->isValid($token)) {
            return true;
        }
        return false;
    }

}
