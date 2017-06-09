<?php

class Application_Form_Admin_StaffMod extends Zend_Form
{       
    
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica staff');
        $this->setAction('');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        
        $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        
        $this->addElement('text', 'email', array(
            'label' => 'Indirizzo e-mail',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')));
        
        $this->addElement('text', 'username', array(
            'label' => '(!)Nome utente',
            'required' => 'true',
            'filters' => array('StringTrim')));
        
        $this->addElement('text', 'password', array(
            'label' => '(!)Password',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(6,25)))));
        
        $this->addElement('hidden', 'idModifica',array(
            'required' => true
        ));
        
        $this->addElement('submit', 'modifica', array(
             'label' => 'Applica modifiche'));
        
        $this->addElement('submit', 'cancella', array(
             'label' => 'Cancella membro staff'));
    }

}
