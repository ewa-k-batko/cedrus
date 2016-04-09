<?php

/*
 * generate code of product by product data fields
 */

class Model_Tool_Code {

    /**
     * keep generated code in arary to safe unique code
     * @var array of existing codes 
     */
    private $contener = array();

    /**
     * cut letters from string
     * @param string $string - string to cut letter
     * @param string $length - length of cuting letter
     * @return string
     */
    private function cut($string, $length = 1) {
        return mb_strtoupper(mb_substr($string, 0, $length, 'UTF-8'), 'UTF-8');
    }

    /**
     * generate part of code by name
     * 
     * @param string $string
     * @return string - code
     */
    private function generate($string) {
        $tmp = explode(' ', $string);

        if (count($tmp) == 1) {
            $tmp = chunk_split($string, ceil(mb_strlen($string, 'UTF-8') / 2), ' ');
            $tmp = explode(' ', $tmp);
        }
        $res = null;
        foreach ($tmp as $z) {
            $res .= $this->cut($z);
        }
        return $res ? $res : $this->cut($string, 2);
    }

    /**
     * ad prefix to code
     * @param type $code
     * @return string prefix
     */
    private function prefix($code) {
        return 'C'.$code;
        //return date('ym') . '/' . $code;
    }

    /**
     * get unique code by names of products
     * @param Model_Plant_Container $plant
     * @return string - code
     */
    public function getCode(Model_Plant_Container $plant) {

        $code = $plant->getCategory()->getId() . '/' . 
                $this->generate($plant->getName()) . '/' . 
                $this->generate($plant->getNameLT()) . '/' . 
                $this->generate($plant->getSpecies()). '/' . 
                'P'.$plant->getPot()->getId(). '/' . 
                'H'.(int) $plant->getHeight();

        if (!isset($this->contener[$code])) {
            $this->contener[$code] = 1;
            return $this->prefix($code);
        } else {
            $this->contener[$code] += 1;
            return $this->prefix($code) . '/' . $this->contener[$code];
        }
    }

}
