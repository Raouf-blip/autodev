<?php

namespace App;

class Calculator
{
  /**
   * Adds two floats and returns the result.
   *
   * @param float $a The first float to be added.
   * @param float $b The second float to be added.
   * @return float The sum of $a and $b.
   */
    public function add(float $a, float $b): float
    {
        return $a + $b;
    }

    /**
   * Substracts two floats and returns the result.
   *
   * @param float $a The first float to be substracted.
   * @param float $b The second float to be substracted.
   * @return float The diff of $a and $b.
   */
    public function sub(float $a, float $b): float
    {
        return $a - $b;
    }

  /**
   * Multiply two floating point numbers.
   *
   * @param float $a input number
   * @param float $b input number
   * @return float result of the multiplication
   */
    public function mul(float $a, float $b): float
    {
        return $a * $b;
    }

    public function div(float $a, float $b): float
    {
        return $a / $b;
    }

    public function pow(float $a, float $b): float
    {
        return $a ** $b;
    }

  /**
   * Calculates the square root of a given number.
   *
   * @param float $a The number to calculate the square root of.
   * @return float The square root of $a.
   */
    public function sqrt(float $a): float
    {
        return sqrt($a);
    }

  /**
   * Splits a float into its integer and decimal parts.
   *
   * @param float $float The input float to be split
   * @return array<string,int> An array containing the integer and decimal parts
   */
    public function splitFloat($float)
    {
        $parts        = explode('.', (string)$float);
        $leftPart  = (int) $parts[0];
        $rightPart    = (int) $parts[1] ? (int)$parts[1] : null;

        return array("left" => $leftPart, "right" => $rightPart);
    }

    public function generateRandomCalculatorName(): string
    {
        return "Calculator-" . uniqid();
    }
}
