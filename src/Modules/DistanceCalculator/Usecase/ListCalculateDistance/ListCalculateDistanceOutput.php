<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\ListCalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity\Distance;

readonly class ListCalculateDistanceOutput{

  public static function make(array $distances): array
  {
    $count = $distances['count'];
    $distancesData = $distances['result'];
    $distances = array_map(function (Distance $distance) {
      return [
        'origin' => $distance->getOrigin()->toString(),
        'destination' => $distance->getDestination()->toString(),
        'distance' => $distance->getDistance(),
        'type' => 'Kilometers'
      ];
    }, $distancesData);

    return [
      'count' => $count,
      'distances' => $distances
    ];
  }
}