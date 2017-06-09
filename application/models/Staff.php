<?php

class Application_Model_Staff extends App_Model_Abstract
{
    public function __construct() {

    }
    
    public function getAziende()
    {
    	return $this->getResource('Aziende')->getAziende();
    }
    
    public function getCategorie()
    {
    	return $this->getResource('Categorie')->getCategorie();
    }
    
    public function getCoupon()
    {
    	return $this->getResource('Coupon')->getCoupon();
    }
    
    public function getCouponById($id)
    {
    	return $this->getResource('Coupon')->getCouponById($id);
    }
    public function modificaCoupon($info, $id)
    {
    	return $this->getResource('Coupon')->modificaCoupon($info, $id);
    }
    
    public function delCoupon($id)
    {
    	return $this->getResource('Coupon')->delCoupon($id);
    }
    
    public function registraCoupon($info)
    {
    	return $this->getResource('Coupon')->registraCoupon($info);
    }
}
