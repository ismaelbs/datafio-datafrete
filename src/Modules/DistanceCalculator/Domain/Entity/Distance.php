<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity;
use DateTimeImmutable;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\DistanceId;

class Distance {
  
  private float $distance;
  private DateTimeImmutable $createdAt;
  private DateTimeImmutable $updatedAt;
  public function __construct(
    private ?DistanceId $id,
    private Cep $origin,
    private Cep $destination,
  ) {
    if (is_null($this->id)) {
      $this->id = DistanceId::create();
    }
    $this->createdAt = new DateTimeImmutable();
    $this->updatedAt = new DateTimeImmutable();
  }

  public function getId(): DistanceId
  {
    return $this->id;
  }

  public function getDistance(): float {
    return $this->distance;
  }

  public function getOrigin(): Cep {
    return $this->origin;
  }

  public function getDestination(): Cep {
    return $this->destination;
  }

  public function calculateDistanceInKilometers(): void {
    $earthMeanRadius = 6371;
    $deltaLatitude = deg2rad(
      $this->destination->getLatitude() - $this->origin->getLatitude()
    );
    $deltaLongitude = deg2rad(
      $this->destination->getLongitude() - $this->origin->getLongitude()
    );
    $a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) +
         cos(deg2rad($this->origin->getLatitude())) * cos(deg2rad($this->destination->getLatitude())) *
         sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $this->distance =  round($earthMeanRadius * $c, 2);
  }
}