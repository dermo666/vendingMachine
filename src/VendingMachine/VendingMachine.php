<?php

namespace VendingMachine;

class VendingMachine 
{
    /**
     * @var Item[]
     */
    private $items;
    
    /**
     * @var Coin[]
     */
    private $coins;
    
    /**
     * @var Price[]
     */
    private $priceList;
    
    /**
     * @var ChangeCalculator
     */
    private $calculator;
    
    /**
     * Constructor
     */
    public function __construct(ChangeCalculator $calculator)
    {
        $this->calculator = $calculator;
    }
    
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
           if (!isset($this->items[$item->getItemCode()])) {
                if (count($this->items) === 4) {
                    throw new \DomainException('The vending machine accepts only four different items.');
                } else {
                    $this->items[$item->getItemCode()] = [];
                }
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
    public function insertCoins(array $coins)
    {
       foreach ($coins as $coin) {
           $index = (int)bcmul($coin->getValue(), 100);
           
           if (!isset($this->coins[$index])) {
                if (count($this->coins) === 4) {
                    throw new \DomainException('The vending machine accepts only four denominations of coins.');
                } else { 
                    $this->coins[$index] = [];
                }
           }
            
           $this->coins[$index][] = $coin;
       }
       
       return $this;
    }
    
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
    
    /**
     * Process customer's input
     * 
     * @param Input $input
     * 
     * @return Output
     */
    public function processInput(Input $input)
    {
        $itemCode = $input->getSelectedItemCode();
        
        // Check whether the product is in stock by itemCode 
        if (!isset($this->items[$itemCode])
             || count($this->items[$itemCode]) === 0) {
            return new Output(null, $input->getCoins(), 'Item is out of stock.');
        }
        
        $amountPaid = $this->sumCoins($input->getCoins());

        // Check whether the inserted amount money is enough to buy item.
        if (!isset($this->priceList[$itemCode])
            || $this->priceList[$itemCode]->getValue() > $amountPaid) {
            return new Output(null, $input->getCoins(), 'Inserted insufficient amount of money.');
        }
        
        // Calculate the change 
        try {
            $changeCoins = $this->calculator->calculateChange($this->priceList[$itemCode]->getValue(), $amountPaid, $this->coins);
        } catch (\Exception $e) {
            return new Output(NULL, $input->getCoins(), 'Change error.');
        }
        
        // Add new coins to remaining coins.
        $this->insertCoins($input->getCoins());
        
        // Serve item 
        $item = array_shift($this->items[$itemCode]);
        
        return new Output($item, $changeCoins, 'Thank you!');
    }
    
    /**
     * Calculate sum of Coins
     * 
     * @param Coin[] $coins
     * 
     * @return float
     */
    private function sumCoins(array $coins)
    {
        $amount = 0;
        
        foreach ($coins as $coin) {
            $amount += $coin->getValue();
        }
        
        return $amount;
    }
}