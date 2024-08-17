<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Exception;

class CepNotFoundException extends \Exception {
  private const ERROR_MESSAGE_NOT_FOUND = 'Cep %s not found';

  private function __construct(string $message)
  {
    parent::__construct($message);
  }

  public static function make(string $cep): self
  {
    return new static(sprintf(self::ERROR_MESSAGE_NOT_FOUND, $cep));
  }
}