<?php

namespace Token\Domain\Entity;

use Ddd\Domain\DomainEvent;
use Ddd\Domain\Event\PublishableDomainEvent;

class TokenCreated implements DomainEvent, PublishableDomainEvent
{
    /**
     * @var TokenId
     */
    protected $tokenId;

    /**
     * @var \DateTime
     */
    protected $expirationDatetime;

    /**
     * @var \DateTime
     */
    protected $occurredOn;

    public function __construct(TokenId $tokenId, \DateTime $expirationDatetime)
    {
        $this->tokenId = $tokenId->id();
        $this->expirationDatetime = $expirationDatetime;
        $this->occurredOn = new \DateTime();
    }

    public function tokenId()
    {
        return $this->tokenId;
    }

    public function expirationDatetime()
    {
        return $this->expirationDatetime;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }
}