<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_adminModel;
    protected $_authService;
    protected $_formStaff;
    protected $_formFaq;
    protected $_formAzienda;
    protected $_formAziendaMod;
    protected $_formCategoria;
    protected $_formCategoriaMod;
    protected $_formUserMod;

    /* FUNZIONI GENERICHE */
    
    public function init() {
	$this->_helper->layout->setLayout('main');
        $this->_adminModel = new Application_Model_Admin();
        $this->_authService = new Application_Service_Auth();
        $this->view->staffForm = $this->getStaffForm();
        $this->view->faqForm = $this->getFaqForm();
        $this->view->aziendaForm = $this->getAziendaForm();
        $this->view->aziendaModForm = $this->getAziendaModForm();
        $this->view->categoriaForm = $this->getCategoriaForm();
        $this->view->categoriaModForm = $this->getCategoriaModForm();
        $this->view->userModForm = $this->getUserModForm();
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
        $idModifica = $_GET["chosen"];
        $query = $this->_adminModel->getAziendaById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formAziendaMod->populate($query);        
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
    
    public function modificaaziendaAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('admin','formaziendamod');
        }
        $formAziendaMod=$this->_formAziendaMod;
        if (!$formAziendaMod->isValid($_POST)) {
            return $this->render('formaziendamod');
        }
        $values = array(
            'nome'=>$formAziendaMod->getValue('nome'),
            'descrizione'=>$formAziendaMod->getValue('descrizione'),
            'ragione_sociale'=>$formAziendaMod->getValue('ragione_sociale'),
            'localizzazione'=>$formAziendaMod->getValue('localizzazione'),
            'tipologia'=>$formAziendaMod->getValue('tipologia'),
            'immagine'=>$formAziendaMod->getValue('immagine'),
                );
        $idModifica = $formAziendaMod->getValue('idModifica');
        $cancella = $formAziendaMod->getValue('cancella');
        if($cancella)
        {
            $this->_adminModel->delAzienda($idModifica);
            return $this->render('cancellaazienda');
        }
       	$this->_adminModel->modificaAzienda($values, $idModifica);
        $modificata=$this->_adminModel->getAziendaById($idModifica);
        $this->view->assign(array('modificata'=>$modificata));   
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
    
    private function getAziendaModForm()
    { 
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formAziendaMod = new Application_Form_Admin_AziendaMod();
        $this->_formAziendaMod->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'modificaazienda'),
                        'default'
                        ));
        return $this->_formAziendaMod;
    }
    
    /* FUNZIONI PER LA GESTIONE DELLE CATEGORIE */
    
    public function formcategoriaAction()
    {
    }
    
    public function formcategoriamodAction()
    {
        $idModifica = $_GET["chosen"];
        $query = $this->_adminModel->getcategoriaById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formCategoriaMod->populate($query);        
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
    
    public function modificacategoriaAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('admin','formcategoriamod');
        }
        $formCategoriaMod=$this->_formCategoriaMod;
        if (!$formCategoriaMod->isValid($_POST)) {
            return $this->render('formaziendamod');
        }
        $values = array(
            'nome'=>$formCategoriaMod->getValue('nome'),
            'descrizione'=>$formCategoriaMod->getValue('descrizione'),
            'immagine'=>$formCategoriaMod->getValue('immagine'),
                );
        $idModifica = $formCategoriaMod->getValue('idModifica');
        $cancella = $formCategoriaMod->getValue('cancella');
        if($cancella)
        {
            $this->_adminModel->delCategoria($idModifica);
            return $this->render('cancellacategoria');
        }
       	$this->_adminModel->modificaCategoria($values, $idModifica);
        $modificata=$this->_adminModel->getCategoriaById($idModifica);
        $this->view->assign(array('modificata'=>$modificata));   
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
    
    private function getCategoriaModForm()
    { 
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formCategoriaMod = new Application_Form_Admin_CategoriaMod();
        $this->_formCategoriaMod->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'modificacategoria'),
                        'default'
                        ));
        return $this->_formCategoriaMod;
    }
    
    /* FUNZIONI PER LA GESTIONE DEGLI UTENTI REGISTRATI */
    
    public function usersAction()
    {
        $users=$this->_adminModel->getUsers();
        $this->view->assign(array('users' => $users));
    }
    
    private function getUserModForm()
    { 
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formUserMod = new Application_Form_Admin_UserMod();
        $this->_formUserMod->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'modificauser'),
                        'default'
                        ));
        return $this->_formUserMod;
    }
    
    public function formusermodAction()
    {
        $idModifica = $_GET["chosen"];
        $query = $this->_adminModel->getUtenteById($idModifica)->toArray();
        if($query['telefono']=='0'){
            $query['telefono']='';
        }
        $query['idModifica'] = $idModifica;
        $this->_formUserMod->populate($query);       
    }
    
    public function modificauserAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('admin','formusermod');
        }
        $formUserMod=$this->_formUserMod;
        if (!$formUserMod->isValid($_POST)) {
            return $this->render('formusermod');
        }
        $values = array(
            'nome'=>$formUserMod->getValue('nome'),
            'cognome'=>$formUserMod->getValue('cognome'),
            'genere'=>$formUserMod->getValue('genere'),
            'data_di_nascita'=>$formUserMod->getValue('data_di_nascita'),
            'provincia'=>$formUserMod->getValue('provincia'),
            'citta'=>$formUserMod->getValue('citta'),
            'email'=>$formUserMod->getValue('email'),
            'telefono'=>$formUserMod->getValue('telefono'),
            'username'=>$formUserMod->getValue('username'),
            'password'=>$formUserMod->getValue('password')
                );
        $idModifica = $formUserMod->getValue('idModifica');
        $cancella = $formUserMod->getValue('cancella');
        if($cancella)
        {
            $this->_adminModel->delUtente($idModifica);
            return $this->render('cancellauser');
        }
       	$this->_adminModel->modificaUtente($values, $idModifica);
        $modificato=$this->_adminModel->getUtenteById($idModifica);
        $this->view->assign(array('modificato'=>$modificato));   
    }
    
    /* FUNZIONI PER LA GESTIONE DELLO STAFF */
    
    public function formstaffAction()
    {
    }
        
    public function staffAction()
    {
        $staff=$this->_adminModel->getStaff();
        $this->view->assign(array('staff' => $staff));
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