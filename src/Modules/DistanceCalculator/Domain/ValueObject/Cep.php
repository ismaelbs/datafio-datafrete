<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject;
use BadMethodCallException;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepException;

/**
 * @mixin Point
 */
class Cep
{
  private function __construct(
    private string $value,
    private Point $point
  ) {}

  public function toString(): string
  {
    return $this->value;
  }

  public function __call($method, $args) {
    if (!method_exists($this->point, $method)) {
      throw new BadMethodCallException();
    }
    return call_user_func_array([$this->point, $method], $args);
  }

  public static function parse(string $value, float $latitude, float $longitude): Cep
  {
    if (!self::validade($value)) {
      throw CepException::invalidCep($value);
    }
    $point = Point::create($latitude, $longitude);
    return new Cep($value, $point);
  }

  public static function validade(string $value): bool {
    if (strlen($value) !== 8) {
      return false;
    }
    $value = substr($value, 0, 5) . "-" . substr($value, 5);
    if (!preg_match('/^[0-9]{5}-[0-9]{3}$/', $value)) {
      return false;
    }
    return true;
  }
}