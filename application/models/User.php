<?php

class Application_Model_User extends App_Model_Abstract
{ 

    public function __construct()
    {
    }
    
    public function modificaPassword($values)
    {
        return $this->getResource('Utenti')->modificaPassword($values);
    }
    
}