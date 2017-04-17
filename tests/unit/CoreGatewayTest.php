<?php

define('PHPUNIT_TESTSUITE', true);

class CoreGateWayTest extends \PHPUnit_Framework_TestCase
{

    public $driver;

    /**
     *
     * Before
     *
     */
    protected function setUp()
    {
        $driver = $this->createMock(Driver::class);
        $this->driver = $driver;
    }

    /**
     *
     * After
     *
     */
    protected function tearDown()
    {
        $this->driver = null;
    }

    /**
     *
     * Тестирует метода на валидный результат
     *
     */
    public function testCanGiveValidHostName()
    {
        $host = "http://test.loc";
        new CoreApiGateway($this->driver, $host);
    }

    /**
     *
     * @expectedException ValidationGatewayException
     *
     */
    public function testCanGiveInvalidHostName()
    {
        $host = "test.loc";
        new CoreApiGateWay($this->driver, $host);
    }

    /**
     *
     * Тестирует GET запрос
     *
     */
    public function testCanSendGetRequest()
    {
        $coreApiGateway = new CoreApiGateway($this->driver, 'http://test.loc');
        $coreApiGateway->get('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $coreApiGateway->getResponse();
        $this->assertInstanceOf(stdClass::class, $result);
    }

    /**
     *
     * Тестирует POST запрос
     *
     */
    public function testCanSendPostRequest()
    {
        $coreApiGateway = new CoreApiGateway($this->driver, 'http://test.loc');
        $coreApiGateway->post('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $coreApiGateway->getResponse();
        $this->assertInstanceOf(stdClass::class, $result);
    }

    /**
     *
     * Тестирует PUT запрос
     *
     */
    public function testCanSendPutRequest()
    {
        $coreApiGateway = new CoreApiGateway($this->driver, 'http://test.loc');
        $coreApiGateway->put('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $coreApiGateway->getResponse();
        $this->assertInstanceOf(stdClass::class, $result);
    }

    /**
     *
     * Тестирует DELETE запрос
     *
     */
    public function testCanSendDeleteRequest()
    {
        $coreApiGateway = new CoreApiGateway($this->driver, 'http://test.loc');
        $coreApiGateway->delete('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $coreApiGateway->getResponse();
        $this->assertInstanceOf(stdClass::class, $result);
    }
}