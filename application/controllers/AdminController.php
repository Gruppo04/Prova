<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_adminModel;
    protected $_utentiModel;
    protected $_authService;
    protected $_formStaff;

    /* FUNZIONI GENERICHE */
    
    public function init() {
	$this->_helper->layout->setLayout('main');
        $this->_adminModel = new Application_Model_Admin();
        $this->_utentiModel = new Application_Model_Utenti();
        $this->_authService = new Application_Service_Auth();
        $this->view->staffForm = $this->getStaffForm();
    }

    public function indexAction()
    {
        return $this->_helper->redirector('amministrazione','admin');
    }
    
    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }
    
    public function amministrazioneAction()
    {
    }
    
    /* FUNZIONI PER LA GESTIONE DELLO STAFF */
    
    public function formstaffAction()
    {
    }
    
    private function getStaffForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formStaff = new Application_Form_Admin_Formstaff();
        $this->_formStaff->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'registrastaff'),
                        'default'
                        ));
        return $this->_formStaff;
    }
    
    public function registrastaffAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('admin','formstaff');
        }
	$formStaff=$this->_formStaff;
        if (!$formStaff->isValid($_POST)) {
            return $this->render('formstaff');
        }
        $values = $formStaff->getValues();
       	$this->_utentiModel->registraStaff($values);
    }
    
    public function staffAction()
    {
        $staff=$this->_utentiModel->getStaff();
        $this->view->assign(array('staff' => $staff));
    }

    public function usersAction()
    {
        $users=$this->_utentiModel->getUsers();
        $this->view->assign(array('users' => $users));
    }
}