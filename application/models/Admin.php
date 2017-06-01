<?php

class Application_Model_Admin extends App_Model_Abstract
{
    public function __construct() {

    }
    
    public function getUsers()
    {
    	return $this->getResource('Utenti')->getUsers();
    }
    
    public function getStaff()
    {
    	return $this->getResource('Utenti')->getStaff();
    }
    
    public function registraStaff($info)
    {
    	return $this->getResource('Utenti')->registraStaff($info);
    }

}