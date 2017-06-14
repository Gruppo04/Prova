<?php

class UserController extends Zend_Controller_Action
{	
    protected $_authService;
    protected $_adminModel;
    protected $_userModel;
    protected $_guestModel;
    protected $_formPassword;
    protected $_formDati;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
	$this->_authService = new Application_Service_Auth();
        $this->_adminModel = new Application_Model_Admin();
        $this->_userModel = new Application_Model_User();
        $this->_guestModel = new Application_Model_Guest();
        $this->_formDati = new Application_Form_User_Dati();
        $this->_formPassword = new Application_Form_User_Password();
        $this->view->datiForm = $this->getDatiForm();
        $this->view->passwordForm = $this->getPasswordForm();
        $categorie=$this->_guestModel->getCategorie();
        $this->view->assign(array('categorie' => $categorie));
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
        $idModifica = $this->_authService->getIdentity()->id;
        $select = $this->_adminModel->getUtenteById($idModifica);
        if($select['telefono']=='0'){
            $select['telefono']='';
        }
        $this->view->assign(array('dati' => $select));
    }
    
    public function formdatiAction()
    {
        $idModifica = $this->_authService->getIdentity()->id;
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
        $values = $formDati->getValues();
        $idModifica = $this->_authService->getIdentity()->id;
       	$this->_userModel->modificaDati($values, $idModifica);
        $modificato=$this->_adminModel->getUtenteById($idModifica);
        $this->view->assign(array('modificato'=>$modificato));
    }
    
    public function modificapasswordAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formpassword','user');
        }
	$formPassword=$this->_formPassword;
        if (!$formPassword->isValid($_POST)) {
            return $this->render('formpassword');
        }
        $values = $formPassword->getValues();
        if($values['old_password'] != ($this->_authService->getIdentity()->password))
        {
            return $this->render('errorepassword');
        }
        $idModifica = $this->_authService->getIdentity()->id;
       	$this->_userModel->modificaPassword(array('password' => $values['password']), $idModifica);
        $this->_authService->clear();
    }
    
    private function getDatiForm()
    { 
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formDati->setAction($urlHelper->url(array(
                        'controller' => 'user',
                        'action' => 'modificadati'),
                        'default'
                        ));
        return $this->_formDati;
    }
    
    private function getPasswordForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formPassword->setAction($urlHelper->url(array(
                        'controller' => 'user',
                        'action' => 'modificapassword'),
                        'default'
                        ));
        return $this->_formPassword;
    }
}

