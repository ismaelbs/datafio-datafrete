<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity\Distance;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepFinderInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;

class CalculateDistance
{
  public function __construct(
    private CepFinderInterface $cepFinder,
    private DistanceRepositoryInterface $distanceRepository
  )
  {
  }

  public function execute(CalculateDistanceInput $input): CalculateDistanceOutput {
    $origin = $this->cepFinder->find($input->originCep);
    $destination = $this->cepFinder->find($input->destinationCep);
    $distance = new Distance(
      id: null,
      origin: $origin,
      destination: $destination
    );
    $distance->calculateDistanceInKilometers();
    $this->distanceRepository->save($distance);
    return CalculateDistanceOutput::make(
      $input->originCep,
      $input->destinationCep,
      $distance->getDistance()
    );
  }
}