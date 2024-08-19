<?php
namespace Isma\Datafrete\Infra\Http\Controller;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepIsInvalidExeception;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistanceInput;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DistanceController
{
  public function __construct(
    private CalculateDistance $calculateDistance,
  )
  {
  }
  public function post(Request $request, Response $response): Response {
    $response = $response->withHeader('Content-Type', 'application/json');
    $body = (array) $request->getParsedBody();
    ["origin" => $origin, "destination" => $destination] = $body["ceps"];
    try {
      $distanceOutput = $this->calculateDistance->execute(
          CalculateDistanceInput::make($origin, $destination)
      );
    } catch (CepIsInvalidExeception $e) {
      $response->getBody()->write(json_encode([
        "error" => $e->getMessage()
      ]));
      return $response->withStatus(400);
    } catch (\Exception $e) {
      $response->getBody()->write(json_encode([
        "error" => "An error has occurred"
      ], JSON_PRETTY_PRINT));
      return $response->withStatus(400);
    }
    $response->getBody()->write(json_encode($distanceOutput, JSON_PRETTY_PRINT));
    return $response->withStatus(200);
  }
}