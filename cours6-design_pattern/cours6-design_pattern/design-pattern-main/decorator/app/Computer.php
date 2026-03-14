<?php

namespace App;

interface Computer
{
    public function getPrice(): int;

    public function getDescription(): string;
}