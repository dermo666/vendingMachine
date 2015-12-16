<?php

namespace VendingMachine;

class Input
{

    /**
     * @var Coin
     */
    private $coins = [];

    /**
     * @var string
     */
    private $itemCode;

    /**
     * Insert Coin
     * 
     * @param Coin $coin
     * 
     * @return Input
     */
    public function insertCoin(Coin $coin)
    {
        $this->coins[] = $coin;
        return $this;
    }

    /**
     * Select Item
     * 
     * @param string $itemCode
     * 
     * @return Input
     */
    public function selectItem($itemCode)
    {
        $this->itemCode = $itemCode;
        return $this;
    }
    
    /**
     * Get selected Item Code
     * 
     * @return string
     */
    public function getSelectedItemCode()
    {
        return $this->itemCode;
    }
    
    /**
     * Get inserted coin.
     * 
     * @return Coin
     */
    public function getCoins()
    {
        return $this->coins;
    }
}