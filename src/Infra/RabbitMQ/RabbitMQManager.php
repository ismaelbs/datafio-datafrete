<?php
namespace Isma\Datafrete\Infra\RabbitMQ;
use Isma\Datafrete\Config\Config;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;

class RabbitMQManager
{
  private AMQPStreamConnection $connection;

  private string $host;
  private string $port;
  private string $user;
  private string $password;

  public function __construct(Config $config)
  {
    $this->host = $config->get('rabbitmq.host');
    $this->port = $config->get('rabbitmq.port');
    $this->user = $config->get('rabbitmq.user');
    $this->password = $config->get('rabbitmq.password');
    $this->connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
  }

  public function createChannel(): AMQPChannel
  {
    return $this->connection->channel();
  }

  public function openConnection(): void {
    if (!is_null($this->connection)) return;
    $this->connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
  }

  public function closeConnection(): void
  {
    if (is_null($this->connection)) return;
    $this->connection->close();
  }
}