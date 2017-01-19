<?php

namespace Token\Domain\Model;

class TokenIdTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function createdTokenIdMustBeAString()
    {
        $this->assertInternalType('string', (new TokenId())->id());
    }

    /**
     * @test
     */
    public function instancesWithTheSameIdMustBeEquals()
    {
        $token1 = new TokenId();
        $token2 = new TokenId($token1->id());
        $this->assertEquals($token1, $token2);
        $this->assertEquals(true, $token1->equals($token2));
    }

    /**
     * @test
     */
    public function toStringMethodMustReturnTheIdString()
    {
        $tokenId = new TokenId();
        $tokenIdString = $tokenId->id();
        $this->assertEquals($tokenIdString, (string)$tokenId);
    }
}
