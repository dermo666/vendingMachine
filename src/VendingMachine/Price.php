<?php

namespace VendingMachine;

class Price
{
    
    /**
     * @var float
     */
    private $value;
    
    /**
     * @var string
     */
    private $itemCode;
    
    /**
     * Constructor
     * 
     * @param string $itemCode
     * @param float  $value
     */
    public function __construct($itemCode, $value)
    {
        $this->itemCode = $itemCode;
        $this->value    = $value;
    }
    
    /**
     * Get Value 
     * 
     * @return float
     */
    public function getValue()
    {
        return $this->value;
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