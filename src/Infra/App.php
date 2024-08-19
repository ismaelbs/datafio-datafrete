<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra;
use Isma\Datafrete\Config\Config;
use Isma\Datafrete\Infra\Http\Routes\DistanceRoutes;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

class App
{
  public static function boot(ContainerInterface $container): void
  {
    $config = $container->get(Config::class);
    $app = AppFactory::createFromContainer($container);
    DistanceRoutes::register($app);
    $twig = $container->get(Twig::class);
    $app->add(TwigMiddleware::create($app, $twig));
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware(
      $config->get('app.displayErrorDetails', true),
      $config->get('app.logErrors', true),
      $config->get('app.logErrorDetails')
    );
    $app->run();
  }
}