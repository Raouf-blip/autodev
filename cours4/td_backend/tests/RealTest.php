<?php

namespace App\Entity;

use App\Entity\Realisator;
use PHPUnit\Framework\TestCase;

class RealTest extends TestCase{
    public function test(): void {
        $realisateur = new Realisator();
        $realisateur->setName("Christopher Nolan");
        $this->assertEquals("Christopher Nolan", $realisateur->getName());
    }
}

