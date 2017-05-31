<?php

class Application_Model_Catalogo extends App_Model_Abstract
{
    public function __construct()
    {
    }
    
    public function getCategorie()
    {
        return $this->getResource('Categoria')->getCategorie();
    }
    
    public function getAziende()
    {
        return $this->getResource('Azienda')->getAziende();
    }
}
