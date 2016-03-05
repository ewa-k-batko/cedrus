<?php

use Zend\Captcha\Image as CaptchaImage;

class Model_Form_Captcha {

    private static $instance;
    private $captcha, $generate;

    public function __construct(array $option = array()) {
        
        $this->captcha = new CaptchaImage(array(
            'font' => Manager_Config::istatDir() . 'fonts/f/Ubuntu/Ubuntu-MediumItalic.ttf',
            'name' => isset($option['name']) ? $option['name'] : 'captcha',
            'width' => isset($option['width']) ? $option['width'] : 220,
            'height' => isset($option['height']) ? $option['height'] : 80,
            'wordLen' => isset($option['wordLen']) ? $option['wordLen'] : 5,
            'timeout' => isset($option['timeout']) ? $option['timeout'] : 300,
            'dotNoiseLevel' => 40,
            'lineNoiseLevel' =>  4)
        );
        $this->captcha->setImgDir(Manager_Config::istatDir(). 'captcha/c');
        $this->captcha->setImgUrl(Manager_Config::istatUrl() . 'captcha/c');
        $this->captcha->setImgAlt('Kod z obrazka');
        
    }

    public static function getInstance(array $option = array()) {
        if (self::$instance instanceof self) {
           return self::$instance;             
        }
        self::$instance = new self($option);
        return self::$instance; 
    }

    public function get() {
        if ($this->generate === true) {
            return $this->captcha;
        }
        $this->captcha->generate();
        $this->generate = true;
        return $this->captcha;
    }

    public static function isValid($id, $word) {
        $captcha = new CaptchaImage();
        if ($captcha->isValid(array('id' => $id, 'input' => $word))) {
            return true;
        }
        return false;
    }

}
