<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

class AppController
{
    // * Le constrcuteur reçoit l'instance du container de dépenadances
    public function __construct(private ContainerInterface $container)
    {
    }
}
