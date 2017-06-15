<?php

class Application_Form_User_Password extends App_Form_Abstract
{
    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica password');
        $this->setAction('');
        
        $this->addElement('password', 'old_password', array(
            'label' => 'Vecchia password',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(4,25)))));
        
        $this->addElement('password', 'password', array(
            'label' => 'Nuova password',
            'required' => 'true',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(4,25)))));
        
        $this->addElement('password', 'verificapassword', array(
                'label'      => 'Conferma password',
                'required'   => true,
                'decorators' => $this->elementDecorators,
                'validators' => array(
                    array('Identical', false, array('token' => 'password'))
                    )));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Cambia password',
            'class' => 'btn btn-primary'));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'zend_form')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

}