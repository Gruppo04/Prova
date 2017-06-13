<?php

class Application_Form_Staff_Password extends Zend_Form
{
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica password');
        $this->setAction('');
        
        $this->addElement('password', 'old_password', array(
            'label' => 'Vecchia password',
            'required' => 'true',
            'filters' => array('StringTrim')
            ));
        
        $this->addElement('password', 'password', array(
            'label' => 'Nuova password',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(4,25)))));
        
        $this->addElement('password', 'verificapassword', array(
                'label'      => 'Conferma password',
                'required'   => true,
                'validators' => array(
                    array('Identical', false, array('token' => 'password'))
                    )));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Cambia password',
            'class' => 'btn btn-primary'));
    }

}