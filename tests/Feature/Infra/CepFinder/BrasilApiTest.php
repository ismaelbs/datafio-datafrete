<?php
namespace Test\Datafrete\Feature\Infra\CepFinder;

use Isma\Datafrete\Config\Config;
use Isma\Datafrete\Infra\CepFinder\BrasilApi;
use Test\Datafrete\Unit\Helpers\CepFinder\CepFinderMock;
uses()->group("feature");
it("should be able to find cep in Brasil Api", function () {
  $config = new Config([
    "apis" => [
      "brasilapi" => [
        "url" => "https://brasilapi.com.br/api"
      ]
    ]
  ]);
  $cepFinder = new BrasilApi($config);
  $cep = $cepFinder->find(
    CepFinderMock::JOACABA_CEP
  );
  expect($cep->toString())->toBe(CepFinderMock::JOACABA_CEP);
});