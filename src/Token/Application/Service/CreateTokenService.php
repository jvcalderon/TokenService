<?php

namespace Token\Application\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Token\Domain\Entity\Token;
use Token\Domain\Entity\TokenId;

class CreateTokenService
{

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    const ENDPOINT_NAME = '_create_token';

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function execute()
    {
        $expirationDatetime = (new \DateTime())->setTimestamp(strtotime("+14 days"));
        $this->token = new Token(new TokenId(), $expirationDatetime);
        $this->response = new Response(null, Response::HTTP_CREATED, ['Location' => $this->getLocation()]);

        return $this;
    }

    public function token()
    {
        return $this->token;
    }

    public function response()
    {
        return $this->response;
    }

    private function getLocation()
    {
        return $this->urlGenerator->generate(
            ViewTokenService::ENDPOINT_NAME,
            ['tokenId' => (string)$this->token->id()],
            UrlGeneratorInterface::ABSOLUTE_URL);
    }
}