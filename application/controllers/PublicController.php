<?php

class PublicController extends Zend_Controller_Action
{
    protected $_catalogoModel;
    protected $_form;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
        $this->_catalogoModel = new Application_Model_Catalogo();
        $this->_utentiModel = new Application_Model_Utenti();
        $this->view->userForm = $this->getUserForm();
    }
    
    public function indexAction()
    {
    }
    
    public function aziendeAction()
    {
        $az=$this->_catalogoModel->getAziende();
        $this->view->assign(array('aziende' => $az));
    }
    
    public function viewstaticAction()
    {
    	$page = $this->_getParam('staticPage');
    	$this->render($page);
    }
    
    public function logregAction()
    {
    }
    
    public function registraAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index','public');
        }
	$form=$this->_form;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('logreg');
        }
        $values = $form->getValues();
       	$this->_utentiModel->registraUser($values);
    }
    
    private function getUserForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Public_User();
        $this->_form->setAction($urlHelper->url(array(
                        'controller' => 'public',
                        'action' => 'registra'),
                        'default'
                        ));
        return $this->_form;
    }
}