<?php

class StaffController extends Zend_Controller_Action
{	
    protected $_authService;

    public function init()
    {
        $this->_helper->layout->setLayout('main');
	$this->_authService = new Application_Service_Auth();
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
    
}

