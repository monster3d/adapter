<?php

class CoreHandlerTest extends \PHPUnit_Framework_TestCase {

    private $gateway;
    /**
     *
     * @var GatewayResponse
     *
     */
    private $handler;

    /**
     *
     * @var stdClass
     *
     */
    private $stdObject;

    /**
     *
     * Before
     *
     */
    protected function setUp()
    {
        $this->handler  = new GatewayResponse();
        $this->stdObject = new stdClass();
        $gateway = $this->getMockBuilder(Gateway::class)
            ->setMethods(['setResponse', 'getResponse'])
            ->disableOriginalConstructor()
            ->getMock();

        $gateway->expects($this->any())
            ->method('setResponse')
            ->will($this->returnValue($gateway));

        $gateway->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue(['status' => true, 'data' => ['object' => true]]));

        $this->gateway = $gateway;
    }

    /**
     *
     * After
     *
     */
    protected function tearDown()
    {
        $this->stdObject = null;
        $this->handler   = null;
        $this->gateway   = null;
    }

    /**
     *
     * Тестирует обработку ответа Success
     *
     *
     */
    public function testCoreHandlerSuccess()
    {
        $result    = null;
        $handler   = $this->handler;
        $stdObject = $this->stdObject;

        $stdObject->code = 200;
        $jSendData = [
            'status' => 'success',
            'data'   => ['object' => ['data' => true]]
        ];

        $stdObject->raw_body = json_encode($jSendData);
        $gateway = $handler->parse($stdObject, $this->gateway);
        $this->assertInstanceOf(Gateway::class, $gateway);
        $result = $gateway->getResponse();
        $this->assertInternalType('bool', $result['data']['object']);
        $this->assertEquals(true, $result['data']['object']);
    }

    /**
     *
     * Тестирует обработу ответа Fail
     *
     * @expectedException FailGatewayException
     *
     */
    public function testCoreHandlerFail()
    {
        $handler   = $this->handler;
        $stdObject = $this->stdObject;

        $stdObject->code = 200;
        $jSendData = [
            'status' => 'fail',
            'data'   => ['message' => 'fail']
        ];
        $stdObject->raw_body = json_encode($jSendData);
        $handler->parse($stdObject, $this->gateway);
    }

    /**
     *
     * @expectedException ErrorGatewayException
     *
     */
    public function testCoreHandlerError()
    {
       $handler   = $this->handler;
       $stdObject = $this->stdObject;

       $stdObject->code = 200;
       $jSendData = [
           'status'  => 'error',
           'message' => 'error'
       ];
       $stdObject->raw_body = json_encode($jSendData);
       $handler->parse($stdObject, $this->gateway);
    }

    /**
     *
     * Тестирует обработу ответа Fail без исключения
     *
     */
    public function testCoreHandlerFailWithoutException()
    {
        $result    = null;
        $handler   = $this->handler;
        $stdObject = $this->stdObject;
        $handler->exception(false);
        $stdObject->code = 200;
        $jSendData = [
            'status' => 'fail',
            'data'   => ['message' => 'fail']
        ];
        $stdObject->raw_body = json_encode($jSendData);
        $gateway = $handler->parse($stdObject, $this->gateway);
        $this->assertInstanceOf(Gateway::class, $gateway);
        $result = $gateway->getResponse();
        $this->assertInternalType('bool', $result['data']['object']);
        $this->assertEquals(true, $result['data']['object']);
    }

    /**
     *
     * Тестирует обработу ответа Error без исключения
     *
     */
    public function testCoreHandlerErrorWithoutException()
    {
       $result    = null;
       $handler   = $this->handler;
       $stdObject = $this->stdObject;
        $handler->exception(false);
       $stdObject->code = 200;
       $jSendData = [
           'status'  => 'error',
           'message' => 'error'
       ];
       $stdObject->raw_body = json_encode($jSendData);
       $gateway = $handler->parse($stdObject, $this->gateway);
       $result = $gateway->getResponse();
       $this->assertInternalType('bool', $result['data']['object']);
       $this->assertEquals(true, $result['data']['object']);
    }

    /**
     *
     * Тестирует ошибку Http
     *
     * @expectedException HttpGatewayException
     *
     */
    public function testHttpError()
    {
        $handler   = $this->handler;
        $stdObject = $this->stdObject;
        $stdObject->code = 500;
        $stdObject->raw_body = null;
        $handler->parse($stdObject, $this->gateway);
    }
}
