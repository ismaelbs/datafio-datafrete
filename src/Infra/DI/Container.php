<?php
declare(strict_types=1);
namespace Isma\Datafrete\Infra\DI;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class Container {
  public function __construct(private array $definitions) {
  }
  public function getContainer(): ContainerInterface {
    $builder = new ContainerBuilder();
    $builder->addDefinitions($this->definitions);
    return $builder->build();
  }
}