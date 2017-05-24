<?php

class Application_Model_Catalogo extends App_Model_Abstract
{
    public function getCatById($id)
    {
        return $this->getResource('Categoria')->getCatById($id);
    }
    
    public function getAziende()
    {
        return $this->getResource('Azienda')->getAziende();
    }
}
