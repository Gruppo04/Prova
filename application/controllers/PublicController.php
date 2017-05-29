<?php

class PublicController extends Zend_Controller_Action
{
    protected $_catalogoModel;
    protected $_form;
    
    public function init()
    {
	$this->_helper->layout->setLayout('main');
        $this->_catalogoModel = new Application_Model_Catalogo();
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
    
    private function getRegistrazioneForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Public_Registrazione();
        $this->_form->setAction($urlHelper->url(array(
                        'controller' => 'public',
                        'action' => ''),
                        'default'
                        ));
        return $this->_form;
    }
}