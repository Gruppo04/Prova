<?php

class Application_Model_Staff extends App_Model_Abstract
{
    public function __construct() {

    }
    
    public function getCategorie()
    {
    	return $this->getResource('Categorie')->getCategorie();
    }
    
    public function getCoupon()
    {
    	return $this->getResource('Coupon')->getCoupon();
    }
    
    public function registraCoupon($info)
    {
    	return $this->getResource('Coupon')->registraCoupon($info);
    }
}
