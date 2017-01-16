<?php

namespace Token\Application\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Token\Domain\Model\Token;
use Token\Domain\Model\TokenId;

class CreateTokenService implements TokenServiceInterface
{

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * @var Token
     */
    private $token;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public static function endpointName()
    {
        return '_create_token';
    }

    public function execute()
    {
        $this->token = new Token(new TokenId());
        return new Response(null, Response::HTTP_CREATED, ['Location' => $this->getLocation()]);
    }

    private function getLocation()
    {
        return $this->urlGenerator->generate(
            ViewTokenService::endpointName(),
            ['tokenId' => (string)$this->token->id()],
            UrlGeneratorInterface::ABSOLUTE_URL);
    }
}