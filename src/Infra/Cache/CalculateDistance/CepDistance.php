<?php
namespace Isma\Datafrete\Infra\Cache\CalculateDistance;
use Isma\Datafrete\Modules\DistanceCalculator\Domain\ValueObject\Cep;
use Isma\Datafrete\Modules\DistanceCalculator\Gateway\CepCacheInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class CepDistance implements CepCacheInterface
{
  private const CACHE_KEY = 'cep_distance_';
  public function __construct(
    private RedisAdapter $cache
  )
  {
  }

  public function get(string $cep): ?Cep
  {
    $value = $this->cache->getItem(self::CACHE_KEY . $cep);
    if (!$value->isHit()) {
      return null;
    }
    var_dump($value->get());
    return null;
  }

  public function save(Cep $cep): void
  {
    $cacheItem = $this->cache->getItem(self::CACHE_KEY . $cep->toString());
    $cacheItem->set($cep);
    $this->cache->save($cacheItem);
  }
}