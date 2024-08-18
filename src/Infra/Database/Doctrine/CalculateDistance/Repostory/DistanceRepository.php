<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra\Database\Doctrine\CalculateDistance\Repostory;
use Doctrine\ORM\EntityRepository;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\Entity\Distance;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\DistanceId;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;
use Isma\Datafrete\Infra\Database\Doctrine\CalculateDistance\Entities\Distance as DoctrineDistance;

class DistanceRepository extends EntityRepository implements DistanceRepositoryInterface {

  public function get(string $origin, string $destination): ?Distance
  {
    /** @var \Isma\Datafrete\Infra\Database\Doctrine\CalculateDistance\Entities\Distance|null $distance */
    $distance = $this->findOneBy([
      'origin' => $origin,
      'destination' => $destination
    ]);
    if (is_null($distance)) {
      return null;
    }
    $distanceObj = new Distance(
      DistanceId::fromString($distance->getId()),
      Cep::parse($distance->getOrigin(), (float) $distance->getOriginLatitude(), (float) $distance->getOriginLongitude()),
      Cep::parse($distance->getOrigin(), (float) $distance->getDestinationLatitude(), (float) $distance->getDestinationLongitude()),
    );

    $distanceObj->setCreatedAt($distance->getCreatedAt());
    $distanceObj->setUpdatedAt($distance->getUpdatedAt());
    $distanceObj->setDistance((float) $distance->getDistance());
    $distanceObj->getOrigin()->setLatitude((float) $distance->getOriginLatitude());
    $distanceObj->getOrigin()->setLongitude((float) $distance->getOriginLongitude());
    $distanceObj->getDestination()->setLatitude((float) $distance->getDestinationLatitude());
    $distanceObj->getDestination()->setLongitude((float) $distance->getDestinationLongitude());
    return $distanceObj;
  }

  public function save(Distance $distance): void
  {
    $doctrineDistance = new DoctrineDistance();
    $doctrineDistance->setId($distance->getId()->toString());
    $doctrineDistance->setOrigin($distance->getOrigin()->toString());
    $doctrineDistance->setDestination($distance->getDestination()->toString());
    $doctrineDistance->setDistance((string) $distance->getDistance());
    $doctrineDistance->setCreatedAt($distance->getCreatedAt());
    $doctrineDistance->setUpdatedAt($distance->getUpdatedAt());
    $doctrineDistance->setDestinationLatitude((string) $distance->getDestination()->getLatitude());
    $doctrineDistance->setDestinationLongitude((string) $distance->getDestination()->getLongitude());
    $doctrineDistance->setOriginLatitude((string)($distance->getOrigin()->getLatitude()));
    $doctrineDistance->setOriginLongitude((string)$distance->getOrigin()->getLongitude());
    $this->getEntityManager()->persist($doctrineDistance);
    $this->getEntityManager()->flush();
  }
}