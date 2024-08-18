<?php
declare(strict_types=1);
use Dotenv\Dotenv;
use Isma\Datafrete\Infra\DI\Container;
use Isma\Datafrete\Infra\App;
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Config/constants.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$container = new Container(require CONTAINER_BINDINGS);
App::boot($container->getContainer());