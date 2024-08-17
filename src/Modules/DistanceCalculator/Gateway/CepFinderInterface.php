<?php
declare(strict_types=1);
namespace Isma\Datafrete\Modules\DistanceCalculator\Gateway;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;

interface CepFinderInterface
{
  public function find(string $cep): Cep;
}