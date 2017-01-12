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

    public function __construct(TokenId $tokenId, \DateTime $expirationDatetime)
    {
        parent::__construct($tokenId);
        $this->expirationDatetime = $expirationDatetime;
    }

    public function expirationDatetime()
    {
        return $this->expirationDatetime;
    }
}