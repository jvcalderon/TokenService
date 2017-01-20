<?php

namespace Token\Application\Service;

use Symfony\Component\Routing\Generator\UrlGenerator;

class CreateTokenServiceTest extends \PHPUnit_Framework_TestCase
{
    const MOCKED_URI = 'http://mocked-uri';

    /**
     * @test
     */
    public function endpointNameMustBeAString()
    {
        $this->assertInternalType('string', CreateTokenService::endpointName());
    }

    /**
     * @test
     */
    public function executeMustReturnAValidResponse()
    {
        $createTokenService = new CreateTokenService($this->getUrlGeneratorMock());
        $response = $createTokenService->execute();
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals('201', $response->getStatusCode());
        $this->assertEquals(self::MOCKED_URI, $response->headers->get('Location'));
    }

    private function getUrlGeneratorMock()
    {
        $urlGeneratorMock = $this->createMock(UrlGenerator::class);
        $urlGeneratorMock->method('generate')->willReturn(self::MOCKED_URI);

        return $urlGeneratorMock;
    }
}
