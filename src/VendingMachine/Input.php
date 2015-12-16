<?php

namespace VendingMachine;

class Input
{

    private $coins = [];

    private $itemCode;

    public function addCoin(Coin $coin)
    {
        $this->coins[] = $coin;
        return $this;
    }

    public function selectItem($itemCode)
    {
        $this->itemCode = $itemCode;
        return $this;
    }
}