<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\ImportCepsFromFile;
use Isma\Datafrete\Infra\RabbitMQ\RabbitMQManager;
use PhpAmqpLib\Message\AMQPMessage;
use SplFileObject;

class ImportCepsFromFile {

  public function __construct(
    private RabbitMQManager $rabbitMQManager
  ) {
  }

  public function execute(ImportCepsFromFileInput $input): void
  {
    $rows = $this->readFile($input->filePath);
    $channel =$this->rabbitMQManager->createChannel();
    $channel->queue_declare('ceps queue', false, false, false, false);
    foreach ($rows as $row) {
      [$origin, $destination] = $row;
      $channel->basic_publish(new AMQPMessage(json_encode([$origin, $destination])), '', 'ceps queue');
    }
    $channel->close();
    $this->rabbitMQManager->closeConnection();
  }

  private function readFile(string $file): \Generator {
    $resource = new SplFileObject($file);
    $resource->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD | SplFileObject::DROP_NEW_LINE);
  
    foreach ($resource as $row) {
      [$origin, $destination] = $row;
      if (!isset($origin) || !isset($destination)) continue;
      yield [$origin, $destination];
    }
    $resource = null;
  }
}