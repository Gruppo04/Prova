<?php

class Application_Form_Public_Registrazione extends Zend_Form
{
    public function init() {
        
        $this->setMethod('post');
        $this->setName('registrazione');
        $this->setAction('');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array('Alpha','allowwhitespace' => 'true')));
        
        $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' => 'true'));
        
        $this->addElement('text', 'data_di_nascita', array(
            'label' => 'Data di nascita',
            'required' => 'true',
            'placeholder' => 'gg-mm-aaaa',
            'filters' => array('StringTrim'),
            'validators' => array(array('Date', 'format' => 'dd mm yyyy'))));
        
        $this->addElement('radio', 'genere', array(
            'MultiOptions' => array('M' => 'Maschio', 'F' => 'Femmina'),
            'value' => 'M',
            'required' => 'true'));
        
        $this->addElement('text', 'provincia', array(
            'label' => 'Provincia',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array('Alpha','allowwhitespace' => 'true')));
        
        $this->addElement('text', 'città', array(
            'label' => 'Comune',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array('Alpha','allowwhitespace' => 'true')));
        
        $this->addElement('text', 'telefono', array(
            'label' => 'Numero di telefono',
            'placeholder' => '(facoltativo)',
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
            'filters' => array('StringTrim')));
        
//        $this->addElement('password', '', array(
//            'label' => 'Conferma la password',
//            'required' => 'true'));
        
        $this->addElement('submit', 'add', array(
             'label' => 'Registrati'));
    }

}
