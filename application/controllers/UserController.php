<?php

class UserController extends Zend_Controller_Action
{	
    protected $_authService;
    protected $_userModel;
    protected $_formPassword;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
	$this->_authService = new Application_Service_Auth();
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
    
    public function formpasswordAction()
    {
    }
    
    public function passwordAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('user','formpassword');
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

