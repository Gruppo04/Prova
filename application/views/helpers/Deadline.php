<?php

class Zend_View_Helper_Deadline extends Zend_View_Helper_Abstract
{   
    public function deadline($scadenza) {
        $anno= (int)substr($scadenza,0,4);
        $mese= (int)substr($scadenza,5,2);
        $giorno= (int)substr($scadenza,8,2);
        $oggi= getdate();
        if(($anno>$oggi['year']) || ($anno===$oggi['year'] && $mese>=$oggi['mon'] && $giorno>=$oggi['mday'])){
            return true;
        }
        else
        {
            return false;
        }
    }
}
