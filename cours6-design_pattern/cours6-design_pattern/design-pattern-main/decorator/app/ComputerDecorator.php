<?php

namespace App;

abstract class ComputerDecorator implements Computer
{
    protected $computer;

    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
    }

    public function getPrice(): int
    {
        return $this->computer->getPrice();
    }

    public function getDescription(): string
    {
        return $this->computer->getDescription();
    }
}
