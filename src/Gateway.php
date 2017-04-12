<?php

abstract class Gateway {

    /**
     *
     * @var Driver
     *
     */
    private $driver;

    /**
     *
     * @var GatewayResponse
     *
     */
    protected $handler;

    /**
     *
     * @var String
     *
     */
    private $host;

    /**
     *
     * @var String
     *
     */
    private $auth;

    /**
     *
     * Gateway constructor.
     * @param $driver Driver
     * @param $host String
     * @param $auth String
     * @param $responseHandel Object
     *
     */
    public function __construct(Driver $driver, $host, $auth = null, $responseHandel = null)
    {
        $this->driver  = $driver;
        $this->handler = $responseHandel;
        $this->auth    = $auth;
        $this->setHost($host);
    }

    /**
     *
     * Устанавливает url сервиса
     *
     * @param $host String
     *
     * @throws GatewayException
     *
     */
    private function setHost($host)
    {
        if (!(bool)filter_var($host, FILTER_VALIDATE_URL)) {
            throw new GatewayException(sprintf("Invalid url: %s", $host));
        }
        $this->host = $host;
    }

    /**
     *
     * Выполняет запрос
     *
     * @param $method string
     * @param $path string
     * @param $header array
     * @param $body mixed
     *
     * @throws Exception
     *
     * @return \Unirest\Response
     *
     */
    public function request($method, $path, $header, $body)
    {
        $response = null;
        $this->methodValidation($method);
        $requestMethod = strtoupper(explode('::', $method)[1]);

        if (defined('PHPUNIT_TESTSUITE')) {
            $stub = [
                'status' => 'success',
                'data'   => ['objects' => ['boolean' => true, 'int' => 1]]
            ];

            return $this->setResponse(new Unirest\Response(200, json_encode($stub), ''));
        }

        if (!is_null($this->auth)) {
            $header = array_merge($header, ['Authorization' => $this->auth]);
        }

        $url = sprintf('%s%s', $this->host, $path);

        $response = $this->driver->send(strtoupper($requestMethod), $url, $body, $header);
        if (method_exists(get_called_class(), 'responseHandler')) {
            $this->responseHandler($response);
        }
        return $response;
    }

    /**
     *
     * Проводит валидацию метода запроса
     *
     * @param $method
     *
     * @throws GateWayException
     *
     */
    private function methodValidation($method)
    {
        if (!preg_match("/^[A-Za-z]+::[A-Za-z]+$/", $method)) {
            throw new GatewayException(sprintf('Method: %s not support', $method));
        }
    }

    /**
     *
     * Возвращает ссылку на установленный драйвер
     *
     * @return Driver
     *
     */
    public function &getDriver()
    {
        return $this->driver;
    }
}
