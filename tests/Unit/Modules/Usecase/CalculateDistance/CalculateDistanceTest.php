<?php
declare(strict_types=1);

use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepIsInvalidExeception;
use Isma\Datafrete\Modules\DistanceCalculator\Exception\CepNotFoundException;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistanceInput;
use Isma\Datafrete\Modules\DistanceCalculator\Usecase\CalculateDistance\CalculateDistance;
use Test\Datafrete\Unit\Helpers\CepFinder\CepFinderMock;
use Test\Datafrete\Unit\Modules\Usecase\CalculateDistance\CalculateDistanceSut;

uses()->group("unit");


it("should be able to calculate distance when origin and destination are equal", function (string $cepOrigin,string $cepDestination) {
  $sut = CalculateDistanceSut::make();
  $usecase = new CalculateDistance(
    $sut->cepFinder,
    $sut->distanceRepository
  );
  $input = CalculateDistanceInput::make($cepOrigin, $cepDestination);
  $output = $usecase->execute($input);
  expect($output->distance)->toBe(0.0);
})->with([
  ["01001000", "01001000"],
]);

it("should be able to calculate distance when origin and destination are different",
  function (string $cepOrigin,string $cepDestination, float $distance) {
    $sut = CalculateDistanceSut::make();
    $usecase = new CalculateDistance(
      $sut->cepFinder,
      $sut->distanceRepository
    );
    $input = CalculateDistanceInput::make($cepOrigin, $cepDestination);
    $output = $usecase->execute($input);
    expect($output->distance)->toBe($distance);
  }
)->with([
    [CepFinderMock::JOACABA_CEP, CepFinderMock::BLUMENAU_CEP, 243.57],
]);

it("should throw exception when origin or destination not found", function (string $cepOrigin,string $cepDestination) {
  $sut = CalculateDistanceSut::make();
  $usecase = new CalculateDistance(
    $sut->cepFinder,
    $sut->distanceRepository
  );
  $input = CalculateDistanceInput::make($cepOrigin, $cepDestination);
  $usecase->execute($input);
})->with([
  ["01001002", "01001003"],
])->throws(CepNotFoundException::class);

it("should throw exception when origin or destination are invalid", function (string $cepOrigin,string $cepDestination) {
  $sut = CalculateDistanceSut::make();
  $usecase = new CalculateDistance(
    $sut->cepFinder,
    $sut->distanceRepository
  );
  $input = CalculateDistanceInput::make($cepOrigin, $cepDestination);
  $usecase->execute($input);
})->with([
  ["abcdef", "ghijkl"],
  [CepFinderMock::JOACABA_CEP, "ghijkl"],
  ["ghijkl", CepFinderMock::BLUMENAU_CEP]
])->throws(CepIsInvalidExeception::class);

it("should return distance already calculated when origin and destination are equal", function (string $cepOrigin,string $cepDestination) {
  $sut = CalculateDistanceSut::make();
  $usecase = new CalculateDistance(
    $sut->cepFinder,
    $sut->distanceRepository
  );
  $input = CalculateDistanceInput::make($cepOrigin, $cepDestination);
  $usecase->execute($input);
  $usecase->execute($input);
  $usecase->execute($input);
  $usecase->execute($input);
  $usecase->execute($input);
  
  expect($sut->distanceRepository->getCallsSaved())->toBe(1);
  expect($sut->distanceRepository->getCallsGet())->toBe(5);
})->with([
  [CepFinderMock::JOACABA_CEP, CepFinderMock::BLUMENAU_CEP],
]);