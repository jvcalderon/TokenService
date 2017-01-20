<?php

namespace Token\Infrastructure\Persistence\Domain;

use Ddd\Domain\DomainEventSubscriber;
use Doctrine\Common\Cache\CacheProvider;
use Token\Domain\Model\Event\TokenCreated;

class PersistTokenEventSubscriber implements DomainEventSubscriber
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
     * @param TokenCreated $aDomainEvent
     */
    public function handle($aDomainEvent)
    {
        $this->cache->save(
            (string) $aDomainEvent->tokenId(),
            $aDomainEvent->expirationDatetime()->format('U'),
            $aDomainEvent->ttl());
    }

    public function isSubscribedTo($aDomainEvent)
    {
        return $aDomainEvent instanceof TokenCreated;
    }
}
