<?php

class Application_Model_User extends App_Model_Abstract
{ 

    public function __construct()
    {
    }
    
    public function modificaDati($values, $id)
    {
        return $this->getResource('Utenti')->modificaDati($values, $id);
    }
    
    public function modificaPassword($values, $id)
    {
        return $this->getResource('Utenti')->modificaPassword($values, $id);
    }
    
    public function incrementaCoupon($value, $id)
    {
        return $this->getResource('Coupon')->incrementaCoupon($value, $id);
    }
    
    public function incrementaUtente($value, $id)
    {
        return $this->getResource('Utenti')->incrementaUtente($value, $id);
    }
    
    public function incrementaAzienda($value, $id)
    {
        return $this->getResource('Aziende')->incrementaAzienda($value, $id);
    }
    
    public function incrementaCategoria($value, $id)
    {
        return $this->getResource('Categorie')->incrementaCategoria($value, $id);
    }
    
    public function registraEmissione($value)
    {
        return $this->getResource('Emissioni')->registraEmissione($value);
    }
}