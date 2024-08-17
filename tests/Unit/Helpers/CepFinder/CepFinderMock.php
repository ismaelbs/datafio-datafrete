<?php
declare(strict_types=1);
namespace Test\Datafrete\Unit\Helpers\CepFinder;

use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Point;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepException;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepFinderInterface;

class CepFinderMock implements CepFinderInterface
{
  public const JOACABA_CEP = "89600000";
  public const BLUMENAU_CEP = "89010025";
  private array $points = [];
  public function __construct() {
    $this->points = [
      "01001000" => Point::create(0, 0),
      "01001001" => Point::create(-20, -30),
      self::JOACABA_CEP => Point::create(latitude:-27.1737204, longitude: -51.5065214),
      self::BLUMENAU_CEP => Point::create(latitude:-26.9244749, longitude: -49.0629788),
    ];
  }
  public function find(string $cep): Cep
  {
    if (!Cep::validade($cep)) {
      throw CepException::invalidCep($cep);
    }

    if (!isset($this->points[$cep])) {
      throw CepException::notFound($cep);
    }
    $this->points[$cep]->getLatitude();
    $this->points[$cep]->getLongitude();
    return Cep::parse($cep, $this->points[$cep]->getLatitude(), $this->points[$cep]->getLongitude());
  }
}