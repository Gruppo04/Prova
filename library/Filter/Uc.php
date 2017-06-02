<?php

class Filter_Uc implements Zend_Filter_Interface
{

    public function filter($value)
    {
        $valueFiltered= ucfirst($value);
        return $valueFiltered;
    }
}

