<?php
declare(strict_types=1);

namespace Isma\Datafrete\Infra\Http\Validators;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepException;

class CalculateDistanceInputValidator
{

  public static function validate(array $data): array
  {
    if (!isset($data["ceps"])) {
      throw CepException::cepRequired();
    }

    if (!isset($data["ceps"]["origin"]) || !isset($data["ceps"]["destination"]) || empty($data["ceps"]["origin"]) || empty($data["ceps"]["destination"])) {
      throw CepException::cepRequired();
    }

    if (!Cep::validade($data["ceps"]["origin"])) {
      throw CepException::invalidCep($data["ceps"]["origin"]);
    }

    if (!Cep::validade($data["ceps"]["destination"])) {
      throw CepException::invalidCep($data["ceps"]["destination"]);
    }

    return $data;
  }
}