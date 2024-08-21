<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Exception;

class CepRequiredException extends \Exception {
  private const ERROR_MESSAGE_NOT_FOUND = 'Cep is required for calculate distance';

  private function __construct(string $message)
  {
    parent::__construct($message);
  }

  public static function make(): self
  {
    return new static(self::ERROR_MESSAGE_NOT_FOUND);
  }
}