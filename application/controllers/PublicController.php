<?php

class PublicController extends Zend_Controller_Action
{
    protected $_guestModel;
    protected $_formReg;
    protected $_formLog;
    protected $_authService;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
        $this->_guestModel = new Application_Model_Guest();
        $this->_authService = new Application_Service_Auth();
        $this->view->userForm = $this->getUserForm();
        $this->view->loginForm = $this->getLoginForm();
    }
    
    public function indexAction()
    {
    }
    
    public function aziendeAction()
    {
        $az=$this->_guestModel->getAziende();
        $this->view->assign(array('aziende' => $az));
    }
    
    public function categorieAction()
    {
        $cat=$this->_guestModel->getCategorie();
        $this->view->assign(array('categorie' => $cat));
    }
    
    public function faqAction() 
    { 
        $faq= $this->_guestModel->getFaq(); 
        $this->view->assign(array('faq'=> $faq));
    }
    
    public function viewstaticAction()
    {
    	$page = $this->_getParam('staticPage');
    	$this->render($page);
    }
    
    public function loginAction()
    {
    }
    
    public function registerAction()
    {
    }
    
    public function registraAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index','public');
        }
	$formReg=$this->_formReg;
        if (!$formReg->isValid($_POST)) {
            return $this->render('register');
        }
        $values = array(
            'nome'=>$formReg->getValue('nome'),
            'cognome'=>$formReg->getValue('cognome'),
            'data_di_nascita'=>$formReg->getValue('data_di_nascita'),
            'genere'=>$formReg->getValue('genere'),
            'provincia'=>$formReg->getValue('provincia'),
            'citta'=>$formReg->getValue('citta'),            
            'telefono'=>$formReg->getValue('telefono'),
            'email'=>$formReg->getValue('email'),
            'username'=>$formReg->getValue('username'),
            'password'=>$formReg->getValue('password'),
                );
        if($this->_guestModel->getUtenteByNome($values['username'])!=0) {
            return $this->formReg->addError('This username already exists');
        }
        $values['data_registrazione']=date("Y-m-d H:i:s");
        $values['livello']='user';
       	$this->_guestModel->registraUser($values);
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
            $this->_helper->redirector('login','public');
        }
	$formLog = $this->_formLog;
        if (!$formLog->isValid($request->getPost())) {
            return $this->render('login');
        }
        if (false === $this->_authService->authenticate($formLog->getValues())) {
            return $this->render('login');
        }
        $livello = $this->_authService->getIdentity()->livello;
        return $this->_helper->redirector('index', $livello);
    }
}