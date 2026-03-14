<?php

namespace App;

class Config
{
    private static ?Config $instance = null;
    private array $settings = [];

    private function __construct()
    {
        $this->settings = require(__DIR__ . '/../config/config.php');
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $key): mixed
    {
        return $this->settings[$key] ?? null;
    }
}
