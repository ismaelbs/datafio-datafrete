<?php
declare(strict_types=1);

namespace Isma\Datafrete\Modules\DistanceCalculator\Usecase\ListCalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\DistanceRepositoryInterface;

class ListCalculateDistance
{
  public function __construct(
    private DistanceRepositoryInterface $distanceRepository
  )
  {
  }

  public function execute(ListCalculateDistanceInput $input): array
  {
    return ListCalculateDistanceOutput::make($this->distanceRepository->list([
      'limit' => $input->limit,
      'offset' => $input->offset
    ]));
  }
}