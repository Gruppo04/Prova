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
    
     public function validatedatiAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $loginform = new Application_Form_User_Dati();
        $response = $loginform->processAjax($_POST); 
        if ($response !== null) {
        	   $this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    public function formpasswordAction()
    {
    }
    
     public function validatepasswordAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $loginform = new Application_Form_User_Password();
        $response = $loginform->processAjax($_POST); 
        if ($response !== null) {
        	   $this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    public function modificadatiAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formdati','user');
        }
        $formDati=$this->_formDati;
        if (!$formDati->isValid($_POST)) {
            $formDati->setDescription('Attention: some modifications are incorrect.');
            return $this->render('formdati');
        }
        $values = array(
            'nome' => $formDati->getValue('nome'),
            'cognome' => $formDati->getValue('cognome'),
            'data_di_nascita' => $formDati->getValue('data_di_nascita'),
            'genere' => $formDati->getValue('genere'),
            'provincia' => $formDati->getValue('provincia'),
            'citta' => $formDati->getValue('citta'),
            'telefono' => $formDati->getValue('telefono'),
            'email' => $formDati->getValue('email'));
        $username = $formDati->getValue('nuovo_username');
        /* Se durante la modifica non è stata aggiunto uno username significa che si
        * deve mantenere quello precedente */
        if($username){
            $values['username'] = $username;
        }else{
            $values['username'] = $formDati->getValue('username');
        }
        $idModifica = $this->_authService->getIdentity()->id;
       	$this->_userModel->modificaDati($values, $idModifica);
        $modificato=$this->_adminModel->getUtenteById($idModifica);
        $this->_authService->clear();
    }
    
    public function modificapasswordAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('formpassword','user');
        }
	$formPassword=$this->_formPassword;
        if (!$formPassword->isValid($_POST)) {
            $formPassword->setDescription('Attention: some modifications are incorrect.');
            return $this->render('formpassword');
        }
        $values = $formPassword->getValues();
        if($values['old_password'] != ($this->_authService->getIdentity()->password))
        {
            $formPassword->setDescription('Wrong old password.');
            return $this->render('formpassword');
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
    
    public function stampaAction()
    {
        $idCoupon = $this->getParam('selCoupon');
        $coupon = $this->_guestModel->getCouponById($idCoupon);
        $emissioni = $coupon->emissioni;
        $emissioni++;
        $valueCoupon = array('emissioni' => $emissioni);
        $this->_userModel->incrementaCoupon($valueCoupon, $idCoupon);
        
        $idUtente = $this->_authService->getIdentity()->id;
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
        
        $emissione = array(
            'idUtente' => $idUtente,
            'idCoupon' => $idCoupon,
            'data_emissione' => date("Y-m-d H:i:s")
            );
        $this->_userModel->registraEmissione($emissione);
        $emissionenew = $this->_userModel->getEmissioneByUserCoupon($idUtente, $idCoupon)->toArray();
        $this->view->assign($emissionenew);
        $this->view->assign(array(
                    'nome' => $utente->nome,
                    'cognome' => $utente->cognome
                    ));
        $this->view->assign(array('coupon' => $coupon));
        $this->_helper->layout()->disableLayout();
    }
}

