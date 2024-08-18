<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra\Database\Doctrine\CalculateDistance\Entities;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Isma\Datafrete\Infra\Database\Doctrine\CalculateDistance\Repostory\DistanceRepository;

#[Entity(repositoryClass: DistanceRepository::class)]
#[Table(name: 'distance', indexes: ['origin', 'destination'], schema: 'datafrete')]
class Distance
{
  #[Id]
  #[Column(type: Types::STRING, length: 36)]
  private string $id;

  #[Column(type: Types::STRING, unique: true, length: 8)]
  private string $origin;

  #[Column(type: Types::STRING, unique: true, length: 8)]
  private string $destination;

  #[Column(type: Types::DECIMAL, precision: 10, scale: 2)]
  private string $distance;

  #[Column(type: Types::DATETIME_IMMUTABLE, name: 'created_at')]
  private DateTimeImmutable $createdAt;

  #[Column(type: Types::DATETIME_IMMUTABLE, name: 'updated_at')]
  private DateTimeImmutable $updatedAt;

  #[Column(type: Types::STRING, name: 'destination_latitude', length: 20)]
  public string $destinationLatitude;

  #[Column(type: Types::STRING, name: 'destination_longitude', length: 20)]
  public string $destinationLongitude;

  #[Column(type: Types::STRING, name: 'origin_latitude', length: 20)]
  public string $originLatitude;

  #[Column(type: Types::STRING, name: 'origin_longitude', length: 20)]
  public string $originLongitude;

  public function __construct()
  {
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getOrigin(): string
  {
    return $this->origin;
  }

  public function getDestination(): string
  {
    return $this->destination;
  }

  public function getDistance(): string
  {
    return $this->distance;
  }

  public function getCreatedAt(): DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function getUpdatedAt(): DateTimeImmutable
  {
    return $this->updatedAt;
  }

  public function getDestinationLatitude(): string
  {
    return $this->destinationLatitude;
  }

  public function getDestinationLongitude(): string
  {
    return $this->destinationLongitude;
  }

  public function getOriginLatitude(): string
  {
    return $this->originLatitude;
  }

  public function getOriginLongitude(): string
  {
    return $this->originLongitude;
  }

  public function setId(string $id): void
  {
    $this->id = $id;
  }

  public function setOrigin(string $origin): void
  {
    $this->origin = $origin;
  }

  public function setDestination(string $destination): void
  {
    $this->destination = $destination;
  }

  public function setDistance(string $distance): void
  {
    $this->distance = $distance;
  }

  public function setCreatedAt(DateTimeImmutable $createdAt): void
  {
    $this->createdAt = $createdAt;
  }

  public function setUpdatedAt(DateTimeImmutable $updatedAt): void
  {
    $this->updatedAt = $updatedAt;
  }

  public function setDestinationLatitude(string $destinationLatitude): void
  {
    $this->destinationLatitude = $destinationLatitude;
  }

  public function setDestinationLongitude(string $destinationLongitude): void
  {
    $this->destinationLongitude = $destinationLongitude;
  }

  public function setOriginLatitude(string $originLatitude): void
  {
    $this->originLatitude = $originLatitude;
  }

  public function setOriginLongitude(string $originLongitude): void
  {
    $this->originLongitude = $originLongitude;
  }
}