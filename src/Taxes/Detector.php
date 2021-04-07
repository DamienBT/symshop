<?php

namespace App\Taxes;

class Detector
{
    protected $rate;
    public function __construct(float $rate)
    {
        $this->rate = $rate;
    }
    public function detect(float $number): bool
    {
        if ($number >= $this->rate) {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    }
}
