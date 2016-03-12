<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Model_Api_Abstract {
    
    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';
    const SORT_ID = 'c_id';
    const SORT_NAME = 'c_name';
    
    const STATUS_ACTIVE = 'A';
    const STATUS_CREATE = 'C';
    const STATUS_DELETE = 'D';

    protected $source;
    
    

    abstract public function __construct($source);

    final protected static function validObject($object, $name) {
        if ($object instanceof $name) {
            return $object;
        }
        throw new Model_Exception_NotFound();
    }

    final protected static function validList($list) {
        if ($list instanceof Model_Collection && $list->count() > 0) {
            return $list;
        }
        throw new Model_Exception_NotFound();
    }
    
    final protected static function validListAd($list) {
        if ($list instanceof Model_CollectionAd && $list->count() > 0) {
            return $list;
        }
        throw new Model_Exception_NotFound();
    }

    final protected static function validId($id) {
        $id = (int) $id;
        if ($id <= 0) {
            throw new Model_Exception_NotFound();
        }
        return $id;
    }

    final protected static function validPack($pack) {
        $pack = (int) $pack;
        if ($pack >= 0) {
            return $pack;
        }
        return 1;
    }

    final protected static function validPackSize($sizePack) {
        $sizePack = (int) $sizePack;
        if ($sizePack > 0 && $sizePack < 150) {
            return $sizePack;
        } else {
            return 10;
        }
    }
    
    final protected static function validSort($sort) {
        if(in_array($sort, array(self::SORT_ID, self::SORT_NAME))){
            return $sort;
        }
        return self::SORT_ID;
    }

    final protected static function validOrder($order) {
        if(in_array($order, array(self::ORDER_ASC, self::ORDER_DESC))){
            return $order;
        }
        return self::ORDER_ASC;
    }
    
    final protected static function validStatus($status) {
        if(in_array($status, array(self::STATUS_ACTIVE, self::STATUS_CREATE, self::STATUS_DELETE))){
            return $status;
        }
        return self::STATUS_DELETE;
    }
}