<?php

namespace VendingMachine;

class Coin
{
    
    /**
     * @var float
     */
    private $value;
    
    /**
     * Constructor
     * 
     * @param float $value Value in dollars (0.1, 0.2 ... 1, 2, 5)
     */
    public function __construct($value)
    {
        if ($value < 0.1) {
            throw \UnexpectedValueException('Minimal value is one cent');
        }
        
        $this->value = $value;
    }
    
    /**
     * Get Coin Value.
     * 
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }
}