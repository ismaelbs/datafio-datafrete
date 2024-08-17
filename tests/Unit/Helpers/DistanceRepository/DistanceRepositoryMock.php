<?php
namespace Test\Datafrete\Unit\Helpers\DistanceRepository;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity\Distance;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;

class DistanceRepositoryMock implements DistanceRepositoryInterface {
  private int $callsSaved = 0;
  private int $callsGet = 0;
  private array $storage = [];
  public function save(Distance $distance): void
  {
    $this->callsGet++;
    $this->storage[] = $distance;
  }

  public function get(string $originCep, string $destinationCep): ?Distance
  {
    $this->callsSaved++;
    foreach ($this->storage as $distance) {
      if ($distance->getOrigin()->toString() === $originCep && $distance->getDestination()->toString() === $destinationCep) {
        return $distance;
      }
    }
  }
}