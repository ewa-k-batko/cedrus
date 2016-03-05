<?php

class Manager_Validate
{

    public static function bind($string, $how = 'strict')
    {
        if ($string === null) {
            return null;
        }
        if ($string === 'true') {
            return true;
        }
        if ($string === 'false') {
            return false;
        }

        if (ctype_digit($string)) {
            return self::stripInt($string);
        }

        $string = (string)$string;

        switch ($how) {
            case 'i':
                return self::stripInt($string);
            case 's':
                return stripslashes(strip_tags(trim($string)));
            case 'html':
                return htmlspecialchars(trim($string), ENT_QUOTES | ENT_HTML5, "UTF-8", $double_encode = true);
            case 'url':
                return rawurlencode(trim($string));
            case 'strict':
            default:
                return htmlspecialchars(stripslashes(strip_tags(trim($string))));
        }
        return false;
    }

    /**
     * uwaga to tylko uzyc dla pol formularza , nie printowac!!!!!!!!
     * @param type $name
     * @return type
     */
    public static function stripHtml($string)
    {
        return strip_tags(html_entity_decode($string, ENT_QUOTES | ENT_HTML5, "UTF-8"));
    }

    public static function stripTxt($string)
    {
        return htmlspecialchars(stripslashes(strip_tags(trim($string))), ENT_QUOTES | ENT_HTML5, "UTF-8", $double_encode = true);
    }

    public static function stripArray($string, $array)
    {
        return in_array($string, $array) ? $string : null;
    }

    /**
     * funkcje strip  to jeszcze prztetsowac czy tyle wystarczy !!!!!!!!!!
     * @return type
     */
    public static function stripInt($int)
    {
        $tmp = $int * 1;
        if ($tmp == $int) {
            return (int)$int;
        }
        return 0;
    }

}
