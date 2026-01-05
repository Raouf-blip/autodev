<?php

namespace App\Utils;

class DBConnection
{
    /**
     * Constructeur de la classe DBConnection qui exécute une connexion à une base de données
     *
     * @return void
     * @access public
     */
    public static function init()
    {
        $capsule = new \Illuminate\Database\Capsule\Manager();
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => getenv('MYSQL_HOST'),
            'database' => getenv('MYSQL_DATABASE'),
            'username' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_0900_ai_ci',
            'strict' => false,
        ]);
        $capsule->bootEloquent();
        $capsule->setAsGlobal();
    }
}
