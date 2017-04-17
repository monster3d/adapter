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

    public function testCanCreateObjectOfCoreGateway()
    {
        $host = "http://test.loc";
        new CoreApiGateway($this->driver, $host, null, $this->handler);
    }

    public function testCanSendGetRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new CoreApiGateway($this->driver, $host, null, $this->handler);
        $adapter->get('/test/', []);
        $result = $adapter->getResponse();
        self::assertInstanceOf(stdClass::class, $result);
    }

    public function testCanSendPostRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new CoreApiGateway($this->driver, $host, null, $this->handler);
        $adapter->post('/test/', [], json_encode(['test' => 'test']));
        $result = $adapter->getResponse();
        self::assertInstanceOf(stdClass::class, $result);
    }

    public function testCanSendPutRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new CoreApiGateway($this->driver, $host, null, $this->handler);
        $adapter->put('/test/', [], json_encode(['test' => 'test']));
        $result = $adapter->getResponse();
        self::assertInstanceOf(stdClass::class, $result);
    }

    public function testCanSendDeleteRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new CoreApiGateway($this->driver, $host, null, $this->handler);
        $adapter->put('/test/', []);
        $result = $adapter->getResponse();
        self::assertInstanceOf(stdClass::class, $result);
    }
}

