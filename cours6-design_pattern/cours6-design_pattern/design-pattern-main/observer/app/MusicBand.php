<?php

namespace App;

class MusicBand 
{
    // Hors exercice mais notable:
    // Promotion du constructeur: https://www.php.net/manual/fr/language.oop5.decon.php#language.oop5.decon.constructor.promotion
    public function __construct(
        private string $name,
        private array $concerts = []
    ) {}


    public function addNewConcertDate(string $date, string $location):void
    {
        $this->concert = [
            'date' =>  $date,
            'location' => $location
        ];
    }

    public function attach(): void 
    {}

    public function detach(): void 
    {}
}