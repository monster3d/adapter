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
    public function testSetHostValid()
    {
        $host = "http://test.loc";
        new CoreApiGateway($this->driver, $host);
    }

    /**
     *
     * @expectedException GateWayException
     *
     */
    public function testHostInvalid()
    {
        $host = "test.loc";
        new CoreApiGateWay($this->driver, $host);
    }

    /**
     *
     * Тестирует GET запрос
     *
     */
    public function testGetRequest()
    {
        $coreApiGateway = new CoreApiGateway($this->driver, 'http://test.loc');
        $coreApiGateway->get('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $coreApiGateway->getResponse();
        $this->assertInstanceOf(Unirest\Response::class, $result);
    }

    /**
     *
     * Тестирует POST запрос
     *
     */
    public function testPostRequest()
    {
        $coreApiGateway = new CoreApiGateway($this->driver, 'http://test.loc');
        $coreApiGateway->post('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $coreApiGateway->getResponse();
        $this->assertInstanceOf(Unirest\Response::class, $result);
    }

    /**
     *
     * Тестирует PUT запрос
     *
     */
    public function testPutRequest()
    {
        $coreApiGateway = new CoreApiGateway($this->driver, 'http://test.loc');
        $coreApiGateway->put('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $coreApiGateway->getResponse();
        $this->assertInstanceOf(Unirest\Response::class, $result);
    }

    /**
     *
     * Тестирует DELETE запрос
     *
     */
    public function testDeleteRequest()
    {
        $coreApiGateway = new CoreApiGateway($this->driver, 'http://test.loc');
        $coreApiGateway->delete('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $coreApiGateway->getResponse();
        $this->assertInstanceOf(Unirest\Response::class, $result);
    }
}