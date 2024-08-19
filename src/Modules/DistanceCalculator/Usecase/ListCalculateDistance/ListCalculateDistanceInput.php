<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\ListCalculateDistance;

readonly class ListCalculateDistanceInput
{

  private function __construct(
    public int $limit,
    public int $offset,
  ) {
  }
  public static function make(
    int $limit = 10,
    int $offset = 0,
  ): ListCalculateDistanceInput {
    return new self(
      $limit,
      $offset
    );
  }
}