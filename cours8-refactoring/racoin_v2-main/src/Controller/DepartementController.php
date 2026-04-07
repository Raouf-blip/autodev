<?php

namespace App\Controller;

use App\Model\Departement;

class DepartementController
{
    public static function getAllDepartements(): array
    {
        return Departement::orderBy('nom_departement')->get()->toArray();
    }
}
