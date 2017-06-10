<?php

class UserController extends Zend_Controller_Action
{	
    protected $_authService;
    protected $_userModel;
    protected $_formPassword;
    protected $_formDati;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
	$this->_authService = new Application_Service_Auth();
        $this->view->datiForm = $this->getDatiForm();
        $this->view->passwordForm = $this->getPasswordForm();
    }

    public function indexAction()
    {
        return $this->_helper->redirector('index','public');
    }  

    public function logoutAction()
    {
	$this->_authService->clear();
	return $this->_helper->redirector('index','public');	
    }
    
    public function profiloAction()
    {
    }
    
    private function getDatiForm()
    { 
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formDati = new Application_Form_User_Dati();
        $this->_formDati->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'modificadati'),
                        'default'
                        ));
        return $this->_formDati;
    }
    
    public function formdatiAction()
    {
        $query = $this->_adminModel->getUtenteById($idModifica)->toArray();
        if($query['telefono']=='0'){
            $query['telefono']='';
        }
        $query['idModifica'] = $idModifica;
        $this->_formDati->populate($query);       
    }
    
    public function formpasswordAction()
    {
    }
    
    public function modificadatiAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formdati','user');
        }
        $formDati=$this->_formDati;
        if (!$formDati->isValid($_POST)) {
            return $this->render('formdati');
        }
        $values = $formAziendaMod->getValues();
        $username = $formAziendaMod->getValues();
       	$this->_adminModel->modificaAzienda($values, $idModifica);
        $modificata=$this->_adminModel->getAziendaById($idModifica);
        $this->view->assign(array('modificata'=>$modificata));
    }
    
    public function passwordAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formpassword','user');
        }
	$formPassword=$this->_formPassword;
        if (!$formPassword->isValid($_POST)) {
            return $this->render('formpassword');
        }
        $values = array(
            'old_password' => $formPassword->getValue('old_password'),
            'password' => $formPassword->getValue('password'));
        $this->_userModel->checkPassword($values['old_password']);
       	$this->_userModel->modificaPassword($values);
    }
    
    private function getPasswordForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formPassword = new Application_Form_User_Password();
        $this->_formPassword->setAction($urlHelper->url(array(
                        'controller' => 'user',
                        'action' => 'password'),
                        'default'
                        ));
        return $this->_formPassword;
    }
    
}

