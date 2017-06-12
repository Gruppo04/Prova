<?php

class Application_Model_User extends App_Model_Abstract
{ 

    public function __construct()
    {
    }
    
    public function modificaDati($values, $id)
    {
        return $this->getResource('Utenti')->modificaDati($values, $id);
    }
    
    public function modificaPassword($values, $id)
    {
        return $this->getResource('Utenti')->modificaPassword($values, $id);
    }
    
}