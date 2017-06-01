<?php

class Application_Model_Utenti extends App_Model_Abstract
{ 

    public function __construct()
    {
    }
    
    /* I due metodi successivi eseguono le stesse istruzioni, ma si è
    * scelto di separarli in quanto sono azioni concettualmente diverse */
    public function registraUser($info)
    {
    	return $this->getResource('Utenti')->registraUser($info);
    }
    
    public function registraStaff($info)
    {
    	return $this->getResource('Utenti')->registraStaff($info);
    }
    
    public function getUtenteByNome($info)
    {
    	return $this->getResource('Utenti')->getUtenteByNome($info);
    }
    
    public function getUsers()
    {
    	return $this->getResource('Utenti')->getUsers();
    }
    
    public function getStaff()
    {
    	return $this->getResource('Utenti')->getStaff();
    }
}