<?php
namespace Isma\Datafrete\Modules\DistanceCalculator\Gateway;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
interface CepCacheInterface {
  public function get(string $cep): ?Cep;
  public function save(Cep $distance): void;
}