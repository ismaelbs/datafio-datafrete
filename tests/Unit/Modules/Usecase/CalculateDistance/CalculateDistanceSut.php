<?php
declare(strict_types=1);

namespace Test\Datafrete\Unit\Modules\Usecase\CalculateDistance;
use Test\Datafrete\Unit\Helpers\CepDistanceCache\CepDistanceCacheMock;
use Test\Datafrete\Unit\Helpers\CepFinder\CepFinderMock;
use Test\Datafrete\Unit\Helpers\DistanceRepository\DistanceRepositoryMock;

readonly class CalculateDistanceSut
{
  public CepFinderMock $cepFinder;
  public DistanceRepositoryMock $distanceRepository;
  public CepDistanceCacheMock $cepDistanceCache;
  private function __construct() 
  {
    $this->cepFinder = new CepFinderMock();
    $this->distanceRepository = new DistanceRepositoryMock();
    $this->cepDistanceCache = new CepDistanceCacheMock();
  }

  public static function make(): self
  {
    return new self();
  }
}