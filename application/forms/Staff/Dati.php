<?php

class Application_Form_Staff_Dati extends Zend_Form
{
    public function init() {
        
        $this->setMethod('post');
        $this->setName('modifica profilo');
        $this->setAction('');
        
        // La seguente istruzione permette di usare i filtri custom
        $this->addElementPrefixPath('Filter', APPLICATION_PATH . '/../library/Filter', 'filter');
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => 'true',
            'autofocus' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        $this->getElement('nome')->addFilter(new Filter_Uc);
        
        $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Alpha', true, array('allowWhiteSpace'=>true)))
            ));
        $this->getElement('nome')->addFilter(new Filter_Uc);
        
        $this->addElement('text', 'email', array(
            'label' => 'Indirizzo e-mail',
            'required' => 'true',
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')));
        
        $this->addElement('submit', 'modifica', array(
            'label' => 'Applica modifiche',
            'class' => 'btn btn-primary'));
    }

}
