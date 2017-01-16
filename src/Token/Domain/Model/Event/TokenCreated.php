<?php

namespace Token\Domain\Model\Event;

use Token\Domain\Model\Event\AbstractFactory\TokenEvent;
use Token\Domain\Model\TokenId;

class TokenCreated extends TokenEvent
{

    /**
     * @var \DateTime
     */
    protected $expirationDatetime;

    /**
     * @var int
     */
    protected $ttl;

    public function __construct(TokenId $tokenId, \DateTime $expirationDatetime, int $ttl)
    {
        parent::__construct($tokenId);
        $this->expirationDatetime = $expirationDatetime;
        $this->ttl = $ttl;
    }

    public function expirationDatetime()
    {
        return $this->expirationDatetime;
    }

    public function ttl()
    {
        return $this->ttl;
    }
}