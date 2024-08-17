<?php
declare(strict_types=1);
namespace Isma\Datafrete\Modules\DistanceCalculator\Gateway;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity\Distance;

interface DistanceRepositoryInterface {
  public function save(Distance $distance): void;
}