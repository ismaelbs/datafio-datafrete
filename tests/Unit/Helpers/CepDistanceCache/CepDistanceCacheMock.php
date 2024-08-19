<?php
declare(strict_types=1);

namespace Test\Datafrete\Unit\Helpers\CepDistanceCache;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepCacheInterface;

class CepDistanceCacheMock implements CepCacheInterface {

  public const JOACABA_CEP = "89600000";
  public const BLUMENAU_CEP = "89010025";
  private array $ceps;

  public function __construct() {
    $this->ceps = [
      self::JOACABA_CEP => Cep::parse(self::JOACABA_CEP, -27.1737204, -51.5065214),
      self::BLUMENAU_CEP => Cep::parse(self::BLUMENAU_CEP, -26.9244749, -49.0629788),
    ];
  }

  public function get(string $cep): ?Cep
  {
    return array_key_exists($cep, $this->ceps) ? $this->ceps[$cep] : null;
  }

  public function save(Cep $cep): void
  {
    $this->ceps[$cep->toString()] = $cep;
  }
}