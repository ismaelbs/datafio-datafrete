<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity\Distance;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepException;
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
    if (!Cep::validade($input->originCep)) {
      throw CepException::invalidCep($input->originCep);
    }

    if (!Cep::validade($input->destinationCep)) {
      throw CepException::invalidCep($input->destinationCep);
    }

    $distance = $this->alreadyCalculated($input);
    if (!is_null($distance)) {
      return CalculateDistanceOutput::make(
        $distance->getOrigin()->toString(),
        $distance->getDestination()->toString(),
        $distance->getDistance()
      );
    }
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

  private function alreadyCalculated(CalculateDistanceInput $input): ?Distance {
    return $this->distanceRepository->get($input->originCep, $input->destinationCep);
  }
}