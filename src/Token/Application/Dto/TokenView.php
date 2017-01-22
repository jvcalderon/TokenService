<?php

namespace Token\Application\Dto;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          Token\Application\Service\ViewTokenService::ENDPOINT_NAME,
 *          parameters = {
 *              "tokenId" = "expr(object.id())"
 *          },
 *          absolute = true
 *      )
 * )
 */
class TokenView
{
    protected $id;

    /**
     * @Serializer\Type("DateTime<'c'>")
     *
     * @var \DateTime
     */
    protected $expirationDatetime;

    public function __construct($id, $expirationDatetime)
    {
        $this->id = $id;
        $this->expirationDatetime = $expirationDatetime;
    }

    public function id()
    {
        return $this->id;
    }

    public function expirationDatetime()
    {
        return $this->expirationDatetime;
    }
}
