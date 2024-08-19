<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance;

readonly class CalculateDistanceOutput{

  public function __construct(
    public string $originCep,
    public string $destinationCep,
    public float $distance,
    public string $type = 'Kilometers'
  ) {
  }

  public static function make(
    string $originCep,
    string $destinationCep,
    float $distance
  ) {
    return new self(
      $originCep,
      $destinationCep,
      $distance
    );
  }
}