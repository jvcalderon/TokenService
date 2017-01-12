<?php

namespace Token\Application\Service;

use Symfony\Component\HttpFoundation\Response;
use Token\Application\Service\AbstractFactory\TokenService;
use Token\Application\Service\AbstractFactory\TokenServiceInterface;
use Token\Domain\Model\Token;
use Token\Domain\Model\TokenId;

class ExpireTokenService extends TokenService implements TokenServiceInterface
{

    public static function endpointName()
    {
        return '_expire_token';
    }

    public function execute(string $tokenId, \DateTime $expirationDatetime = null)
    {
        if (!$expirationDatetime || 0 == $expirationDatetime->format('U')) {
            $this->response = new Response(null, Response::HTTP_NOT_FOUND);
        } else {
            $this->token = new Token(new TokenId($tokenId));
            $this->token->expire();
            $this->response = new Response(null, Response::HTTP_NO_CONTENT);
        }

        return $this;
    }
}