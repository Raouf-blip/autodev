<?php

namespace App\Entity;

class Truck {
    private $costPerKm;
    private $fuelType;

    public function __construct($costPerKm, $fuelType) {
        $this->costPerKm = $costPerKm;
        $this->fuelType = $fuelType;
    }

    public function getCostPerKm() {
        return $this->costPerKm;
    }

    public function getFuelType() {
        return $this->fuelType;
    }
}