<?php

namespace Token\Application\Service;

use Hateoas\Hateoas;
use Symfony\Component\HttpFoundation\Response;
use Token\Application\Dto\TokenView;

class ViewTokenService
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

    public function execute(string $tokenId, \DateTime $expirationDatetime = null)
    {
        if (!$expirationDatetime || 0 == $expirationDatetime->format('U')) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $tokenView = new TokenView($tokenId, $expirationDatetime);
        $content = $this->serializer->serialize($tokenView, 'json');

        return new Response($content, Response::HTTP_OK, ['Content-Type' => 'application/hal+json']);
    }
}