<?php

namespace Token\Domain\Model\Event\AbstractFactory;

use Ddd\Domain\DomainEvent;
use Ddd\Domain\Event\PublishableDomainEvent;
use Token\Domain\Model\TokenId;

abstract class TokenEvent implements DomainEvent, PublishableDomainEvent
{
    /**
     * @var TokenId
     */
    protected $tokenId;

    /**
     * @var \DateTime
     */
    protected $occurredOn;

    public function __construct(TokenId $tokenId)
    {
        $this->tokenId = $tokenId->id();
        $this->occurredOn = new \DateTime();
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
