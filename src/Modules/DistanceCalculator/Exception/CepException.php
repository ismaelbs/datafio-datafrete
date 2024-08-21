<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Exception;

class CepException extends \Exception
{

  private function __construct(string $message)
  {
    parent::__construct($message);
  }

  public static function notFound(string $cep): \Exception
  {
    return CepNotFoundException::make($cep);
  }

  public static function invalidCep(string $cep): \Exception
  {
    return CepIsInvalidExeception::make($cep);
  }

  public static function coordenatesNotFound(string $cep): \Exception {
    return CepCoordenatesNotFoundException::make($cep);
  }

  public static function cepRequired(): \Exception {
    return CepRequiredException::make();
  }
}