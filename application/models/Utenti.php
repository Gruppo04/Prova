<?php

class Application_Model_Utenti extends App_Model_Abstract
{ 

    public function __construct()
    {
    }
    
    public function registraUtente($info)
    {
    	return $this->getResource('Iscritti')->registraUtente($info);
    }
}