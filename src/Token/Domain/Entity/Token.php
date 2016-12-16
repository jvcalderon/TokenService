<?php

namespace Token\Domain\Entity;

use Ddd\Domain\DomainEventPublisher;
use Token\Domain\Event\TokenCreated;

class Token
{
    /**
     * @var TokenId
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $expirationDatetime;

    public function __construct(TokenId $id, \DateTime $expirationDatetime)
    {
        $this->id = $id;
        $this->expirationDatetime = $expirationDatetime;

        $event = new TokenCreated($this->id);
        DomainEventPublisher::instance()->publish($event);
    }
}