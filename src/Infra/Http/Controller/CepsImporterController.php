<?php
namespace Isma\Datafrete\Infra\Http\Controller;

use Isma\Datafrete\Modules\DistanceCalculator\Usecase\ImportCepsFromFile\ImportCepsFromFile;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\ImportCepsFromFile\ImportCepsFromFileInput;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
class CepsImporterController
{
  public function __construct(
    private ImportCepsFromFile $importCepsFromFile
  ) {
  }

  public function import(Request $request, Response $response): Response {
    $response = $response->withHeader('Content-Type', 'application/json');
    $file = $request->getUploadedFiles()['file'];
    if ($file->getError() !== UPLOAD_ERR_OK) {
      $response->getBody()->write(json_encode([
        "error" => "An error has occurred"
      ], JSON_PRETTY_PRINT));
      return $response->withStatus(400);
    }
    $uri = $file->getStream()->getMetadata('uri');
    $this->importCepsFromFile->execute(ImportCepsFromFileInput::make($uri));
    return $response->withStatus(200);
  }
}