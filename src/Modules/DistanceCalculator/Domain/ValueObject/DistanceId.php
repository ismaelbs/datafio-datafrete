<?php
declare(strict_types=1);
namespace Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject;
use Ramsey\Uuid\Nonstandard\Uuid;

class DistanceId
{
  private function __construct(
    private string $value
  ) {
  }

  public function toString(): string
  {
    return $this->value;
  }

  public static function create(): DistanceId
  {
    return new self(
      Uuid::uuid4()->toString()
    );
  }

  public static function fromString(string $value): DistanceId
  {
    return new self($value);
  }
}