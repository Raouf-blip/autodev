<?php

require('../vendor/autoload.php');

use App\Factory\VehicleFactory;

$factory = new VehicleFactory();

echo "Case 1: Distance 10km, Weight 10kg\n";
$v1 = $factory->getVehicle(10, 10);
echo "Vehicle: " . get_class($v1) . " (Cost: " . $v1->getCostPerKm() . ", Fuel: " . $v1->getFuelType() . ")\n\n";

echo "Case 2: Distance 30km, Weight 10kg\n";
$v2 = $factory->getVehicle(30, 10);
echo "Vehicle: " . get_class($v2) . " (Cost: " . $v2->getCostPerKm() . ", Fuel: " . $v2->getFuelType() . ")\n\n";

echo "Case 3: Distance 10km, Weight 50kg\n";
$v3 = $factory->getVehicle(10, 50);
echo "Vehicle: " . get_class($v3) . " (Cost: " . $v3->getCostPerKm() . ", Fuel: " . $v3->getFuelType() . ")\n\n";

echo "Case 4: Distance 100km, Weight 500kg\n";
$v4 = $factory->getVehicle(100, 500);
echo "Vehicle: " . get_class($v4) . " (Cost: " . $v4->getCostPerKm() . ", Fuel: " . $v4->getFuelType() . ")\n\n";
