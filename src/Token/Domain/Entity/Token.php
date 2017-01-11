<?php

namespace Token\Domain\Entity;

use Ddd\Domain\DomainEventPublisher;

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

    public function __construct(TokenId $id, \DateTime $expirationDatetime)
    {

        if ($expirationDatetime < new \DateTime()) {
            throw new \Exception("Expiration datetime must be greater than now");
        }

        $this->id = $id;
        $this->expirationDatetime = $expirationDatetime;

        $event = new TokenCreated($this->id, $expirationDatetime);
        DomainEventPublisher::instance()->publish($event);
    }

    public function id()
    {
        return $this->id;
    }

    public function expirationDatetime()
    {
        return $this->expirationDatetime;
    }

    public function ttl()
    {
        $currentTimestamp = (new \DateTime())->format('U');
        $expirationTimestamp = $this->expirationDatetime->format('U');
        $secsToExpire = $expirationTimestamp - $currentTimestamp;

        return ($secsToExpire > 0) ? $secsToExpire : 0;
    }
}