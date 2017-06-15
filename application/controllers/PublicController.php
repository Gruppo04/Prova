<?php

class PublicController extends Zend_Controller_Action
{
    protected $_guestModel;
    protected $_adminModel;
    protected $_userModel;
    protected $_formReg;
    protected $_formLog;
    protected $_authService;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
        $this->_guestModel = new Application_Model_Guest();
        $this->_adminModel = new Application_Model_Admin();
        $this->_userModel = new Application_Model_User();
        $this->_authService = new Application_Service_Auth();
        $this->view->userForm = $this->getUserForm();
        $this->view->loginForm = $this->getLoginForm();
        $categorie = $this->_guestModel->getCategorie();
        $this->view->assign(array('categorie' => $categorie)); 
    }
    
    public function indexAction()
    {
        $categorie= $this->_guestModel->getCategorieByTot_Emissioni();
        $aziende= $this->_guestModel->getAziendeByCoupon_Emessi();
        $coupon=$this->_guestModel->getCouponByInizioV();
        $coup=$this->_guestModel->getCouponByEmissioni();
        $this->view->assign(array(
                                'coupon' => $coupon,
                                'coup'=> $coup,
                                'aziende'=> $aziende));
    }
    
    public function aziendeAction()
    {
        $aziende = $this->_guestModel->getAziende();
        $this->view->assign(array('aziende' => $aziende));
    }
    
    public function aziendaAction()
    {
        $id = $this->getParam('selAzienda');
        $azienda=$this->_guestModel->getAziendaById($id);
        $coupon= $this->_guestModel->getCouponByAzienda($id);
        $this->view->assign(array('azienda' => $azienda,
                                  'coupon' => $coupon));
    }
    
    public function categorieAction()
    {
    }
    
    public function categoriaAction()
    {
        $id = $this->getParam('selCategoria');
        $categoria=$this->_guestModel->getCategoriaById($id);
        $coupon= $this->_guestModel->getCouponByCategoria($id);
        $this->view->assign(array('categoria' => $categoria,
                                  'coupon'=>$coupon));
    }
    
    public function faqAction() 
    { 
        $faq = $this->_guestModel->getFaq(); 
        $this->view->assign(array('faq'=> $faq));
    }
    
    public function couponAction()
    {
        $idCoupon = $this->getParam('selCoupon');
        $identita = $this->_authService->getIdentity();
        /* Controllo se c'è un utente loggato */
        if($this->_authService->getIdentity() ==! false){
            $idUtente = $this->_authService->getIdentity()->id;
            /* Controllo se l'utente ha già scaricato il coupon */
            if($this->_userModel->getEmissioneByUserCoupon($idUtente, $idCoupon)){
                $emesso = $this->_userModel->getEmissioneByUserCoupon($idUtente, $idCoupon);
            }else{
                $emesso = 0;
            }
        }else{
            $emesso = 1;
        }
        $coupon = $this->_guestModel->getCouponById($idCoupon);
        $azienda = $this->_guestModel->getAziendaById($coupon->idAzienda);
        $categoria = $this->_guestModel->getCategoriaById($coupon->idCategoria);
        $this->view->assign(array('coupon' => $coupon))
                    ->assign(array('emesso' => $emesso))
                    ->assign(array('azienda' => $azienda->nome,
                                    'idAzienda' => $azienda->id,
                                    'categoria' => $categoria->nome,
                                    'idCategoria' => $categoria->id));
    }
    
//    public function stampaAction()
//    {
//        $idCoupon = $this->getParam('selCoupon');
//        $coupon = $this->_guestModel->getCouponById($idCoupon);
//        $emissioni = $coupon->emissioni;
//        $emissioni++;
//        $valueCoupon = array('emissioni' => $emissioni);
//        $this->_userModel->incrementaCoupon($valueCoupon, $idCoupon);
//        
//        $idUtente = $this->_authService->getIdentity()->id;
//        $utente = $this->_adminModel->getUtenteById($idUtente);
//        $acquisizioni = $utente->coupon_acquisiti;
//        $acquisizioni++;
//        $valueUtente = array('coupon_acquisiti' => $acquisizioni);
//        $this->_userModel->incrementaUtente($valueUtente, $idUtente);
//        
//        $idAzienda = $coupon->idAzienda;
//        $azienda = $this->_adminModel->getAziendaById($idAzienda);
//        $emissAzienda = $azienda->tot_emissioni;
//        $emissAzienda++;
//        $valueAzienda = array('tot_emissioni' => $emissAzienda);
//        $this->_userModel->incrementaAzienda($valueAzienda, $idAzienda);
//        
//        $idCategoria = $coupon->idCategoria;
//        $categoria = $this->_adminModel->getCategoriaById($idCategoria);
//        $emissCategoria = $categoria->tot_emissioni;
//        $emissCategoria++;
//        $valueCategoria = array('tot_emissioni' => $emissCategoria);
//        $this->_userModel->incrementaCategoria($valueCategoria, $idCategoria);
//        
//        $emissione = array(
//            'idUtente' => $idUtente,
//            'idCoupon' => $idCoupon,
//            'data_emissione' => date("Y-m-d H:i:s")
//            );
//        $this->_userModel->registraEmissione($emissione);
//        $emissionenew = $this->_userModel->getEmissioneByUserCoupon($idUtente, $idCoupon)->toArray();
//        $this->view->assign($emissionenew);
//        $this->view->assign(array(
//                    'nome' => $utente->nome,
//                    'cognome' => $utente->cognome
//                    ));
//        $this->view->assign(array('coupon' => $coupon));
//        $this->_helper->layout()->disableLayout();
//    }
    
    public function loginAction()
    {
    }
    
    public function validateloginAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $loginform = new Application_Form_Public_Auth_Login();
        $response = $loginform->processAjax($_POST); 
        if ($response !== null) {
        	   $this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    public function registerAction()
    {
    }
    
    public function validateregisterAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $userform = new Application_Form_Public_User();
        $response = $userform->processAjax($_POST); 
        if ($response !== null) {
        	   $this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    public function registraAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index','public');
        }
	$formReg=$this->_formReg;
        if (!$formReg->isValid($_POST)) {
            $formReg->setDescription('Attention: some data are incorrect.');
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
            $formLog->setDescription('Attention: username and/or password are incorrect.');
            return $this->render('login');
        }
        if (false === $this->_authService->authenticate($formLog->getValues())) {
            return $this->render('login');
        }
        $livello = $this->_authService->getIdentity()->livello;
        return $this->_helper->redirector('index', $this->_authService->getIdentity()->livello);
    }
    
    public function ricercaAction()
    { 
        $textbox = $_POST['testo']; //textbox
        $filtro = $_POST['filtro']; //filtro di ricerca:categoria/coupon/entrambe
        $this->view->assign(array('filtro'=>$filtro));
        if($textbox=='')
        {
            return;
        }
        switch($filtro)
        {                 
            case 'categoria':
                $risultati = $this->_guestModel->getRicercaByCat($textbox);
                $this->view->assign(array('risultati'=>$risultati));
                break;

            case 'coupon':
                $risultati = $this->_guestModel->getRicercaByCoupon($textbox);
                $this->view->assign(array('risultati'=>$risultati));
                break;

            default:
                $risultati = array();
                $risultati['categoria']=$this->_guestModel->getRicercaByCat($textbox);
                $risultati['coupon'] = $this->_guestModel->getRicercaByCoupon($textbox);
                $this->view->assign(array(
                                   'risultati1' => $risultati['categoria'],
                                   'risultati2'  => $risultati['coupon']));
                break;
        }
    }
}