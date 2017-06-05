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
    
    public function getFaq()
    {
    	return $this->getResource('Faq')->getFaq();
    }
    
    public function getAziende()
    {
    	return $this->getResource('Aziende')->getAziende();
    }
    
    public function getAziendaById($id)
    {
    	return $this->getResource('Aziende')->getAziendaById($id);
    }
    
    public function getCategorie()
    {
    	return $this->getResource('Categorie')->getCategorie();
    }
    
    public function registraStaff($info)
    {
    	return $this->getResource('Utenti')->registraStaff($info);
    }
    
    public function registraFaq($info)
    {
    	return $this->getResource('Faq')->registraFaq($info);
    }
    
    public function registraAzienda($info)
    {
    	return $this->getResource('Aziende')->registraAzienda($info);
    }
    
    public function registraCategoria($info)
    {
    	return $this->getResource('Categorie')->registraCategoria($info);
    }

}