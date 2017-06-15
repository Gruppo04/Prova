<?php

class StaffController extends Zend_Controller_Action
{	
    protected $_authService;
    protected $_staffModel;
    protected $_adminModel;
    protected $_guestModel;
    protected $_formCoupon;
    protected $_formCouponMod;
    protected $_formPassword;
    protected $_formDati;

    public function init()
    {
        $this->_helper->layout->setLayout('main');
	$this->_authService = new Application_Service_Auth();
        $this->_staffModel = new Application_Model_Staff();
        $this->_adminModel = new Application_Model_Admin();
        $this->_guestModel = new Application_Model_Guest();
        $this->_formDati = new Application_Form_Staff_Dati();
        $this->_formPassword = new Application_Form_Staff_Password();
        $this->view->couponForm = $this->getCouponForm();
        $this->view->couponModForm = $this->getCouponModForm();
        $this->view->datiForm = $this->getDatiForm();
        $this->view->passwordForm = $this->getPasswordForm();
        $categorie=$this->_guestModel->getCategorie();
        $this->view->assign(array('categorie' => $categorie));
    }

    public function indexAction()
    {
        return $this->_helper->redirector('strumenti','staff');
    }
    
    public function strumentiAction()
    {
    }

    public function logoutAction()
    {
	$this->_authService->clear();
	return $this->_helper->redirector('index','public');	
    }
    
    public function formcouponAction()
    {
    }
    
    public function formcouponmodAction()
    {
        $idModifica = $_GET["chosen"];
        if(!$idModifica)
        {
            $this->_helper->redirector('coupon', 'staff');
        }
        $query = $this->_staffModel->getCouponById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formCouponMod->populate($query);
    }
    
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
        $this->view->assign(array('coupon' => $coupon));
    }
    
    public function registracouponAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formcoupon','staff');
        }
	$formCoupon=$this->_formCoupon;
        if (!$formCoupon->isValid($_POST)) {
            $formCoupon->setDescription('Attention: some data are incorrect.');
            return $this->render('formcoupon');
        }
        $values = $formCoupon->getValues();
       	$this->_staffModel->registraCoupon($values);
    }
    
    public function validatecouponAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $userform = new Application_Form_Staff_Coupon();
        $response = $userform->processAjax($_POST); 
        if ($response !== null) {
        	   $this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    public function modificacouponAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formcouponmod','staff');
        }
        $formCouponMod=$this->_formCouponMod;
        if (!$formCouponMod->isValid($_POST)) {
            $formDati->setDescription('Attention: some modifications are incorrect.');
            return $this->render('formcouponmod');
        }
        $values = array(
            'nome'=>$formCouponMod->getValue('nome'),
            'descrizione'=>$formCouponMod->getValue('descrizione'),
            'inizio_validita'=>$formCouponMod->getValue('inizio_validita'),
            'scadenza'=>$formCouponMod->getValue('scadenza'),
            'luogo_di_fruizione'=>$formCouponMod->getValue('luogo_di_fruizione'),
            'idCategoria'=>$formCouponMod->getValue('idCategoria'),
            'idAzienda'=>$formCouponMod->getValue('idAzienda'),
            'emissioni'=>$formCouponMod->getValue('emissioni'),
            'immagine'=>$formCouponMod->getValue('immagine')
                );
        $idModifica = $formCouponMod->getValue('idModifica');
        $cancella = $formCouponMod->getValue('cancella');
        if($cancella)
        {
            $this->_staffModel->delCoupon($idModifica);
            return $this->render('cancellacoupon');
        }
       	$this->_staffModel->modificaCoupon($values, $idModifica);
        $modificato=$this->_staffModel->getCouponById($idModifica);
        $this->view->assign(array('modificata'=>$modificata));   
    }
    
    public function validatemodcouponAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $userform = new Application_Form_Staff_CouponMod();
        $response = $userform->processAjax($_POST); 
        if ($response !== null) {
        	   $this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    private function getCouponForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formCoupon = new Application_Form_Staff_Coupon();
        $this->_formCoupon->setAction($urlHelper->url(array(
                        'controller' => 'staff',
                        'action' => 'registracoupon'),
                        'default'
                        ));
        return $this->_formCoupon;
    }
    
    private function getCouponModForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formCouponMod = new Application_Form_Staff_CouponMod();
        $this->_formCouponMod->setAction($urlHelper->url(array(
                        'controller' => 'staff',
                        'action' => 'modificacoupon'),
                        'default'
                        ));
        return $this->_formCouponMod;
    }
    
    public function formdatiAction()
    {
        $idModifica = $this->_authService->getIdentity()->id;
        $query = $this->_adminModel->getUtenteById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formDati->populate($query);       
    }
    
    public function formpasswordAction()
    {
    }
    
    public function modificadatiAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formdati','staff');
        }
        $formDati=$this->_formDati;
        if (!$formDati->isValid($_POST)) {
            $formDati->setDescription('Attention: some modifications are incorrect.');
            return $this->render('formdati');
        }
        $values = $formDati->getValues();
        $idModifica = $this->_authService->getIdentity()->id;
       	$this->_userModel->modificaDati($values, $idModifica);
        $modificato=$this->_adminModel->getUtenteById($idModifica);
        $this->view->assign(array('modificato'=>$modificato));
    }
    
    public function validatedatiAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $userform = new Application_Form_Staff_Dati();
        $response = $userform->processAjax($_POST); 
        if ($response !== null) {
        	   $this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    public function modificapasswordAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formpassword','staff');
        }
	$formPassword=$this->_formPassword;
        if (!$formPassword->isValid($_POST)) {
            $formDati->setDescription('Attention: some modifications are incorrect.');
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
    
    public function validatepassAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $userform = new Application_Form_Staff_Password();
        $response = $userform->processAjax($_POST); 
        if ($response !== null) {
        	   $this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    private function getDatiForm()
    { 
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formDati->setAction($urlHelper->url(array(
                        'controller' => 'staff',
                        'action' => 'modificadati'),
                        'default'
                        ));
        return $this->_formDati;
    }
    
    
    private function getPasswordForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formPassword->setAction($urlHelper->url(array(
                        'controller' => 'staff',
                        'action' => 'modificapassword'),
                        'default'
                        ));
        return $this->_formPassword;
    }
}

