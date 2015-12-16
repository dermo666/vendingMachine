<?php

namespace VendingMachine;

class ChangeCalculator 
{
    /**
     * Calculate change using "Greedy Method".
     * 
     * @param float   $priceAmount
     * @param float   $amountPaid
     * @param Coin[] &$coins       Array of Coins by indexed by value
     * 
     * @return Coin[]
     * 
     * @throws \UnexpectedValueException
     * @throws \DomainException
     */
    public function calculateChange($priceAmount, $amountPaid, array &$coins)
    {
        $diffAmount = $amountPaid - $priceAmount;
        
        if ($diffAmount < 0) {
            throw new \UnexpectedValueException('Price is higher than paid amount.');
        }
        
        $result = [];
        
        if ($diffAmount > 0) {
            // Get rid of decimals.
            $remainingAmount = (int)bcmul($diffAmount, 100);
            
            $denominations = array_keys($coins);
            rsort($denominations);
            
            foreach ($denominations as $denomination) {
                if ($remainingAmount >= $denomination) { 
                    $numberOfCoins = floor($remainingAmount / $denomination);
                    $numberOfCoins = min($numberOfCoins, count($coins[$denomination]));
                    
                    for ($i = 0; $i < $numberOfCoins; $i++ ) {
                        $result[] = array_shift($coins[$denomination]);
                        $remainingAmount -= $denomination;
                    }
                }
            }
            
            if ($remainingAmount > 0) {
                throw new \DomainException('Unable to calculate correct change.');
            }
        }
        
        return $result;
    }
}