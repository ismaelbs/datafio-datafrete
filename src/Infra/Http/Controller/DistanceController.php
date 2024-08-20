<?php
namespace Isma\Datafrete\Infra\Http\Controller;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepCoordenatesNotFoundException;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepIsInvalidExeception;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistanceInput;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\ListCalculateDistance\ListCalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\ListCalculateDistance\ListCalculateDistanceInput;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class DistanceController
{
  public function __construct(
    private readonly CalculateDistance $calculateDistance,
    private readonly ListCalculateDistance $listCalculateDistance,
    private readonly Twig $twig
  )
  {
  }
  public function post(Request $request, Response $response): Response {
    $response = $response->withHeader('Content-Type', 'application/json');
    $body = (array) $request->getParsedBody();
    if (!isset($body["ceps"])) {
      $response->getBody()->write(json_encode([
        "error" => "Ceps are required"
      ]));
      return $response->withStatus(400);
    }

    if (!isset($body["ceps"]["origin"]) || !isset($body["ceps"]["destination"])) {
      $response->getBody()->write(json_encode([
        "error" => "Ceps are required"
      ]));
      return $response->withStatus(400);
    }

    ["origin" => $origin, "destination" => $destination] = $body["ceps"];
    try {
      $distanceOutput = $this->calculateDistance->execute(
          CalculateDistanceInput::make($origin, $destination)
      );
    } catch (CepIsInvalidExeception|CepCoordenatesNotFoundException $e) {
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

  public function list(Request $request, Response $response): Response
  {
    $response = $response->withHeader('Content-Type', 'application/json');
    $params = (array) $request->getQueryParams();
    $limit = 10;
    $offset = 0;
    $total = 0;
    $draw = 1;
    if (isset($params["limit"]) && $params["limit"] > 0) {
      $limit = $params["limit"];
    }
    if (isset($params["offset"]) && $params["offset"] > 0) {
      $offset = $params["offset"];
    }
    $distances = $this->listCalculateDistance->execute(ListCalculateDistanceInput::make($limit, $offset));
    $total = $distances["count"];
    $distances = $distances["distances"];
    $response->getBody()->write(json_encode([
      "data" => $distances,
      'draw'            => $draw,
      'recordsTotal'    => $total,
      'recordsFiltered' => $total,
    ], JSON_PRETTY_PRINT));
    return $response->withStatus(200);
  }

  public function index(Request $request, Response $response): Response {
    return $this->twig->render($response, 'index/index.twig');
  }
}