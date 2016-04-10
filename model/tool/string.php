<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Tool_String {

    public static function toUrl($string) {
        $string = trim($string);
        //$string = mb_convert_encoding($string,"UTF-8", "UTF-8" );

        if (!$string || !is_string($string)) {
            return;
        }
        $string = trim(strip_tags($string));
        $tmp = preg_replace('/^[^(a-z-)]$/', '', mb_strtolower(strtr(stripslashes($string), array(
            'ą' => 'a', 'Ą' => 'a',
            'ć' => 'c', 'Ć' => 'c',
            'ę' => 'e', 'Ę' => 'e',
            'ł' => 'l', 'Ł' => 'l',
            'ń' => 'n', 'Ń' => 'n',
            'ó' => 'o', 'Ó' => 'o',
            'ś' => 's', 'Ś' => 's',
            'ż' => 'z', 'Ż' => 'z',
            'ź' => 'z', 'Ź' => 'z',
            ' ' => '-', '/' => '-',
            ',' => '.', '\'' => '',
            '"' => '', "'" => '', "\s" => '', ' ' => '', '’'=> ''
                        )), 'UTF-8'));

        //$tmp = preg_replace('/^[a-z-]/i','', $tmp);

        return $tmp;
    }

    function utf8($string) {
        return iconv("UTF-8", "UTF-8//IGNORE", strtr(trim($string),array(' '=>'')));
    }

}

/*
 * 
 *
 *
 *  '\xC4\x85'=>'a', '\xC4\x84'=>'a',
                              '\xC4\x87'=>'c', '\xC4\x86'=>'c',
                              '\xC4\x99'=>'e', '\xC4\x98'=>'e',
                              '\xC5\x82'=>'l', '\xC5\x81'=>'l',
                              '\xC5\x84'=>'n', '\xC5\x83'=>'n',
                              '\xC3\xB3'=>'o', '\xC3\x93'=>'o',
                              '\xC5\x9B'=>'s', '\xC5\x9A'=>'s',
                              '\xC5\xBC'=>'z', '\xC5\xBB'=>'z',
                              '\xC5\xBA'=>'z', '\xC5\xB9'=>'z',                              
                              ' '=>'-',        '/'=>'-' , 
                              ','=>'.' ,       '\''=>'','"'=>''      
 */