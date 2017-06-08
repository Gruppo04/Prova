<?php

class Application_Model_Admin extends App_Model_Abstract
{
    public function __construct() {

    }
    
    public function getUsers()
    {
    	return $this->getResource('Utenti')->getUsers();
    }
    
    /* FUNZIONI PER LA GESTIONE DELLE AZIENDE */
    
    public function getAziende()
    {
    	return $this->getResource('Aziende')->getAziende();
    }
        
    public function getAziendaById($id)
    {
    	return $this->getResource('Aziende')->getAziendaById($id);
    }
    
    public function registraAzienda($info)
    {
    	return $this->getResource('Aziende')->registraAzienda($info);
    }
    
    public function modificaAzienda($info, $id)
    {
    	return $this->getResource('Aziende')->modificaAzienda($info, $id);
    }
    
    public function delAzienda($id)
    {
    	return $this->getResource('Aziende')->delAzienda($id);
    }

    /* FUNZIONI PER LA GESTIONE DELLE CATEGORIE */
    
    public function getCategorie()
    {
    	return $this->getResource('Categorie')->getCategorie();
    }
    
    public function getCategoriaById($id)
    {
    	return $this->getResource('Categorie')->getCategoriaById($id);
    }
    
    public function registraCategoria($info)
    {
    	return $this->getResource('Categorie')->registraCategoria($info);
    }
    
    public function modificaCategoria($info, $id)
    {
    	return $this->getResource('Categorie')->modificaCategoria($info, $id);
    }
    
    public function delCategoria($id)
    {
    	return $this->getResource('Categorie')->delCategoria($id);
    }
    
    public function registraStaff($info)
    {
    	return $this->getResource('Utenti')->registraStaff($info);
    }
    
    public function getStaff()
    {
    	return $this->getResource('Utenti')->getStaff();
    }
    
    public function registraFaq($info)
    {
    	return $this->getResource('Faq')->registraFaq($info);
    }
    
    public function getFaq()
    {
    	return $this->getResource('Faq')->getFaq();
    }

}