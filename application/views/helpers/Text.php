<?php

class Zend_View_Helper_Text extends Zend_View_Helper_Abstract
{   
    public function text($descrizione) {
        $descbreve= substr($descrizione, 0,100);
        $descfinale= $descbreve . '...';
        return $descfinale;
    }
}
