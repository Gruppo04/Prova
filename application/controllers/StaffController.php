<?php

class StaffController extends Zend_Controller_Action
{	
    protected $_authService;
    protected $_staffModel;
    protected $_formCoupon;

    public function init()
    {
        $this->_helper->layout->setLayout('main');
	$this->_authService = new Application_Service_Auth();
        $this->_staffModel = new Application_Model_Staff();
        $this->view->couponForm = $this->getCouponForm();
    }

    public function indexAction()
    {
        return $this->_helper->redirector('strumenti','staff');
    }
    
    public function strumentiAction()
    {
    }

    public function logoutAction()
    {
	$this->_authService->clear();
	return $this->_helper->redirector('index','public');	
    }
    
    public function formcouponAction()
    {
    }
    
//    public function couponAction()
//    {
//        $coupon=$this->_staffModel->getCoupon();
//        $this->view->assign(array('coupon' => $coupon));
//    }
    
    public function registracouponAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('staff','formcoupon');
        }
	$formCoupon=$this->_formCoupon;
        if (!$formCoupon->isValid($_POST)) {
            return $this->render('formcoupon');
        }
        $values = $formCoupon->getValues();
       	$this->_staffModel->registraCoupon($values);
    }
    
    private function getCouponForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formCoupon = new Application_Form_Staff_Coupon();
        $this->_formCoupon->setAction($urlHelper->url(array(
                        'controller' => 'staff',
                        'action' => 'registracoupon'),
                        'default'
                        ));
        return $this->_formCoupon;
    }
    
}

