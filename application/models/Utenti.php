<?php

class Application_Model_Utenti extends App_Model_Abstract
{ 

    public function __construct()
    {
    }
    
    public function registraUser($info)
    {
    	return $this->getResource('Utenti')->registraUser($info);
    }
 
}