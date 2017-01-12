<?php

namespace Token\Application\Service;

use Hateoas\Hateoas;
use Symfony\Component\HttpFoundation\Response;
use Token\Application\Dto\TokenView;
use Token\Application\Service\AbstractFactory\TokenService;
use Token\Application\Service\AbstractFactory\TokenServiceInterface;
use Token\Domain\Model\Token;
use Token\Domain\Model\TokenId;

class ViewTokenService extends TokenService implements TokenServiceInterface
{

    const ENDPOINT_NAME = '_view_token';

    /**
     * @var Hateoas
     */
    private $serializer;

    public function __construct(Hateoas $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function endpointName()
    {
        return self::ENDPOINT_NAME;
    }

    public function execute(string $tokenId, \DateTime $expirationDatetime = null)
    {
        if (!$expirationDatetime || 0 == $expirationDatetime->format('U')) {
            $this->response = new Response(null, Response::HTTP_NOT_FOUND);
        } else {

            $tokenId = new TokenId($tokenId);
            $this->token = new Token($tokenId);

            $tokenView = new TokenView($this->token->id(), $this->token->expirationDatetime());
            $content = $this->serializer->serialize($tokenView, 'json');

            $this->response = new Response($content, Response::HTTP_OK, ['Content-Type' => 'application/hal+json']);
        }

        return $this;
    }
}