<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject;

class Point
{
  private function __construct(
    private float $latitude,
    private float $longitude
  ) {}

  public function getLatitude(): float
  {
    return $this->latitude;
  }

  public function getLongitude(): float
  {
    return $this->longitude;
  }

  public function setLatitude(float $latitude): void {
    $this->latitude = $latitude;
  }

  public function setLongitude(float $longitude): void {
    $this->longitude = $longitude;
  }

  public static function create(float $latitude, float $longitude): Point
  {
    return new self(
      $latitude,
      $longitude
    );
  }
}