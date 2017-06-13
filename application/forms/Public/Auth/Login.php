<?php

class Application_Form_Public_Auth_Login extends Zend_Form
{
    public function init()
    {               
        $this->setMethod('post');
        $this->setName('login');
        $this->setAction('');
    	
        // Validatori per controllare l'esistenza delle credenziali immesse
        $esisteUser = new Zend_Validate_Db_RecordExists(
                array(
                    'adapter'=> Zend_Db_Table_Abstract::getDefaultAdapter(),
                    'table' => 'utenti',
                    'field' => 'username'
                    ));
        $esisteUser->setMessage('Unknown username');
        
        $esistePass = new Zend_Validate_Db_RecordExists(
                array(
                    'adapter'=> Zend_Db_Table_Abstract::getDefaultAdapter(),
                    'table' => 'utenti',
                    'field' => 'password'
                    ));
        $esistePass->setMessage('Wrong password');
        
        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'autofocus'  => true,
            'label'      => 'Username'
            ));
        $this->getElement('username')->addValidator($esisteUser);
        
        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'      => 'Password'
            ));
        $this->getElement('password')->addValidator($esistePass);

        $this->addElement('submit', 'login', array(
            'label'    => 'Login',
            'class' => 'btn btn-primary'
        ));

    }
}
