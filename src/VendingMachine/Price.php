<?php

namespace VendingMachine;

class Price
{
    
    private $value;
    
    private $itemCode;
    
    public function __construct($itemCode, $value)
    {
        $this->itemCode = $itemCode;
        $this->value    = $value;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function getItemCode()
    {
        return $this->itemCode;
    }
}