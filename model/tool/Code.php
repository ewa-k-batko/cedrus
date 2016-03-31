<?php

/*
 * generate code of product by product data fields
 */

class Model_Tool_Code {
    
    private $contener = array();
    
    private function cut($string, $length=1){
      return strtoupper(substr($string,0,$length));
    }
    
    private function generate($string){
        $tmp = explode(' ', $string);
        
        if(count($tmp) == 1 ) {            
           $tmp = chunk_split($string, ceil(strlen($string)/2), ' ');
           $tmp = explode(' ', $tmp);
        }
        $res = null;
        foreach($tmp as $z) {
            $res .= $this->cut($z);
        }
        return $res ? $res : $this->cut($string,2);        
    }
    
    private function prefix($code){
        return date('ym').'/'. $code;
    }

   public function getCode($data){
       
       $code = $data[11].'/'.$this->generate($data[2]).'/'.$this->generate($data[5]).'/'.$this->generate($data[3]);      
       
        if(!isset($this->contener[$code])){
            $this->contener[$code] = 1;
            return $this->prefix($code);
        } else {
            $this->contener[$code] += 1;
            return $this->prefix($code). '/'.$this->contener[$code];            
        }
    }

}
