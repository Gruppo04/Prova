<?php

class Application_Form_User_Password extends Zend_Form
{
    protected $_userModel;
    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica password');
        $this->setAction('');
        $this->_userModel = new Application_Model_User();
        
        $this->addElement('password', 'old_password', array(
            'label' => 'Vecchia password',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(6,25)))));
        
        $this->addElement('password', 'password', array(
            'label' => 'Nuova password',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(6,25)))));
        
        $this->addElement('password', 'verificapassword', array(
                'label'      => 'Conferma password',
                'required'   => true,
                'validators' => array(
                    array('Identical', false, array('token' => 'password'))
                    )));
        
        $this->addElement('submit', 'add', array(
             'label' => 'Cambia password'));
    }

}