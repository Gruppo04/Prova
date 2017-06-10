<?php

class Application_Model_Guest extends App_Model_Abstract
{
    public function __construct()
    {
    }
    
    public function getCategorie()
    {
        return $this->getResource('Categorie')->getCategorie();
    }
    
    public function getAziende()
    {
        return $this->getResource('Aziende')->getAziende();
    }
    
    public function getFaq()
    {
        return $this->getResource('Faq')->getFaq();
    }
    
    public function registraUser($info)
    {
    	return $this->getResource('Utenti')->registraUser($info);
    }
        
    public function getUtenteByUsername($info)
    {
    	return $this->getResource('Utenti')->getUtenteByUsername($info);
    }
    
}
