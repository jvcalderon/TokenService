<?php

namespace Token\Infrastructure\Persistence\Domain;

use Ddd\Domain\DomainEventSubscriber;
use Doctrine\Common\Cache\CacheProvider;
use Token\Domain\Model\Event\TokenExpired;

class ExpireTokenEventSubscriber implements DomainEventSubscriber
{
    /**
     * @var CacheProvider
     */
    protected $cache;

    public function __construct(CacheProvider $anEventStore)
    {
        $this->cache = $anEventStore;
    }

    /**
     * @param TokenExpired $aDomainEvent
     */
    public function handle($aDomainEvent)
    {
        $this->cache->delete((string) $aDomainEvent->tokenId());
    }

    public function isSubscribedTo($aDomainEvent)
    {
        return $aDomainEvent instanceof TokenExpired;
    }
}
