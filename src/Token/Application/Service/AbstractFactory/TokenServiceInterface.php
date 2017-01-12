<?php

namespace Token\Application\Service\AbstractFactory;

use Symfony\Component\HttpFoundation\Response;
use Token\Domain\Model\Token;

interface TokenServiceInterface
{
    /**
     * @return Token
     */
    public function token();

    /**
     * @return Response
     */
    public function response();

    /**
     * @return string
     */
    static function endpointName();
}