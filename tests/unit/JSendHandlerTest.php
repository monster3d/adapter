<?php

class JSendHandlerTest extends \PHPUnit_Framework_TestCase {

    private $gateway;
    /**
     *
     * @var JSendHandler
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
        $this->handler  = new JSendHandler();
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

    public function testCanAcceptCoreHandlerResultSuccess()
    {
        $result    = null;
        $handler   = $this->handler;
        $stdObject = $this->stdObject;
        $gateway   = $this->gateway;

        $stdObject->code = 200;
        $jSendData = [
            'status' => 'success',
            'data'   => ['object' => ['data' => true]]
        ];

        $stdObject->raw_body = json_encode($jSendData);
        $handler->execute($stdObject, $this->gateway);
        $result = $gateway->getResponse();
        $this->assertInternalType('bool', $result['data']['object']);
        $this->assertEquals(true, $result['data']['object']);
    }

    /**
     *
     * @expectedException FailGatewayException
     *
     */
    public function testCanAcceptCoreHandlerResultFail()
    {
        $handler   = $this->handler;
        $stdObject = $this->stdObject;

        $stdObject->code = 200;
        $jSendData = [
            'status' => 'fail',
            'data'   => ['message' => 'fail']
        ];
        $stdObject->raw_body = json_encode($jSendData);
        $handler->execute($stdObject, $this->gateway);
    }

    /**
     *
     * @expectedException ErrorGatewayException
     *
     */
    public function testCanAcceptCoreHandlerResultError()
    {
       $handler   = $this->handler;
       $stdObject = $this->stdObject;

       $stdObject->code = 200;
       $jSendData = [
           'status'  => 'error',
           'message' => 'error'
       ];
       $stdObject->raw_body = json_encode($jSendData);
       $handler->execute($stdObject, $this->gateway);
    }

    /**
     *
     * @expectedException HttpGatewayException
     *
     */
    public function testCatAcceptResponseHttpCodeNot200()
    {
        $handler   = $this->handler;
        $stdObject = $this->stdObject;
        $stdObject->code = 500;
        $stdObject->raw_body = null;
        $handler->execute($stdObject, $this->gateway);
    }
}
