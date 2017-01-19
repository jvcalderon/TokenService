<?php

namespace Token\Domain\Model;

class TokenTest extends \PHPUnit_Framework_TestCase
{

    const MOCKED_TOKEN_STRING_VALUE = 'tokenStringValue';

    /**
     * @test
     */
    public function idMustReturnGivenIdString()
    {
        $this->assertEquals(self::MOCKED_TOKEN_STRING_VALUE, (new Token($this->getTokenIdMock()))->id());
    }

    /**
     * @test
     */
    public function ttlMustReturnAnIntegerValue()
    {
        $token = new Token($this->getTokenIdMock());
        $this->assertInternalType('int', $token->ttl());
        $this->assertGreaterThan(0, $token->ttl());
    }

    /**
     * @test
     */
    public function expirationDatetimeMustReturnADateTimeObj()
    {
        $token = new Token($this->getTokenIdMock());
        $this->assertInstanceOf('\\DateTime', $token->expirationDatetime());
    }

    /**
     * @test
     */
    public function expireMustInvalidateExpirationDatetime()
    {
        $token = new Token($this->getTokenIdMock());
        $token->expire();
        $this->assertEquals(0, $token->expirationDatetime()->format('U'));
    }

    private function getTokenIdMock()
    {
        $tokenIdMock = $this->createMock(TokenId::class);
        $tokenIdMock->method('id')->willReturn(self::MOCKED_TOKEN_STRING_VALUE);
        $tokenIdMock->method('equals')->willReturn(true);
        $tokenIdMock->method('__toString')->willReturn(self::MOCKED_TOKEN_STRING_VALUE);

        return $tokenIdMock;
    }
}
