<?php

class RestApiGatewayWithHandlerTest extends \PHPUnit_Framework_TestCase
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
        $stub = [
                'status' => 'success',
                'data'   => ['objects' => ['boolean' => true, 'int' => 1]]
        ];

        UnirestRequestDummy::setResponseResult(json_encode($stub), '', 200);
        $handler = $this->getMockBuilder(JSendHandler::class)
            ->setMethods(['execute'])
            ->getMock();

        $handler->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(json_encode($stub)));

        $this->handler = $handler;
        $this->driver = new UnirestRequestDummy();
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
        new RestApiGateway($this->driver, $host, null, $this->handler);
    }

    public function testCanSendGetRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new RestApiGateway($this->driver, $host, null, $this->handler);
        $adapter->get('/test/', []);
        $result = $adapter->getResponse();
        self::assertInstanceOf(Unirest\Response::class, $result);
    }

    public function testCanSendPostRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new RestApiGateway($this->driver, $host, null, $this->handler);
        $adapter->post('/test/', [], json_encode(['test' => 'test']));
        $result = $adapter->getResponse();
        self::assertInstanceOf(Unirest\Response::class, $result);
    }

    public function testCanSendPutRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new RestApiGateway($this->driver, $host, null, $this->handler);
        $adapter->put('/test/', [], json_encode(['test' => 'test']));
        $result = $adapter->getResponse();
        self::assertInstanceOf(Unirest\Response::class, $result);
    }

    public function testCanSendDeleteRequestViaHandler()
    {
        $host = "http://test.loc";
        $adapter = new RestApiGateway($this->driver, $host, null, $this->handler);
        $adapter->put('/test/', []);
        $result = $adapter->getResponse();
        self::assertInstanceOf(Unirest\Response::class, $result);
    }
}

