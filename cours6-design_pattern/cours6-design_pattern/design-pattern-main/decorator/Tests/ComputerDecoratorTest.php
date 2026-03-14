<?php

namespace Test;

use PHPUnit\Framework\TestCase;

use App\Laptop;
use App\GPUDecorator;
use App\OLEDScreenDecorator;

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
        $laptop = new Laptop();
        $laptopWithGPU = new GPUDecorator($laptop);
        
        $this->assertSame(550, $laptopWithGPU->getPrice());
        $this->assertSame("A laptop computer with GPU", $laptopWithGPU->getDescription());
    }

    public function testLaptopWithOLEDScreen()
    {
        $laptop = new Laptop();
        $laptopWithOLED = new OLEDScreenDecorator($laptop);
        
        $this->assertSame(600, $laptopWithOLED->getPrice());
        $this->assertSame("A laptop computer with OLED screen", $laptopWithOLED->getDescription());
    }

    public function testLaptopWithGPUAndOLEDScreen()
    {
        $laptop = new Laptop();
        $laptopWithGPU = new GPUDecorator($laptop);
        $laptopWithGPUAndOLED = new OLEDScreenDecorator($laptopWithGPU);
        
        $this->assertSame(750, $laptopWithGPUAndOLED->getPrice());
        $this->assertSame("A laptop computer with GPU with OLED screen", $laptopWithGPUAndOLED->getDescription());
    }
}
