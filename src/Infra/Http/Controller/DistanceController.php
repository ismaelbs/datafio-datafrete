<?php
namespace Isma\Datafrete\Infra\Http\Controller;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepIsInvalidExeception;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistanceInput;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\ListCalculateDistance\ListCalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\ListCalculateDistance\ListCalculateDistanceInput;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DistanceController
{
  public function __construct(
    private CalculateDistance $calculateDistance,
    private ListCalculateDistance $listCalculateDistance
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

  public function index(Request $request, Response $response): Response
  {
    $response = $response->withHeader('Content-Type', 'application/json');
    $body = (array) $request->getParsedBody();
    $limit = 10;
    $offset = 0;
    if (isset($body["limit"]) && $body["limit"] > 0) {
      $limit = $body["limit"];
    }
    if (isset($body["offset"]) && $body["offset"] > 0) {
      $offset = $body["offset"];
    }
    $distances = $this->listCalculateDistance->execute(ListCalculateDistanceInput::make($limit, $offset));
    $response->getBody()->write(json_encode($distances, JSON_PRETTY_PRINT));
    return $response->withStatus(200);
  }
}