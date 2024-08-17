<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Exception;

class CepIsInvalidExeception extends \Exception {
  private const ERROR_MESSAGE_INVALID = 'Cep %s is invalid';

  private function __construct(string $message)
  {
    parent::__construct($message);
  }

  public static function make(string $cep): self
  {
    return new self(sprintf(self::ERROR_MESSAGE_INVALID, $cep));
  }
}