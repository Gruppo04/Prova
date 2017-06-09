<?php

class StaffController extends Zend_Controller_Action
{	
    protected $_authService;
    protected $_staffModel;
    protected $_formCoupon;
    protected $_formCouponMod;

    public function init()
    {
        $this->_helper->layout->setLayout('main');
	$this->_authService = new Application_Service_Auth();
        $this->_staffModel = new Application_Model_Staff();
        $this->view->couponForm = $this->getCouponForm();
        $this->view->couponModForm = $this->getCouponModForm();
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
        $query = $this->_staffModel->getCouponById($idModifica)->toArray();
        $query['idModifica'] = $idModifica;
        $this->_formCouponMod->populate($query);
    }
    
    public function couponAction()
    {
        $coupon=$this->_staffModel->getCoupon();
        $this->view->assign(array('coupon' => $coupon));
    }
    
    public function registracouponAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('staff','formcoupon');
        }
	$formCoupon=$this->_formCoupon;
        if (!$formCoupon->isValid($_POST)) {
            return $this->render('formcoupon');
        }
        $values = $formCoupon->getValues();
       	$this->_staffModel->registraCoupon($values);
    }
    
    public function modificacouponAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('staff','formcouponmod');
        }
        $formCouponMod=$this->_formCouponMod;
        if (!$formCouponMod->isValid($_POST)) {
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
    
}

