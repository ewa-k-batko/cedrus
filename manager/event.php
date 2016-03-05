<?php

class Manager_Event
{

    const DEFAULT_METHOD = 'execute';

    private $name, $class, $method, $template, $out, $in;

    public function __construct()
    {
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function getMethod()
    {
        return !empty($this->method) ? $this->method : self::DEFAULT_METHOD;
    }

    public function setOut($out)
    {
        $this->out = $out;
        return $this;
    }

    public function getOut()
    {
        return $this->out ? $this->out : array();
    }

    public function setIn($in)
    {
        $this->in = $in;
        return $this;
    }

    public function getIn()
    {
        return $this->in ? $this->in : array();
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }
}