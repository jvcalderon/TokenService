<?php

namespace Token\Domain\Model;

class TokenId
{
    /**
     * @var string
     */
    private $id;

    /**
     * TokenId constructor.
     * @param string|null $id
     */
    public function __construct(string $id = null)
    {
        $this->id = null === $id ? uniqid() . bin2hex(openssl_random_pseudo_bytes(32)) : $id;
    }

    /**
     * @return null|string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param TokenId $tokenId
     *
     * @return bool
     */
    public function equals(TokenId $tokenId)
    {
        return $this->id() === $tokenId->id();
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->id();
    }
}