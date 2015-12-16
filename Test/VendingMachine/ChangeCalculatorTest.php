<?php

namespace Test\VendingMachine;

use VendingMachine\Coin;
use VendingMachine\VendingMachine;
use VendingMachine\ChangeCalculator;

class ChangeCalculatorTest extends \PHPUnit_Framework_TestCase
{

    private $existingCoins;
    
    public function setUp()
    {
        $this->existingCoins = [
            20 => [new Coin(0.2), new Coin(0.2), new Coin(0.2), new Coin(0.2), new Coin(0.2), new Coin(0.2), new Coin(0.2), new Coin(0.2)],
            10 => [new Coin(0.1), new Coin(0.1), new Coin(0.1), new Coin(0.1), new Coin(0.1), new Coin(0.1), new Coin(0.1), new Coin(0.1)],
            100 => [new Coin(1), new Coin(1), new Coin(1), new Coin(1), new Coin(1), new Coin(1), new Coin(1), new Coin(1)],
            50 => [new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5)],
        ];
    }
    
    public function testCalculateChangeWithJustOneDenominations()
    {
        $initialAmountOf100 = count($this->existingCoins[100]);
        $initialAmountOf50 = count($this->existingCoins[50]);
        $initialAmountOf20 = count($this->existingCoins[20]);
        $initialAmountOf10 = count($this->existingCoins[10]);
        
        $calculator = new ChangeCalculator();
        $result = $calculator->calculateChange(3, 5, $this->existingCoins);
        
        $this->assertEquals(2, count($result));
        $this->assertEquals(1, $result[0]->getValue());
        $this->assertEquals(1, $result[1]->getValue());
        
        $this->assertEquals($initialAmountOf100 - 2, count($this->existingCoins[100]));
        $this->assertEquals($initialAmountOf50, count($this->existingCoins[50]));
        $this->assertEquals($initialAmountOf20, count($this->existingCoins[20]));
        $this->assertEquals($initialAmountOf10, count($this->existingCoins[10]));
    }
    
    public function testCalculateChangeWithMoreDenominations()
    {
        $initialAmountOf100 = count($this->existingCoins[100]);
        $initialAmountOf50 = count($this->existingCoins[50]);
        $initialAmountOf20 = count($this->existingCoins[20]);
        $initialAmountOf10 = count($this->existingCoins[10]);
        
        $calculator = new ChangeCalculator();
    
        $result = $calculator->calculateChange(3.6, 5, $this->existingCoins);
        
        $this->assertEquals(3, count($result));
        $this->assertEquals(1, $result[0]->getValue());
        $this->assertEquals(0.2, $result[1]->getValue());
        $this->assertEquals(0.2, $result[2]->getValue());
        
        $this->assertEquals($initialAmountOf100 - 1, count($this->existingCoins[100]));
        $this->assertEquals($initialAmountOf50, count($this->existingCoins[50]));
        $this->assertEquals($initialAmountOf20 - 2, count($this->existingCoins[20]));
        $this->assertEquals($initialAmountOf10, count($this->existingCoins[10]));
    }
    
    public function testCalculateChangeWithEvenMoreDenominations()
    {
        $initialAmountOf100 = count($this->existingCoins[100]);
        $initialAmountOf50 = count($this->existingCoins[50]);
        $initialAmountOf20 = count($this->existingCoins[20]);
        $initialAmountOf10 = count($this->existingCoins[10]);
        
        $calculator = new ChangeCalculator();
    
        $result = $calculator->calculateChange(3.7, 6, $this->existingCoins);
    
        $this->assertEquals(4, count($result));
        $this->assertEquals(1, $result[0]->getValue());
        $this->assertEquals(1, $result[1]->getValue());
        $this->assertEquals(0.2, $result[2]->getValue());
        $this->assertEquals(0.1, $result[3]->getValue());
        
        $this->assertEquals($initialAmountOf100 - 2, count($this->existingCoins[100]));
        $this->assertEquals($initialAmountOf50, count($this->existingCoins[50]));
        $this->assertEquals($initialAmountOf20 - 1, count($this->existingCoins[20]));
        $this->assertEquals($initialAmountOf10 -1, count($this->existingCoins[10]));
    }
    
    public function testCalculateChangeThrowsExceptionWhenDenominationIsMissing()
    {
        $calculator = new ChangeCalculator();
    
        $this->setExpectedException('DomainException');
        
        $calculator->calculateChange(3.75, 6, $this->existingCoins);
    }
    
    public function testCalculateChangeThrowsExceptionWhenCoinsAreMissing()
    {
        $calculator = new ChangeCalculator();
    
        $this->setExpectedException('DomainException');
    
        $calculator->calculateChange(3.75, 100, $this->existingCoins);
    }
}
