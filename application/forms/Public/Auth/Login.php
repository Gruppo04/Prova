<?php

class Application_Form_Public_Auth_Login extends Zend_Form
{
    public function init()
    {               
        $this->setMethod('post');
        $this->setName('login');
        $this->setAction('');
    	
        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'required'   => true,
            'autofocus'  => true,
            'label'      => 'Username'
            ));
        
        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'      => 'Password'
            ));

        $this->addElement('submit', 'login', array(
            'label'    => 'Login',
            'class' => 'btn btn-primary'
        ));

    }
}
