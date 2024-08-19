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
    /** @var DoctrineDistance|null $distance */
    $distance = $this->findOneBy([
      'origin' => $origin,
      'destination' => $destination
    ]);
    if (is_null($distance)) {
      return null;
    }
    $distanceObj = $this->mapping($distance);
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

  public function list(array $config = []): array
  {
    $limit = $config['limit'] ?? 10;
    $offset = $config['offset'] ?? 0;
    $query = $this->createQueryBuilder('d')
      ->orderBy('d.createdAt', 'ASC')
      ->setMaxResults($limit)
      ->setFirstResult($offset)
      ->getQuery();
    /** @var DoctrineDistance[] $distances */
    $distances = $query->getResult();
    return array_map(function (DoctrineDistance $distance) {
      return $this->mapping($distance);
    }, $distances);
  }

  private function mapping(DoctrineDistance $doctrineDistance): Distance {
    $distanceObj = new Distance(
      DistanceId::fromString($doctrineDistance->getId()),
      Cep::parse($doctrineDistance->getOrigin(), (float) $doctrineDistance->getOriginLatitude(), (float) $doctrineDistance->getOriginLongitude()),
      Cep::parse($doctrineDistance->getDestination(), (float) $doctrineDistance->getDestinationLatitude(), (float) $doctrineDistance->getDestinationLongitude()),
    );

    $distanceObj->setCreatedAt($doctrineDistance->getCreatedAt());
    $distanceObj->setUpdatedAt($doctrineDistance->getUpdatedAt());
    $distanceObj->setDistance((float) $doctrineDistance->getDistance());
    $distanceObj->getOrigin()->setLatitude((float) $doctrineDistance->getOriginLatitude());
    $distanceObj->getOrigin()->setLongitude((float) $doctrineDistance->getOriginLongitude());
    $distanceObj->getDestination()->setLatitude((float) $doctrineDistance->getDestinationLatitude());
    $distanceObj->getDestination()->setLongitude((float) $doctrineDistance->getDestinationLongitude());
    return $distanceObj;
  }
}