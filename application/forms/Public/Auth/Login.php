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
            'label'      => 'Username',
            //'decorators' => $this->elementDecorators,
            ));
        
        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'      => 'Password',
            //'decorators' => $this->elementDecorators,
            ));

        $this->addElement('submit', 'login', array(
            'label'    => 'Login',
            //'decorators' => $this->buttonDecorators,
        ));

//        $this->setDecorators(array(
//            'FormElements',
//            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
//        		array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
//            'Form'
//        ));
    }
}
