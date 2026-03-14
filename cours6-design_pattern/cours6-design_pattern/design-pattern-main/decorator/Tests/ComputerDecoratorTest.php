<?php

namespace Test;

use PHPUnit\Framework\TestCase;

use App\Laptop;

class ComputerDecoratorTest extends TestCase
{
    public function testBasicLaptop()
    {
        $laptop = new Laptop();
        
        $this->assertSame(400, $laptop->getPrice());
        $this->assertSame("A laptop computer", $laptop->getDescription());
    }

    public function testLaptopWithGPU()
    {
        // TODO: faire le test
        $this->assertSame(true, 1 === 1);
    }

    public function testLaptopWithOLEDScreen()
    {
        // TODO: faire le test
        $this->assertSame(false, 1 === 2);
    }
}