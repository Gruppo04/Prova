<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_adminModel;
    protected $_authService;
    protected $_formStaff;
    protected $_formFaq;

    /* FUNZIONI GENERICHE */
    
    public function init() {
	$this->_helper->layout->setLayout('main');
        $this->_adminModel = new Application_Model_Admin();
        $this->_authService = new Application_Service_Auth();
        $this->view->staffForm = $this->getStaffForm();
        $this->view->faqForm = $this->getFaqForm();
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
       	$this->_adminModel->registraStaff($values);
    }
    
    public function staffAction()
    {
        $staff=$this->_adminModel->getStaff();
        $this->view->assign(array('staff' => $staff));
    }
    
    /* FUNZIONI PER LA GESTIONE DEGLI UTENTI REGISTRATI */
    
    public function usersAction()
    {
        $users=$this->_adminModel->getUsers();
        $this->view->assign(array('users' => $users));
    }
    
    /* FUNZIONI PER LA GESTIONE DELLE FAQ */
    
    public function formfaqAction()
    {
    }
    
    private function getFaqForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formFaq = new Application_Form_Admin_Formfaq();
        $this->_formFaq->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'registrafaq'),
                        'default'
                        ));
        return $this->_formFaq;
    }
    public function registrafaqAction()
    {
        $faq=$this->_adminModel->getUsers();
        $this->view->assign(array('faq' => $faq));
    }
}