<?php

namespace App\Utils;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Factory;

class ParamValidation
{
    protected $errors;

    public function __construct()
    {
        Factory::setDefaultInstance(new Factory());
    }

    public function validate($value, $rule, string $name = null): ParamValidation
    {
        $validationName = $name ?? $value;

        try {
            $rule->setName($validationName)->assert($value);
        } catch (NestedValidationException $e) {
            $this->errors[] = $e;
        }

        return $this;
    }

    public function failed()
    {
        return ! empty($this->errors);
    }

    public function getErrorMessage(): string
    {
        if (! $this->failed()) {
            return "No errors found";
        }

        $errorMessage = "";
        foreach ($this->errors as $error) {
            foreach ($error as $e) {
                $errorMessage .= $e->getMessage() . ", ";
            }
        }

        return substr($errorMessage, 0, -2);
    }
}
