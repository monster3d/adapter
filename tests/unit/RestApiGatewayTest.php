<?php


class RestApiGatewayTestT extends \PHPUnit_Framework_TestCase
{

    public $driver;

    /**
     *
     * Before
     *
     */
    protected function setUp()
    {
        $stub = [
                'status' => 'success',
                'data'   => ['objects' => ['boolean' => true, 'int' => 1]]
        ];

        $this->driver = new UnirestRequestDummy();
        UnirestRequestDummy::setResponseResult(json_encode($stub), '', 200);
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
        new RestApiGateway($this->driver, $host);
    }

    /**
     *
     * @expectedException InvalidArgumentException
     *
     */
    public function testCanGiveInvalidHostName()
    {
        $host = "test.loc";
        new RestApiGateway($this->driver, $host);
    }

    public function testCanSendGetRequest()
    {
        $RestApiGateway = new RestApiGateway($this->driver, 'http://test.loc');
        $RestApiGateway->get('/test', ['header' => 'value']);
        $result = $RestApiGateway->getResponse();
        $this->assertInstanceOf(Unirest\Response::class, $result);
    }

    public function testCanSendPostRequest()
    {
        $RestApiGateway = new RestApiGateway($this->driver, 'http://test.loc');
        $RestApiGateway->post('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $RestApiGateway->getResponse();
        $this->assertInstanceOf(Unirest\Response::class, $result);
    }

    public function testCanSendPutRequest()
    {
        $RestApiGateway = new RestApiGateway($this->driver, 'http://test.loc');
        $RestApiGateway->put('/test', ['header' => 'value'], json_encode(['key' => 'value']));
        $result = $RestApiGateway->getResponse();
        $this->assertInstanceOf(Unirest\Response::class, $result);
    }

    public function testCanSendDeleteRequest()
    {
        $RestApiGateway = new RestApiGateway($this->driver, 'http://test.loc');
        $RestApiGateway->delete('/test', ['header' => 'value']);
        $result = $RestApiGateway->getResponse();
        $this->assertInstanceOf(Unirest\Response::class, $result);
    }
}