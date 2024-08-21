<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra\Http\Routes;
use Isma\Datafrete\Infra\Http\Controller\CepsImporterController;
use Isma\Datafrete\Infra\Http\Controller\DistanceController;
use Slim\App;

class DistanceRoutes {
  public static function register(App $app) {
    $app->post('/', [DistanceController::class, 'post']);
    $app->get('/list', [DistanceController::class, 'list']);
    $app->get('/', [DistanceController::class, 'index']);
    $app->post('/import', [CepsImporterController::class, 'import']);
  }
}