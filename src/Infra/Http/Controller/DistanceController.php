<?php
namespace Isma\Datafrete\Infra\Http\Controller;
use Isma\Datafrete\Config\Config;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistanceInput;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DistanceController
{
  public function __construct(
    private CalculateDistance $calculateDistance,
    private Config $config
  ) 
  {
  }
  public function post(Request $request, Response $response): Response {
    $response = $response->withHeader('Content-Type', 'application/json');
    $body = (array) $request->getParsedBody();
    ["origin" => $origin, "destination" => $destination] = $body["ceps"];
    $distanceOutput = $this->calculateDistance->execute(
        CalculateDistanceInput::make($origin, $destination)
    );
    $response->getBody()->write(json_encode($distanceOutput, JSON_PRETTY_PRINT));
    return $response->withStatus(200);
  }
}