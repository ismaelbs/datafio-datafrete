<?php
declare(strict_types=1);
use Doctrine\ORM\EntityManagerInterface;
use Isma\Datafrete\Config\Config;
use Isma\Datafrete\Infra\CepFinder\BrasilApi;
use Isma\Datafrete\Infra\Database\Doctrine\CalculateDistance\Entities\Distance;
use Isma\Datafrete\Infra\Database\Doctrine\PostgresEntityManager;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepFinderInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use function DI\create;

return [
  Config::class => create(Config::class)->constructor(
    require CONFIGS_PATH
  ),
  CepFinderInterface::class => fn(Config $config) => new BrasilApi($config),
  EntityManagerInterface::class => fn(ContainerInterface $container) => PostgresEntityManager::get($container),
  DistanceRepositoryInterface::class => fn(EntityManagerInterface $entityManagerInterface) => $entityManagerInterface->getRepository(Distance::class),
  RedisAdapter::class => function (Config $config) {
    $host = $config->get('redis.host');
    $port = $config->get('redis.port');
    $password = $config->get('redis.password');
    return new RedisAdapter(
      RedisAdapter::createConnection("redis://:root@redis:6379"),
    );
  }
];