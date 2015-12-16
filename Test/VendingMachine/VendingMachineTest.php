<?php

namespace Test\VendingMachine;

use VendingMachine\Item;
use VendingMachine\Coin;
use VendingMachine\VendingMachine;
use VendingMachine\Input;
use VendingMachine\Price;

class VendingMachineTest extends \PHPUnit_Framework_TestCase
{

    public function testVendingMachineReturnsSomeOutput()
    {
        $items = [new Item('coke'), new Item('coke'), new Item('sprite'), new Item('ice coffee')];
        $coins = [new Coin(0.1), new Coin(0.1), new Coin(0.1), new Coin(0.2), new Coin(0.5)];
        $prices = [new Price('coke', 1.6), new Price('sprice', 2), new Price('ice coffee', 2.5)];

        $input = (new Input())->addCoin(new Coin(0.1))->addCoin(new Coin(0.5))->selectItem('coke');
        
        $vendingMachine = (new VendingMachine())->addCoins($coins)->addPrices($prices)->addItems($items);
        
        $this->assertInstanceOf('VendingMachine\Output', $vendingMachine->processInput($input));
    }
}
