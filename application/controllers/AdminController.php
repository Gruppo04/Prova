<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_adminModel;
    protected $_authService;
    protected $_formStaff;

    public function init() {
	$this->_helper->layout->setLayout('main');
        $this->_adminModel = new Application_Model_Admin();
        $this->_authService = new Application_Service_Auth();
        $this->view->staffForm = $this->getStaffForm();
    }

    public function indexAction()
    {
        return $this->_helper->redirector('index','public');
    }

    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }
    
    public function amministrazioneAction()
    {
    }
    
    public function formstaffAction()
    {
    }
    
    private function getStaffForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formStaff = new Application_Form_Admin_Formstaff();
        $this->_formStaff->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => ''),
                        'default'
                        ));
        return $this->_formStaff;
    }

}