<?php

namespace Token\Application\Service\AbstractFactory;

use Symfony\Component\HttpFoundation\Response;
use Token\Domain\Model\Token;

abstract class TokenService implements TokenServiceInterface
{
    /**
     * @var Token
     */
    protected $token;

    /**
     * @var Response
     */
    protected $response;

    public function token()
    {
        return $this->token;
    }

    public function response()
    {
        return $this->response;
    }
}