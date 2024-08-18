<?php
declare(strict_types=1);

namespace Isma\Datafrete\Infra\CepFinder;
use GuzzleHttp\Client;
use Isma\Datafrete\Config\Config;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepException;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepFinderInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Psr\Container\ContainerInterface;

class BrasilApi implements CepFinderInterface
{
  private string $url;
  public function __construct(ContainerInterface $container) {
    $config = $container->get(Config::class);
    $this->url = $config->get('apis.brasilapi.url');
  }
  public function find(string $cep): Cep
  {
    $client = new Client(['base_uri' => $this->url]);
    $response = $client->get("/api/cep/v2/{$cep}");
    if ($response->getStatusCode() !== 200) {
      throw CepException::notFound($cep);
    }
    $response = json_decode($response->getBody()->getContents(), true);
    $lat = floatval($response['location']['coordinates']['latitude']);
    $lng = floatval($response['location']['coordinates']['longitude']);
    return Cep::parse($response['cep'], $lat, $lng);
  }
}