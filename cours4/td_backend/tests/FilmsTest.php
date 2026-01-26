<?php

namespace App\Entity;

use App\Entity\Film;
use PHPUnit\Framework\TestCase;

class FilmTest extends TestCase{
    public function test(): void {
        $film = new Film();
        $film->setTitle("Inception");
        $this->assertEquals("Inception", $film->getTitle());
    }
}

