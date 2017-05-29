<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
	/* Se in un controller è definito il metodo init() esso verrà
	 * eseguito automaticamente ogni volta che il controller viene chiamato,
	 * indipendentemente dalla action attivata, in questo caso non fa niente */
    }

    public function indexAction()
    {
        $this->_helper->redirector('index','public');
    }
}

