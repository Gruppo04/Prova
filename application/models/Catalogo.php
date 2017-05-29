<?php

class Application_Model_Catalog extends App_Model_Abstract
{
    public function getCatById($id)
    {
        return $this->getResource('Categoria')->getCatById($id);
    }
    
    public function getAzById($id)
    {
        return $this->getResource('Azienda')->getAzById($id);
    }
}
