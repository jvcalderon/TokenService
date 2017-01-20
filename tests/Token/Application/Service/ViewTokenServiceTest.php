<?php

namespace Token\Application\Service;

use Hateoas\Hateoas;

class ViewTokenServiceTest extends \PHPUnit_Framework_TestCase
{
    const MOCKED_TOKEN_ID_STRING = 'tokenId';

    const MOCKED_SERIALIZED_RESPONSE = 'mockedResponse';

    /**
     * @var ViewTokenService
     */
    private $viewTokenService;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $serializer = $this->createMock(Hateoas::class);
        $serializer->method('serialize')->willReturn(self::MOCKED_SERIALIZED_RESPONSE);
        /* @var Hateoas $serializer */
        $this->viewTokenService = new ViewTokenService($serializer);
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
    public function nullDateTimeMustReturnNotFound()
    {
        $response = $this->viewTokenService->execute(self::MOCKED_TOKEN_ID_STRING);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function givenDateMustReturnOkStatus()
    {
        $response = $this->viewTokenService->execute(self::MOCKED_TOKEN_ID_STRING, new \DateTime());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function givenDateMustReturnASerializedResponse()
    {
        $response = $this->viewTokenService->execute(self::MOCKED_TOKEN_ID_STRING, new \DateTime());
        $this->assertEquals(self::MOCKED_SERIALIZED_RESPONSE, $response->getContent());
    }
}
