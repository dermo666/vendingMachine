<?php

namespace VendingMachine;

class Output
{
    
    /**
     * @var Coin[]
     */
    private $coins = [];
    
    /**
     * @var Item
     */
    private $item = NULL;
    
    /**
     * @var string
     */
    private $message;
    
    /**
     * Constructor
     * 
     * @param Item   $item
     * @param Coin[] $coins
     * @param string $message
     */
    public function __construct(Item $item=NULL, array $coins, $message)
    {
        $this->item    = $item;
        $this->coins   = $coins;
        $this->message = $message;
    }
    
    /**
     * Get Coins
     * 
     * @return Coin[]
     */
    public function getCoins()
    {
        return $this->coins;
    }

    /**
     * Get Item
     * 
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }
    
    /**
     * Get Message
     * 
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
