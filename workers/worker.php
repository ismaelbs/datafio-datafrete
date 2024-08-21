<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Config/constants.php';
use Dotenv\Dotenv;
use Isma\Datafrete\Infra\DI\Container;
use Isma\Datafrete\Infra\RabbitMQ\Consumers\CepImporterConsumer;
use Isma\Datafrete\Infra\RabbitMQ\QueueConsumer;
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$container = (new Container(require CONTAINER_BINDINGS))->getContainer();

/**
 * @var QueueConsumer $queueConsumer
 */
$queueConsumer = $container->get(QueueConsumer::class);
$queueConsumer
  ->setQueueName('ceps queue')
  ->setExchangeName('ceps exchange')
  ->setRoutingKey('ceps queue')
  ->setExchangeType('topic')
  ->setConsumer($container->get(CepImporterConsumer::class))
  ->run();

