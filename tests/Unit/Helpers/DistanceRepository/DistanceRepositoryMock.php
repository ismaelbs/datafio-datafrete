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
    $this->callsSaved++;
    $key = $distance->getOrigin()->toString() . $distance->getDestination()->toString();
    $this->storage[$key] = $distance;
  }

  public function get(string $originCep, string $destinationCep): ?Distance
  {
    $this->callsGet++;
    $key = "{$originCep}{$destinationCep}";
    if (array_key_exists($key, $this->storage)) {
      return $this->storage[$key];
    }
    return null;
  }

  public function list(array $config = []): array {
    return $this->storage;
  }

  public function getCallsSaved(): int
  {
    return $this->callsSaved;
  }

  public function getCallsGet(): int
  {
    return $this->callsGet;
  }
}