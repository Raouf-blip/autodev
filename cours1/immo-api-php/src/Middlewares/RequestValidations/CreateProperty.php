<?php

namespace App\Middlewares\RequestValidations;

use Respect\Validation\Validator;

class CreateProperty extends requestValidation
{
    public array $rules;

    public function __construct()
    {
        $this->rules =
        [
          'name' => Validator::length(5, 255),
          'description' => Validator::length(8, 255),
          'type' => Validator::in(['house','apartment','commercial']),
          'city' => Validator::length(1, 255),
          'surface' => Validator::intVal()->min(10),
          'price' => Validator::positive(),
          'images' => Validator::optional(Validator::arrayVal()),
          'options' => Validator::optional(Validator::arrayVal()->each(Validator::intVal()->positive())),
        ];
        parent::__construct($this->rules, 'body');
    }
}
