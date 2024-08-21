<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity\Distance;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepCacheInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepFinderInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;

class CalculateDistance
{
  public function __construct(
    private CepFinderInterface $cepFinder,
    private DistanceRepositoryInterface $distanceRepository,
    private CepCacheInterface $cepCache
  )
  {
  }

  public function execute(CalculateDistanceInput $input): CalculateDistanceOutput {
    $distance = $this->alreadyCalculated($input);
    if (!is_null($distance)) {
      return CalculateDistanceOutput::make(
        $distance->getOrigin()->toString(),
        $distance->getDestination()->toString(),
        $distance->getDistance()
      );
    }

    $origin = $this->getOriginOnCepCacheOrFind($input);
    $destination = $this->getDestinationOnCepCacheOrFind($input);

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

  private function getOriginOnCepCacheOrFind(CalculateDistanceInput $input): Cep {
    $origin = $this->cepCache->get($input->originCep);
    if (!is_null($origin)) {
      return $origin;
    }
    $origin = $this->cepFinder->find($input->originCep);
    $this->cepCache->save($origin);
    return $origin;
  }

  private function getDestinationOnCepCacheOrFind(CalculateDistanceInput $input): Cep {
    $destination = $this->cepCache->get($input->destinationCep);
    if (!is_null($destination)) {
      return $destination;
    }
    $destination = $this->cepFinder->find($input->destinationCep);
    $this->cepCache->save($destination);
    return $destination;
  }
}