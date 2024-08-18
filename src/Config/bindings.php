<?php
declare(strict_types=1);
use Doctrine\ORM\EntityManagerInterface;
use Isma\Datafrete\Config\Config;
use Isma\Datafrete\Infra\CepFinder\BrasilApi;
use Isma\Datafrete\Infra\Database\Doctrine\CalculateDistance\Entities\Distance;
use Isma\Datafrete\Infra\Database\Doctrine\PostgresEntityManager;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepFinderInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;
use function DI\create;

return [
  Config::class => create(Config::class)->constructor(
    require CONFIGS_PATH
  ),
  CepFinderInterface::class => create(BrasilApi::class),
  EntityManagerInterface::class => fn (Config $config) => PostgresEntityManager::get($config),
  DistanceRepositoryInterface::class => fn (EntityManagerInterface $entityManagerInterface) => $entityManagerInterface->getRepository(Distance::class),
];