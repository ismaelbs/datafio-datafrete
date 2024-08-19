<?php
declare(strict_types=1);
use Doctrine\ORM\EntityManagerInterface;
use Isma\Datafrete\Config\Config;
use Isma\Datafrete\Infra\Cache\CalculateDistance\CepDistance;
use Isma\Datafrete\Infra\CepFinder\BrasilApi;
use Isma\Datafrete\Infra\Database\Doctrine\CalculateDistance\Entities\Distance;
use Isma\Datafrete\Infra\Database\Doctrine\PostgresEntityManager;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepCacheInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepFinderInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;
use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookup;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupCollection;
use Symfony\WebpackEncoreBundle\Asset\TagRenderer;
use Symfony\WebpackEncoreBundle\Twig\EntryFilesTwigExtension;
use function DI\create;

return [
  Config::class => create(Config::class)->constructor(
    require CONFIGS_PATH
  ),
  CepFinderInterface::class => fn(Config $config) => new BrasilApi($config),
  EntityManagerInterface::class => fn(ContainerInterface $container) => PostgresEntityManager::get($container),
  DistanceRepositoryInterface::class => fn(EntityManagerInterface $entityManagerInterface) => $entityManagerInterface->getRepository(Distance::class),
  RedisAdapter::class => function (Config $config) {
    $host = $config->get('cache.host');
    $port = $config->get('cache.port');
    $user = $config->get('cache.username');
    $password = $config->get('cache.password');
    $dsn = "redis://{$user}:{$password}@{$host}:{$port}";
    return new RedisAdapter(
      RedisAdapter::createConnection($dsn),
    );
  },
  CepCacheInterface::class => fn(RedisAdapter $cache) => new CepDistance($cache),
  Twig::class => function (ContainerInterface $container) {
    $config = $container->get(Config::class);
    $twig = Twig::create(TEMPLATES_PATH, [
      'auto_reload' => $config->get('app.env'),
      'cache' => TEMPLATES_CACHE_PATH,
    ]);
    $twig->addExtension(new EntryFilesTwigExtension($container));
    $twig->addExtension(new AssetExtension($container->get('webpack_encore.packages')));
    return $twig;
  },
  'webpack_encore.packages' => fn() => new Packages(
    new Package(new JsonManifestVersionStrategy(BUILD_PATH . '/manifest.json'))
  ),
  'webpack_encore.tag_renderer' => fn(ContainerInterface $container) => new TagRenderer(
    new EntrypointLookup(BUILD_PATH . '/entrypoints.json'),
    $container->get('webpack_encore.packages')
  ),
];