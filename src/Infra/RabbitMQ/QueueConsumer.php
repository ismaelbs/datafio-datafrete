<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra\RabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;
use Isma\Datafrete\Infra\RabbitMQ\RabbitMQManager;
use Psr\Container\ContainerInterface;

class QueueConsumer
{
  private string $queueName;
  private string $exchangeName = '';
  private string $exchangeType = '';
  private string $routingKey = '';
  private ConsumerInterface $consumer;
  public function __construct(
    private ContainerInterface $container
  ) {
  }

  public function setConsumer(ConsumerInterface $consumer): self {
    $this->consumer = $consumer;
    return $this;
  }

  public function setQueueName(string $queueName): self {
    $this->queueName = $queueName;
    return $this;
  }

  public function setExchangeName(string $exchangeName): self {
    $this->exchangeName = $exchangeName;
    return $this;
  }

  public function setExchangeType(string $exchangeType): self {
    $this->exchangeType = $exchangeType;
    return $this;
  }

  public function setRoutingKey(string $routingKey): self {
    $this->routingKey = $routingKey;
    return $this;
  }

  public function run(): void {
    if ($this->consumer === null) {
      throw new \Exception('Consumer not set');
    }
    /**
     * @var RabbitMQManager $manager
     */
    $manager = $this->container->get(RabbitMQManager::class);
    $channel = $manager->createChannel();
    $channel->queue_declare($this->queueName, false, false, false, false);
    // $channel->exchange_declare($this->exchangeName, $this->exchangeType, false, false, false);
    // $channel->queue_bind($this->queueName, $this->exchangeName, $this->routingKey);
    $channel->basic_consume($this->queueName, '', false, false, false, false, function (AMQPMessage $msg) {
      $this->consumer->consume($msg);
    });
    while (count($channel->callbacks) > 0) {
      $channel->wait();
    }
    $channel->close();
    $manager->closeConnection();
  }
}