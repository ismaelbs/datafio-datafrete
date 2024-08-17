<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance;

readonly class CalculateDistanceInput{

  public function __construct(
    public string $originCep,
    public string $destinationCep
  ) {
  }

  public static function make(
    string $originCep,
    string $destinationCep
  ) {
    return new self(
      $originCep,
      $destinationCep
    );
  }
}