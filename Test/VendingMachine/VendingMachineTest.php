<?php

namespace Test\VendingMachine;

use VendingMachine\Item;
use VendingMachine\Coin;
use VendingMachine\VendingMachine;
use VendingMachine\Input;
use VendingMachine\Price;
use VendingMachine\ChangeCalculator;

class VendingMachineTest extends \PHPUnit_Framework_TestCase
{

    private $vendingMachine;
    
    public function setUp()
    {
        $items  = [
            new Item('coke'), new Item('coke'), new Item('coke'), new Item('coke'),
            new Item('sprite'), 
            new Item('snickers'), new Item('snickers'), new Item('snickers'), 
            new Item('bounty'),
        ];
        $coins  = [
            new Coin(0.1),
            new Coin(0.2), new Coin(0.2),
            new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5), new Coin(0.5),
            new Coin(1), new Coin(1), new Coin(1), new Coin(1), new Coin(1), new Coin(1), new Coin(1),
        ];
        $prices = [new Price('coke', 1.6), new Price('sprite', 2), new Price('snickers', 2.2),  new Price('bounty', 2.7)];
        
        $calculator = new ChangeCalculator();
        
        $this->vendingMachine = (new VendingMachine($calculator))->insertCoins($coins)
                                                                 ->addPrices($prices)
                                                                 ->addItems($items);
    }
    
    public function testVendingMachineReturnsAllCoinsWithoutItemWhenItemCodeDoesNotExists()
    {
        $input = (new Input())->insertCoin(new Coin(0.1))->selectItem('ice coffee');
        
        $output = $this->vendingMachine->processInput($input);
        
        $this->assertNull($output->getItem());
        $this->assertSame($input->getCoins(), $output->getCoins());
        $this->assertEquals('Item is out of stock.', $output->getMessage());
    }
    
    public function testVendingMachineReturnsAllCoinsWithoutItemWhenInsertedCoinsAreNotSufficient()
    {
        $input = (new Input())->insertCoin(new Coin(0.1))->selectItem('coke');
    
        $output = $this->vendingMachine->processInput($input);
    
        $this->assertNull($output->getItem());
        $this->assertSame($input->getCoins(), $output->getCoins());
        $this->assertEquals('Inserted insufficient amount of money.', $output->getMessage());
    }
    
    public function testVendingMachineReturnsItemWithCorrectChange()
    {
        $input = (new Input())->insertCoin(new Coin(1))->insertCoin(new Coin(1))->selectItem('coke');
    
        $output = $this->vendingMachine->processInput($input);
    
        $this->assertEquals('coke', $output->getItem()->getItemCode());
        $this->assertEquals(0.2, $output->getCoins()[0]->getValue());
        $this->assertEquals(0.2, $output->getCoins()[1]->getValue());
        $this->assertEquals('Thank you!', $output->getMessage());
    }
    
    public function testVendingMachineRunsOutOfStock()
    {
        $input = (new Input())->insertCoin(new Coin(1))->insertCoin(new Coin(1))->selectItem('sprite');
    
        $output = $this->vendingMachine->processInput($input);
    
        $this->assertEquals('sprite', $output->getItem()->getItemCode());
        $this->assertEmpty($output->getCoins());
        $this->assertEquals('Thank you!', $output->getMessage());
        
        $output = $this->vendingMachine->processInput($input);
        
        $this->assertNull($output->getItem());
        $this->assertSame($input->getCoins(), $output->getCoins());
        $this->assertEquals('Item is out of stock.', $output->getMessage());
    }
    
    public function testVendingMachineAddsInsertedCoinsToDispenser()
    {
        $input = (new Input())->insertCoin(new Coin(1))->insertCoin(new Coin(0.5))
                              ->insertCoin(new Coin(0.2))->insertCoin(new Coin(0.2))
                              ->insertCoin(new Coin(0.1))->selectItem('coke');
    
        $output = $this->vendingMachine->processInput($input);

        // At this point the machine would use original 20cents
        $this->assertEquals('coke', $output->getItem()->getItemCode());
        $this->assertEquals(0.2, $output->getCoins()[0]->getValue());
        $this->assertEquals(0.2, $output->getCoins()[1]->getValue());
        $this->assertEquals('Thank you!', $output->getMessage());
    
        $output = $this->vendingMachine->processInput($input);
    
        // At this point the machine would use 20cent coins inserted before
        $this->assertEquals('coke', $output->getItem()->getItemCode());
        $this->assertEquals(0.2, $output->getCoins()[0]->getValue());
        $this->assertEquals(0.2, $output->getCoins()[1]->getValue());
        $this->assertEquals('Thank you!', $output->getMessage());
    }
    
    public function testVendingMachineReturnsAllCoinsWithoutItemWhenThereIsNotEnoughChange()
    {
        $input = (new Input())->insertCoin(new Coin(1))->insertCoin(new Coin(1))->selectItem('coke');
    
        $output = $this->vendingMachine->processInput($input);
    
        // At this point the machine would use original 20cents
        $this->assertEquals('coke', $output->getItem()->getItemCode());
        $this->assertEquals(0.2, $output->getCoins()[0]->getValue());
        $this->assertEquals(0.2, $output->getCoins()[1]->getValue());
        $this->assertEquals('Thank you!', $output->getMessage());
        
        $output = $this->vendingMachine->processInput($input);
        
        $this->assertNull($output->getItem());
        $this->assertSame($input->getCoins(), $output->getCoins());
        $this->assertEquals('Change error.', $output->getMessage());
    }
}
