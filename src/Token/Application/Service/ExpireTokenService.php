<?php

namespace Token\Application\Service;

use Symfony\Component\HttpFoundation\Response;
use Token\Domain\Model\Token;
use Token\Domain\Model\TokenId;

class ExpireTokenService implements TokenServiceInterface
{
    public static function endpointName()
    {
        return '_expire_token';
    }

    public function execute(string $tokenId, \DateTime $expirationDatetime = null)
    {
        if (!$expirationDatetime || 0 == $expirationDatetime->format('U')) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $token = new Token(new TokenId($tokenId));
        $token->expire();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
