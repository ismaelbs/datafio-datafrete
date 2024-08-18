<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra\Database\Doctrine;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Isma\Datafrete\Config\Config;

class PostgresEntityManager
{
  private function __construct() { }
  public static function get(Config $config): EntityManagerInterface
  {
    $entitiesPath = [
      __DIR__ . '/CalculateDistance/Entities/',
    ];
    $attributesConfiguration = ORMSetup::createAttributeMetadataConfiguration(
      paths: $entitiesPath,
      isDevMode: true,
    );
    $connection = DriverManager::getConnection([
      'dbname' => $config->get('database.name'),
      'user' => $config->get('database.user'),
      'password' => $config->get('database.password'),
      'host' => $config->get('database.host'),
      'driver' => $config->get('database.driver'),
    ], $attributesConfiguration);

    return new EntityManager($connection, $attributesConfiguration);
  }
}