<?php

class Application_Form_Admin_Faq extends App_Form_Abstract
{
    public function init() {
        
        $this->setMethod('post');
        $this->setName('registrazione faq');
        $this->setAction('');
        
        $this->addElement('textarea', 'domanda', array(
            'label' => 'Domanda',
            'cols' => '100', 'rows' => '5',
            'filters' => array('StringTrim'),
            'required' => true,
            'decorators' => $this->elementDecorators,
            'placeholder' => 'Inserisci il testo della domanda',
            'validators' => array(array('StringLength',true, array(1,2500)))
        ));
        
        $this->addElement('textarea', 'risposta', array(
            'label' => 'Risposta',
            'cols' => '100', 'rows' => '10',
            'filters' => array('StringTrim'),
            'required' => true,
            'decorators' => $this->elementDecorators,
            'placeholder' => 'Inserisci la risposta',
            'validators' => array(array('StringLength',true, array(1,2500)))
        ));
        
        $this->addElement('submit', 'add', array(
            'label' => 'Inserisci FAQ',
            'class' => 'btn btn-primary'));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'zend_form')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

}
