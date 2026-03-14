<?php

namespace db;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class connection {

    public static function createConn(): void {
        $capsule = new DB;
        $capsule->addConnection(parse_ini_file("./config/config.ini"));
        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}