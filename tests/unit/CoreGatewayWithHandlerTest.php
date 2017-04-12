<?php

class CoreGateWayWithHandlerTest extends \PHPUnit_Framework_TestCase
{

    public $driver;

    /**
     *
     * Before
     *
     */
    public $handler;

    protected function setUp()
    {
        $driver  = $this->createMock(Driver::class);
        $handler = $this->createMock(GatewayResponse::class);
        $this->driver  = $driver;
        $this->handler = $handler;
    }

    /**
     *
     * After
     *
     */
    protected function tearDown()
    {
        $this->driver  = null;
        $this->handler = null;
    }

    /**
     *
     * Тестирует создание шлюза с обработчиком
     *
     */
    public function testCreateBaseCoreGateway()
    {
        $host = "http://test.loc";
        new CoreApiGateway($this->driver, $host, null, $this->handler);
    }

    public function testGetRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new CoreApiGateway($this->driver, $host, null, $this->handler);
        $adapter->get('/test/', []);
        $result = $adapter->getResponse();
        self::assertInstanceOf(Unirest\Response::class, $result);
    }
}

