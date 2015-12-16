<?php

namespace VendingMachine;

class Item
{
    
    /**
     * @var string
     */
    private $itemCode;
    
    /**
     * Constructor
     * 
     * @param string $itemCode
     */
    public function __construct($itemCode)
    {
        $this->itemCode = $itemCode;
    }
    
    /**
     * Get Item Code
     * 
     * @return string
     */
    public function getItemCode()
    {
        return $this->itemCode;
    }
}