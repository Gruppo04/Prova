<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_adminModel;
    protected $_staffModel;
    protected $_guestModel;
    protected $_authService;
    protected $_formStaff;
    protected $_formStaffMod;
    protected $_formFaq;
    protected $_formFaqMod;
    protected $_formAzienda;
    protected $_formAziendaMod;
    protected $_formCategoria;
    protected $_formCategoriaMod;

    /* FUNZIONI GENERICHE */
    
    public function init() {
	$this->_helper->layout->setLayout('main');
        $this->_adminModel = new Application_Model_Admin();
        $this->_staffModel = new Application_Model_Staff();
        $this->_guestModel = new Application_Model_Guest();
        $this->_authService = new Application_Service_Auth();
        $this->view->staffForm = $this->getStaffForm();
        $this->view->staffModForm = $this->getStaffModForm();
        $this->view->faqForm = $this->getFaqForm();
        $this->view->faqModForm = $this->getFaqModForm();
        $this->view->aziendaForm = $this->getAziendaForm();
        $this->view->aziendaModForm = $this->getAziendaModForm();
        $this->view->categoriaForm = $this->getCategoriaForm();
        $this->view->categoriaModForm = $this->getCategoriaModForm();
        $categorie=$this->_guestModel->getCategorie();
        $this->view->assign(array('categorie' => $categorie));
    }

    public function indexAction()
    {
        return $this->_helper->redirector('amministrazione', 'admin');
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
        if(!$idModifica)
        {
            $this->_helper->redirector('aziende', 'admin');
        }
        $query = $this->_adminModel->getAziendaById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formAziendaMod->populate($query);        
    }
    
    public function aziendeAction()
    {
        $aziende=$this->_adminModel->getAziende();
        $size = count($aziende->toArray());
        $this->view->assign(array('aziende' => $aziende))
                    ->assign(array('numero' => $size));
    }
    
    public function registraaziendaAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formazienda','admin');
        }
	$formAzienda=$this->_formAzienda;
        if (!$formAzienda->isValid($_POST)) {
            return $this->render('formazienda');
        }
        $values = $formAzienda->getValues();
       	$this->_adminModel->registraAzienda($values);
        $aggiunta=$this->_adminModel->getAziendaByNome($formAzienda->getValue('nome'));
        $this->view->assign(array('aggiunta'=>$aggiunta));
    }
    
    public function modificaaziendaAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formaziendamod','admin');
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
            'tipologia'=>$formAziendaMod->getValue('tipologia')
                );
        $immagine = $formAziendaMod->getValue('nuovaimmagine');
        /* Se durante la modifica non è stata aggiunta un'immagine significa che si
        * deve mantenere quella precedente */
        if($immagine){
            $values['immagine'] = $immagine;
        }else{
            $values['immagine'] = $formAziendaMod->getValue('immagine');
        }
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
        if(!$idModifica)
        {
            $this->_helper->redirector('categorie', 'admin');
        }
        $query = $this->_adminModel->getcategoriaById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formCategoriaMod->populate($query);        
    }
    
    public function categorieAction()
    {
        $categorie=$this->_adminModel->getCategorie();
        $size = count($categorie->toArray());
        $this->view->assign(array('categorie' => $categorie))
                    ->assign(array('numero' => $size));
    }
    
    public function registracategoriaAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formcategoria','admin');
        }
	$formCategoria=$this->_formCategoria;
        if (!$formCategoria->isValid($_POST)) {
            return $this->render('formcategoria');
        }
        $values = $formCategoria->getValues();
       	$this->_adminModel->registraCategoria($values);
        $aggiunta=$this->_adminModel->getCategoriaByNome($formCategoria->getValue('nome'));
        $this->view->assign(array('aggiunta'=>$aggiunta));
    }
    
    public function modificacategoriaAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formcategoriamod','admin');
        }
        $formCategoriaMod=$this->_formCategoriaMod;
        if (!$formCategoriaMod->isValid($_POST)) {
            return $this->render('formcategoriamod');
        }
        $values = array(
            'nome'=>$formCategoriaMod->getValue('nome'),
            'descrizione'=>$formCategoriaMod->getValue('descrizione')
                );
        $immagine = $formCategoriaMod->getValue('nuovaimmagine');
        /* Se durante la modifica non è stata aggiunta un'immagine significa che si
        * deve mantenere quella precedente */
        if($immagine){
            $values['immagine'] = $immagine;
        }else{
            $values['immagine'] = $formCategoriaMod->getValue('immagine');
        }
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
        $size = count($users->toArray());
        $this->view->assign(array('users' => $users))
                    ->assign(array('numero' => $size));
    }
    
    public function userstodeleteAction()
    {
        $users=$this->_adminModel->getUsers();
        $size = count($users->toArray());
        $this->view->assign(array('users' => $users))
                    ->assign(array('numero' => $size));
    }
    
    public function cancellauserAction()
    {
        $idModifica = $_GET["chosen"];
        if(!$idModifica)
        {
            $this->_helper->redirector('users', 'admin');
        }
        $this->_adminModel->delUtente($idModifica);  
    }
    
    /* FUNZIONI PER LA GESTIONE DELLO STAFF */
    
    public function formstaffAction()
    {
    }
        
    public function formstaffmodAction()
    {
        $idModifica = $_GET["chosen"];
        if(!$idModifica)
        {
            $this->_helper->redirector('staff', 'admin');
        }
        $query = $this->_adminModel->getUtenteById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formStaffMod->populate($query);       
    }
    
    public function staffAction()
    {
        $staff = $this->_adminModel->getStaff();
        $size = count($staff->toArray());
        $this->view->assign(array('staff' => $staff))
                    ->assign(array('numero' => $size));
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
    
    private function getStaffModForm()
    { 
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formStaffMod = new Application_Form_Admin_StaffMod();
        $this->_formStaffMod->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'modificastaff'),
                        'default'
                        ));
        return $this->_formStaffMod;
    }

    public function registrastaffAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formstaff', 'admin');
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
        $aggiunto=$this->_adminModel->getUtenteByUsername($formStaff->getValue('username'));
        $this->view->assign(array('aggiunto'=>$aggiunto));
    }
    
    public function modificastaffAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formstaffmod', 'admin');
        }
        $formStaffMod=$this->_formStaffMod;
        if (!$formStaffMod->isValid($_POST)) {
            return $this->render('formstaffmod');
        }
        $values = array(
            'nome'=>$formStaffMod->getValue('nome'),
            'cognome'=>$formStaffMod->getValue('cognome'),
            'email'=>$formStaffMod->getValue('email'),
            'username'=>$formStaffMod->getValue('username'),
            'password'=>$formStaffMod->getValue('password')
                );
        $idModifica = $formStaffMod->getValue('idModifica');
        $cancella = $formStaffMod->getValue('cancella');
        if($cancella)
        {
            $this->_adminModel->delUtente($idModifica);
            return $this->render('cancellastaff');
        }
       	$this->_adminModel->modificaDati($values, $idModifica);
        $modificato=$this->_adminModel->getUtenteById($idModifica);
        $this->view->assign(array('modificato'=>$modificato));   
    }
    /* FUNZIONI PER LA GESTIONE DELLE PROMOZIONI */
    
    public function couponAction()
    {
        $coupon = $this->_staffModel->getCoupon()->toArray();
        $size = count($coupon);
        for ($i=0; $i<$size; $i++)
        {
            $azienda = $this->_adminModel->getAziendaById($coupon[$i]['idAzienda']);
            $categoria = $this->_adminModel->getCategoriaById($coupon[$i]['idCategoria']);
            $coupon[$i]['azienda'] = $azienda->nome;
            $coupon[$i]['categoria'] = $categoria->nome;
        }
        $this->view->assign(array('coupon' => $coupon))
                    ->assign(array('numero' => $size));
    }
    
    public function emissioniAction()
    {
        $emissioni = $this->_adminModel->getEmissioni()->toArray();
        $size = count($emissioni);
        for ($i=0; $i<$size; $i++)
        {
            $datetime = $emissioni[$i]['data_emissione'];
            $id = $emissioni[$i]['id'];
            $coupon = $this->_adminModel->getAziendaById($emissioni[$i]['idCoupon']);
            $utente = $this->_adminModel->getUtenteById($emissioni[$i]['idUtente']);
            $emissione[$i] = array(
                'id' => $id,
                'coupon' => $coupon->nome,
                'nome' => $utente->nome,
                'cognome' => $utente->cognome,
                'username' => $utente->username,
                'datetime' => $datetime);
        }
        $this->view->assign(array('emissione' => $emissione))
                    ->assign(array('numero' => $size));
    }
    
    /* FUNZIONI PER LA GESTIONE DELLE FAQ */    
        
    public function faqAction()
    {
        $faq=$this->_adminModel->getFaq();
        $this->view->assign(array('faq' => $faq));
    }
    
    public function formfaqAction()
    {
    }
    
    public function formfaqmodAction()
    {
        $idModifica = $_GET["chosen"];
        if(!$idModifica)
        {
            $this->_helper->redirector('faq', 'admin');
        }
        $query = $this->_adminModel->getFaqById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formFaqMod->populate($query);
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
    
    public function getFaqModForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formFaqMod = new Application_Form_Admin_FaqMod();
        $this->_formFaqMod->setAction($urlHelper->url(array(
                        'controller' => 'admin',
                        'action' => 'modificafaq'),
                        'default'
                        ));
        return $this->_formFaqMod;
    }
    
    public function registrafaqAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formfaq', 'admin');
        }
	$formFaq=$this->_formFaq;
        if (!$formFaq->isValid($_POST)) {
            return $this->render('formfaq');
        }
        $values = $formFaq->getValues();
       	$this->_adminModel->registraFaq($values);
    }

    public function modificafaqAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('forfaqmod', 'admin');
        }
        $formFaqMod=$this->_formFaqMod;
        if (!$formFaqMod->isValid($_POST)) {
            return $this->render('forfaqmod');
        }
        $values = array(
            'domanda'=>$formFaqMod->getValue('domanda'),
            'risposta'=>$formFaqMod->getValue('risposta')
                );
        $idModifica = $formFaqMod->getValue('idModifica');
        $cancella = $formFaqMod->getValue('cancella');
        if($cancella)
        {
            $this->_adminModel->delFaq($idModifica);
            return $this->render('cancellafaq');
        }
       	$this->_adminModel->modificaFaq($values, $idModifica);
    }
}