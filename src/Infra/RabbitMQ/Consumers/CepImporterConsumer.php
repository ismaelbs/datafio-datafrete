<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra\RabbitMQ\Consumers;
use Isma\Datafrete\Infra\RabbitMQ\ConsumerInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistanceInput;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Container\ContainerInterface;

class CepImporterConsumer implements ConsumerInterface {
  public function __construct(private ContainerInterface $container) {
  }
  public function consume(AMQPMessage $message): bool {
    [$origin, $destination] = json_decode($message->body, true);
    $calculateDistance = $this->container->get(CalculateDistance::class);
    try {
      $calculateDistance->execute(CalculateDistanceInput::make($origin, $destination));
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    echo 'Processing CEP: ' . $origin . ' - ' . $destination . PHP_EOL;
    return true;
  }
}