<?php

namespace VendingMachine;

class Output
{
    
    private $coins = [];
    
    private $item;
    
    public function __construct(Item $item, array $coins)
    {
        $this->item  = $item;
        $this->coins = $coins;
    }
    
    public function getCoins()
    {
        return $this->coins;
    }
    
    public function getItem()
    {
        return $this->item;
    }
}
