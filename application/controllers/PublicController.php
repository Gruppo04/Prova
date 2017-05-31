<?php

class PublicController extends Zend_Controller_Action
{
    protected $_catalogoModel;
    protected $_formReg;
    protected $_formLog;
    protected $_authService;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
        $this->_catalogoModel = new Application_Model_Catalogo();
        $this->_utentiModel = new Application_Model_Utenti();
        $this->_authService = new Application_Service_Auth();
        $this->view->userForm = $this->getUserForm();
        $this->view->loginForm = $this->getLoginForm();
    }
    
    public function indexAction()
    {
    }
    
    public function aziendeAction()
    {
        $az=$this->_catalogoModel->getAziende();
        $this->view->assign(array('aziende' => $az));
    }
    
    public function viewstaticAction()
    {
    	$page = $this->_getParam('staticPage');
    	$this->render($page);
    }
    
    public function logregAction()
    {
    }
    
    public function registraAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index','public');
        }
	$formReg=$this->_formReg;
        if (!$formReg->isValid($_POST)) {
            return $this->render('logreg');
        }
        $values = $formReg->getValues();
       	$this->_utentiModel->registraUser($values);
    }
    
    private function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formLog = new Application_Form_Public_Auth_Login();
        $this->_formLog->setAction($urlHelper->url(array(
                        'controller' => 'public',
                        'action' => 'authenticate'),
                        'default'
                        ));
        return $this->_formLog;
    }
    
    private function getUserForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formReg = new Application_Form_Public_User();
        $this->_formReg->setAction($urlHelper->url(array(
                        'controller' => 'public',
                        'action' => 'registra'),
                        'default'
                        ));
        return $this->_formReg;
    }
    
    public function authenticateAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            $this->_helper->redirector('logreg','public');
        }
	$formLog = $this->_formLog;
        if (!$formLog->isValid($request->getPost())) {
            return $this->render('logreg');
        }
        if (false === $this->_authService->authenticate($formLog->getValues())) {
            return $this->render('logreg');
        }
        $livello = $this->_authService->getIdentity()->livello;
        return $this->_helper->redirector('index', $livello);
    }
}