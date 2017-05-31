<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_adminModel;
    protected $_authService;

    public function init() {
	$this->_helper->layout->setLayout('main');
        $this->_adminModel = new Application_Model_Admin();
        $this->_authService = new Application_Service_Auth();
    }

    public function indexAction()
    {
        return $this->_helper->redirector('index','public');
    }

    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }

}