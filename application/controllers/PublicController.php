<?php

class PublicController extends Zend_Controller_Action
{
    protected $_guestModel;
    protected $_adminModel;
    protected $_userModel;
    protected $_formReg;
    protected $_formLog;
    protected $_authService;
    protected $_auth;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
        $this->_auth = Zend_Auth::getInstance();
        $this->_guestModel = new Application_Model_Guest();
        $this->_adminModel = new Application_Model_Admin();
        $this->_userModel = new Application_Model_User();
        $this->_authService = new Application_Service_Auth();
        $this->view->userForm = $this->getUserForm();
        $this->view->loginForm = $this->getLoginForm();
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
                                'aziende'=> $aziende,
                                'categorie'=>$categorie));
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
        $categorie=$this->_guestModel->getCategorie();
        $this->view->assign(array('categorie' => $categorie)); 
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
        $id = $this->getParam('selCoupon');
        $coupon = $this->_guestModel->getCouponById($id);
        $this->view->assign(array('coupon' => $coupon));
    }
    
    public function stampaAction()
    {
        $idCoupon = $this->getParam('selCoupon');
        $coupon = $this->_guestModel->getCouponById($idCoupon);
        $emissioni = $coupon->emissioni;
        $emissioni++;
        $valueCoupon = array('emissioni' => $emissioni);
        $this->_userModel->incrementaCoupon($valueCoupon, $idCoupon);
        
        $idUtente = $this->_auth->getIdentity()->id;
        $utente = $this->_adminModel->getUtenteById($idUtente);
        $acquisizioni = $utente->coupon_acquisiti;
        $acquisizioni++;
        $valueUtente = array('coupon_acquisiti' => $acquisizioni);
        $this->_userModel->incrementaUtente($valueUtente, $idUtente);
        
        $idAzienda = $coupon->idAzienda;
        $azienda = $this->_adminModel->getAziendaById($idAzienda);
        $emissAzienda = $azienda->tot_emissioni;
        $emissAzienda++;
        $valueAzienda = array('tot_emissioni' => $emissAzienda);
        $this->_userModel->incrementaAzienda($valueAzienda, $idAzienda);
        
        $idCategoria = $coupon->idCategoria;
        $categoria = $this->_adminModel->getCategoriaById($idCategoria);
        $emissCategoria = $categoria->tot_emissioni;
        $emissCategoria++;
        $valueCategoria = array('tot_emissioni' => $emissCategoria);
        $this->_userModel->incrementaCategoria($valueCategoria, $idCategoria);
        
        $datetime = date("Y-m-d H:i:s");
        $emissione = array(
            'idUtente' => $idUtente,
            'idCoupon' => $idCoupon,
            'data_emissione' => $datetime
            );
        $this->_userModel->registraEmissione($emissione);
        $this->view->assign($emissione);
        $this->_helper->layout()->disableLayout();
        $this->view->assign(array('coupon' => $coupon));
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