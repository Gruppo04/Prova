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
        $this->view->registrazioneForm = $this->getRegistrazioneForm();
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
        $anagrafica = array($form->getValue('nome'),
            $form->getValue('cognome'),
            $form->getValue('data_di_nascita'),
            $form->getValue('genere'),
            $form->getValue('provincia'),
            $form->getValue('citta'),
            $form->getValue('telefono'),
            $form->getValue('email'));
        $credenziali = array($form->getValue('username'),
             $form->getValue('password'));
       	$this->_utentiModel->registraUtente($anagrafica);
        $this->_utentiModel->registraCredenziali($credenziali);
        $this->setDescription('Utente registrato correttamente.');
    }
    
    private function getRegistrazioneForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Public_Registrazione();
        $this->_form->setAction($urlHelper->url(array(
                        'controller' => 'public',
                        'action' => 'registra'),
                        'default'
                        ));
        return $this->_form;
    }
}