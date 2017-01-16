<?php

namespace Token\Domain\Model;

use Ddd\Domain\DomainEventPublisher;
use Token\Domain\Model\Event\TokenCreated;
use Token\Domain\Model\Event\TokenExpired;

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

    /**
     * @var integer
     */
    protected $ttl;

    public function __construct(TokenId $id)
    {

        $this->id = $id;
        $this->expirationDatetime = (new \DateTime())->setTimestamp(strtotime("+14 days"));

        $event = new TokenCreated($this->id(), $this->expirationDatetime(), $this->ttl());
        DomainEventPublisher::instance()->publish($event);
    }

    /**
     * @return TokenId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function expirationDatetime()
    {
        return $this->expirationDatetime;
    }

    public function expire()
    {
        $this->expirationDatetime = (new \DateTime())->setTimestamp(0);
        $event = new TokenExpired($this->id());
        DomainEventPublisher::instance()->publish($event);
    }

    /**
     * @return int
     */
    public function ttl()
    {
        $currentTimestamp = (new \DateTime())->format('U');
        $expirationTimestamp = $this->expirationDatetime->format('U');
        $secsToExpire = (int)($expirationTimestamp - $currentTimestamp);

        return ($secsToExpire > 0) ? $secsToExpire : 0;
    }
}