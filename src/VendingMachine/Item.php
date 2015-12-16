<?php

namespace VendingMachine;

class Item
{
    
    private $itemCode;
    
    public function __construct($itemCode)
    {
        $this->itemCode = $itemCode;
    }
    
    public function getItemCode()
    {
        return $this->itemCode;
    }
}