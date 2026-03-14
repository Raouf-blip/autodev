<?php

namespace App;

class Laptop implements Computer {
    
    public function getPrice(): int 
    {
        return 400;
    }

    public function getDescription(): string 
    {
        return "A laptop computer";
    }
}   