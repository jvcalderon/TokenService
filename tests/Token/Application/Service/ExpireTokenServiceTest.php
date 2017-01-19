<?php

namespace Token\Application\Service;

use Symfony\Component\Routing\Generator\UrlGenerator;

class ExpireTokenServiceTest extends \PHPUnit_Framework_TestCase
{

    private $expireTokenService;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->expireTokenService = new ExpireTokenService();
    }

    /**
     * @test
     */
    public function endpointNameMustBeAString()
    {
        $this->assertInternalType('string', ExpireTokenService::endpointName());
    }

    /**
     * @test
     */
    public function nullDateTimeMustReturnNotFoundResponse()
    {
        $response = $this->expireTokenService->execute('tokenId');
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function givenDateMustReturnNoContentResponse()
    {
        $response = $this->expireTokenService->execute('tokenId', new \DateTime());
        $this->assertEquals(204, $response->getStatusCode());
    }
}
