<?php

class Application_Form_Admin_Formstaff extends Zend_Form
{
    public function init() {
        
        $this->setMethod('post');
        $this->setName('registrazione staff');
        $this->setAction('');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha',
                    'allowWhiteSpace'=>true))));
        
        $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha',
                'allowWhiteSpace'=>true))));
        
        $this->addElement('text', 'data_di_nascita', array(
            'label' => 'Data di nascita',
            'required' => 'true',
            'placeholder' => 'aaaa-mm-gg',
            'filters' => array('StringTrim'),
            'validators' => array(array('Date'))));
        
        $this->addElement('radio', 'genere', array(
            'MultiOptions' => array('M' => 'Maschio', 'F' => 'Femmina'),
            'value' => 'M',
            'required' => 'true'));
        
        $this->addElement('text', 'provincia', array(
            'label' => 'Provincia',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha',
                    'allowWhiteSpace'=>true))));
        
        $this->addElement('text', 'citta', array(
            'label' => 'Comune',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha',
                    'allowWhiteSpace'=>true))));
        
        $this->addElement('text', 'telefono', array(
            'label' => 'Numero di telefono',
            'placeholder' => '(facoltativo)',
            'value' => null,
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(9,10)),
                'Digits')));
        
        $this->addElement('text', 'email', array(
            'label' => 'Indirizzo e-mail',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')));
        
        $this->addElement('text', 'username', array(
            'label' => 'Scegli un nome utente',
            'required' => 'true',
            'filters' => array('StringTrim')));
        
        $this->addElement('password', 'password', array(
            'label' => 'Scegli una password',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(array(
                'StringLength', true, array(6,25)))));
        
//        $this->addElement('password', '', array(
//            'label' => 'Conferma la password',
//            'required' => 'true'));
        $this->addElement('hidden', 'livello', array(
            'value' => 'staff'));
        
        $this->addElement('submit', 'add', array(
             'label' => 'Aggiungi membro staff'));
    }

}
