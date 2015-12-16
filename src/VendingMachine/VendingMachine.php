<?php

namespace VendingMachine;

class VendingMachine 
{
    private $items;
    
    private $coins;
    
    private $priceList;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    
    // TODO: Implement update price
    
    /**
     * Add Items
     *
     * @param Item[] $items
     * 
     * @return VendingMachine
     */    
    public function addItems(array $items)
    {
       foreach ($items as $item) {
           // TODO: Test for max 4 types
           if (!isset($this->items[$item->getItemCode()])) {
               $this->items[$item->getItemCode()] = [];
           }
           
           $this->items[$item->getItemCode()][] = $item; 
       }
       
       return $this;
    }
    
   /**
    * Add Coins
    *
    * @param Coin[] $coins
    * 
    * @return VendingMachine 
    */
    public function addCoins(array $coins)
    {
       foreach ($coins as $coin) {
           // TODO: Test for max 4 types
           if (!isset($this->coins[$coin->getValue()])) {
               $this->coins[$coin->getValue()] = [];
           }
            
           $this->coins[$coin->getValue()][] = $coin;
       }
       
       return $this;
    }
    
    // TODO: Implement update price
    /**
     * Add Prices
     *
     * @param Price[] $prices
     * 
     * @return VendingMachine
     */
    public function addPrices(array $prices)
    {
        foreach ($prices as $price) {
            $this->priceList[$price->getItemCode()] = $price;
        }
        
        return $this;
    }
    
    public function processInput(Input $input)
    {
        $output = new Output(new Item(''),[new Coin(0.1)]);
        
        return $output;
    }
}