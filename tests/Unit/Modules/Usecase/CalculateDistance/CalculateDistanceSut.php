<?php
declare(strict_types=1);

namespace Test\Datafrete\Unit\Modules\Usecase\CalculateDistance;
use Test\Datafrete\Unit\Helpers\CepFinder\CepFinderMock;
use Test\Datafrete\Unit\Helpers\DistanceRepository\DistanceRepositoryMock;

readonly class CalculateDistanceSut
{
  public CepFinderMock $cepFinder;
  public DistanceRepositoryMock $distanceRepository;
  private function __construct() 
  {
    $this->cepFinder = new CepFinderMock();
    $this->distanceRepository = new DistanceRepositoryMock();
  }

  public static function make(): self
  {
    return new self();
  }
}