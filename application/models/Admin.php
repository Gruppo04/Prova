<?php

class Application_Model_Admin extends App_Model_Abstract
{
    public function __construct() {

    }
    
    /* FUNZIONI GENERICHE */
    
    public function getUtenteById($id)
    {
    	return $this->getResource('Utenti')->getUtenteById($id);
    }
    
    public function modificaUtente($info, $id)
    {
    	return $this->getResource('Utenti')->modificaUtente($info, $id);
    }
    
    public function delUtente($id)
    {
    	return $this->getResource('Utenti')->delUtente($id);
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
    
    /* FUNZIONI PER LA GESTIONE DEGLI UTENTI REGISTRATI */
    
    public function getUsers()
    {
    	return $this->getResource('Utenti')->getUsers();
    }
    
    /* FUNZIONI PER LA GESTIONE DELLO STAFF */
    
    public function registraStaff($info)
    {
    	return $this->getResource('Utenti')->registraStaff($info);
    }
    
    public function getStaff()
    {
    	return $this->getResource('Utenti')->getStaff();
    }
    
    /* FUNZIONI PER LA GESTIONE DELLE FAQ */
    
    public function getFaq()
    {
    	return $this->getResource('Faq')->getFaq();
    }

    public function getFaqById($id)
    {
    	return $this->getResource('Faq')->getFaqById($id);
    }
    
    public function registraFaq($info)
    {
    	return $this->getResource('Faq')->registraFaq($info);
    }
    
    public function modificaFaq($info, $id)
    {
    	return $this->getResource('Faq')->modificaFaq($info, $id);
    }
    
    public function delFaq($id)
    {
    	return $this->getResource('Faq')->delFaq($id);
    }
}