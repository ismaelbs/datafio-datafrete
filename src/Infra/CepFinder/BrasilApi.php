<?php
declare(strict_types=1);

namespace Isma\Datafrete\Infra\CepFinder;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepException;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepFinderInterface;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;

class BrasilApi implements CepFinderInterface
{
  private string $url;
  public function __construct() {
    $this->url = 'https://brasilapi.com.br/api/cep/v2/';
  }
  public function find(string $cep): Cep
  {
    $url = "{$this->url}{$cep}";
    $response = file_get_contents($url);
    if ($response === false) {
      throw CepException::notFound($cep);
    }
    $response = json_decode($response, true);
    $lat = floatval($response['location']['coordinates']['latitude']);
    $lng = floatval($response['location']['coordinates']['longitude']);
    return Cep::parse($response['cep'], $lat, $lng);
  }
}