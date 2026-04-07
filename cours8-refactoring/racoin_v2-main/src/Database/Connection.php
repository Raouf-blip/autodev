<?php

namespace App\Database;

use Illuminate\Database\Capsule\Manager as DB;

class Connection
{
    public static function create(): void
    {
        $capsule = new DB();
        $capsule->addConnection(parse_ini_file(__DIR__ . '/../../config/config.ini'));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
