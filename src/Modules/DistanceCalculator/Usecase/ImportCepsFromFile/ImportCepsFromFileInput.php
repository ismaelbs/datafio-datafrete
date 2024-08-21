<?php
declare(strict_types=1);
namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\ImportCepsFromFile;

class ImportCepsFromFileInput {

  public function __construct(
    public readonly string $filePath
  ) {
  }

  public static function make(string $filePath): ImportCepsFromFileInput
  {
    return new self($filePath);
  }
}