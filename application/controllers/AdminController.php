<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_adminModel;
    protected $_authService;
    protected $_formStaff;
    protected $_formFaq;
    protected $_formAzienda;
    protected $_aziendaModForm;
    protected $_formCategoria;
    public $_id;

    /* FUNZIONI GENERICHE */
    
    public function init() {
	$this->_helper->layout->setLayout('main');
        $this->_adminModel = new Application_Model_Admin();
        $this->_authService = new Application_Service_Auth();
        $this->view->staffForm = $this->getStaffForm();
        $this->view->faqForm = $this->getFaqForm();
        $this->view->aziendaForm = $this->getAziendaForm();
        //$this->view->aziendaModForm = $this->getAziendaModForm(1);
        $this->view->categoriaForm = $this->getCategoriaForm();
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
    
    /* FUNZIONI PER LA GESTIONE DELLE AZIENDE */
    
    public function formaziendaAction()
    {
    }
    
    public function formaziendamodAction()
    {
        $idmodifica = $_POST;
        return $this->view->aziendaModForm = $this->getAziendaModForm($idmodifica); 
    }
    
    public function aziendeAction()
    {
        $aziende=$this->_adminModel->getAziende();
        $this->view->assign(array('aziende' => $aziende));
    }
    
    public function registraaziendaAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('admin','formazienda');
        }
	$formAzienda=$this->_formAzienda;
        if (!$formAzienda->isValid($_POST)) {
            return $this->render('formazienda');
        }
        $values = $formAzienda->getValues();
       	$this->_adminModel->registraAzienda($values);
    }
    
    private function getAziendaForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formAzienda = new Application_Form_Admin_Azienda();
        $this->_formAzienda->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'registraazienda'),
                        'default'
                        ));
        return $this->_formAzienda;
    }
    
    private function getAziendaModForm($id)
    { 
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formAzienda = new Application_Form_Admin_AziendaMod();
        $this->_formAzienda->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'modificaazienda'),
                        'default'
                        ));
        //$id = $_POST;
        $query = $this->_adminModel->getAziendaById($id)->toArray();
        $this->_formAzienda->populate($query);
        return $this->_formAzienda;
    }
    
    /* FUNZIONI PER LA GESTIONE DELLE CATEGORIE */
    
    public function formcategoriaAction()
    {
    }
    
    public function categorieAction()
    {
        $categorie=$this->_adminModel->getCategorie();
        $this->view->assign(array('categorie' => $categorie));
    }
    
    public function registracategoriaAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('admin','formcategoria');
        }
	$formCategoria=$this->_formCategoria;
        if (!$formCategoria->isValid($_POST)) {
            return $this->render('formcategoria');
        }
        $values = $formCategoria->getValues();
       	$this->_adminModel->registraCategoria($values);
    }
    
    private function getCategoriaForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formCategoria = new Application_Form_Admin_Categoria();
        $this->_formCategoria->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'registracategoria'),
                        'default'
                        ));
        return $this->_formCategoria;
    }
    
    /* FUNZIONI PER LA GESTIONE DEGLI UTENTI REGISTRATI */
    
    public function usersAction()
    {
        $users=$this->_adminModel->getUsers();
        $this->view->assign(array('users' => $users));
    }
    
    /* FUNZIONI PER LA GESTIONE DELLO STAFF */
    
    public function formstaffAction()
    {
    }
    
    private function getStaffForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formStaff = new Application_Form_Admin_Staff();
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
        $values = array(
            'nome'=>$formStaff->getValue('nome'),
            'cognome'=>$formStaff->getValue('cognome'),
            'email'=>$formStaff->getValue('email'),
            'username'=>$formStaff->getValue('username'),
            'password'=>$formStaff->getValue('password'),
                );
        $values['data_registrazione']=date("Y-m-d H:i:s");
        $values['livello']='staff';
       	$this->_adminModel->registraStaff($values);
    }
    
    public function staffAction()
    {
        $staff=$this->_adminModel->getStaff();
        $this->view->assign(array('staff' => $staff));
    }
    
    /* FUNZIONI PER LA GESTIONE DELLE PROMOZIONI */
    
    /* FUNZIONI PER LA GESTIONE DELLE FAQ */
    
    public function formfaqAction()
    {
    }
    
    private function getFaqForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formFaq = new Application_Form_Admin_Faq();
        $this->_formFaq->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'registrafaq'),
                        'default'
                        ));
        return $this->_formFaq;
    }
    
    public function registrafaqAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('admin','formfaq');
        }
	$formFaq=$this->_formFaq;
        if (!$formFaq->isValid($_POST)) {
            return $this->render('formfaq');
        }
        $values = $formFaq->getValues();
       	$this->_adminModel->registraFaq($values);
    }
    
    public function faqAction()
    {
        $faq=$this->_adminModel->getFaq();
        $this->view->assign(array('faq' => $faq));
    }

}