<?php

namespace Token\Domain\Event;

use Ddd\Domain\DomainEvent;
use Ddd\Domain\Event\PublishableDomainEvent;
use Token\Domain\Entity\TokenId;

class TokenCreated implements DomainEvent, PublishableDomainEvent
{
    /**
     * @var TokenId
     */
    protected $tokenId;

    /**
     * @var \DateTimeImmutable
     */
    protected $occurredOn;

    public function __construct(TokenId $tokenId)
    {
        $this->tokenId = $tokenId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function tokenId()
    {
        return $this->tokenId;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }
}