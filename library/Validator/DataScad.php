<?php

class Validator_DataScad extends Zend_Validate_Abstract
{
    const DATA='dataInvalid';

    protected $_messageTemplates = array(
        self::DATA => "'%value%' is not a valid date, put another one that's not in the past"
    );    
    
    public function isValid($value){
        $this->_setValue($value);
        
        $anno= (int)substr($value,0,4);
        $mese= (int)substr($value,5,2);
        $giorno= (int)substr($value,8,2);
        $oggi= getdate();
        
        if(($anno>$oggi['year']) || ($anno===$oggi['year'] && $mese>=$oggi['mon'] && $giorno>=$oggi['mday'])){
            return true;
        }
        else{
            $this->_error(self::DATA);
            return false;
        }
    }

}

