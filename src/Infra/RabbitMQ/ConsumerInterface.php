<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra\RabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;

interface ConsumerInterface
{
  public function consume(AMQPMessage $message): bool;
}