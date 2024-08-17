<?php
namespace Test\Datafrete\Unit\Helpers\DistanceRepository;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity\Distance;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;

class DistanceRepositorySpy implements DistanceRepositoryInterface {
  private int $calls = 0;
  public function save(Distance $distance): void
  {
    $this->calls++;
  }

  public function toBeCalledOnce(): void {
    expect($this->calls)->toBe(1);
  }
}