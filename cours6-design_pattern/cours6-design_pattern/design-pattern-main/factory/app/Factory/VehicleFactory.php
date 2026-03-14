<?php

namespace App\Factory;

use App\Entity\Bicycle;
use App\Entity\Car;
use App\Entity\Truck;
use App\Entity\VehicleInterface;

class VehicleFactory
{
    public function createVehicle(string $type): VehicleInterface
    {
        switch (strtolower($type)) {
            case 'bicycle':
                return new Bicycle(0.1, 'human power');
            case 'car':
                return new Car(0.5, 'petrol');
            case 'truck':
                return new Truck(1.5, 'diesel');
            default:
                throw new \InvalidArgumentException("Unknown vehicle type: $type");
        }
    }

    public function getVehicle(int $distance, int $weight): VehicleInterface
    {
        if ($distance < 20 && $weight <= 20) {
            return $this->createVehicle('bicycle');
        } elseif ($weight <= 200) {
            return $this->createVehicle('car');
        } else {
            return $this->createVehicle('truck');
        }
    }
}
