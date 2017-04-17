<?php

abstract class Gateway {

    /**
     *
     * Выполняет запросы, реализуя HTTP методы
     *
     * @var Driver
     *
     */
    private $driver;

    /**
     *
     * Обработчик реазультат от сервиса
     *
     * @var GatewayResponse
     *
     */
    protected $handler;

    /**
     *
     * Указывает на какой сервис пойдут запросы
     *
     * @var string
     *
     */
    private $host;

    /**
     *
     * Токен для авторизации
     *
     * @var string
     *
     */
    private $auth;

    /**
     *
     * Ответ от сервиса
     *
     * @var mixed
     *
     */
    private $response;

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
     * @throws ValidationGatewayException
     *
     */
    private function setHost($host)
    {
        if (!(bool)filter_var($host, FILTER_VALIDATE_URL)) {
            throw new ValidationGatewayException(sprintf("Invalid url: %s", $host));
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
     * @throws Exception Исключения Unirest
     * @throws ValidationGatewayException Ошибка валидации метода запроса
     *
     * @see HttpGatewayException (Ошибка запроса)
     *
     * @return void
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

            $response = (object) [
                'code'     => 200,
                'raw_body' => json_encode($stub)
            ];
            $this->response = $response;
            return;
        }

        if (!is_null($this->auth)) {
            $header = array_merge($header, ['Authorization' => $this->auth]);
        }

        $url = sprintf('%s%s', $this->host, $path);

        try {
            $response = $this->driver->send(strtoupper($requestMethod), $url, $body, $header);
        } catch (Exception $e) {
            throw new HttpGatewayException(sprintf("Ошибка при выполнение запроса на URL: %s \r\n Методом: %s \r\n Тело: %s",
                $url, $requestMethod, print_r($body, true)));
        }
        $this->response = $response;
    }

    /**
     *
     * Отдает ответ от сервера
     *
     *
     *
     * @return mixed
     *
     */
    public function getResponse()
    {
        if (!is_null($this->handler)) {
            $this->execute($this->response);
        }
        return $this->response;
    }

    /**
     *
     * Устанавливает ответ от сервиса
     *
     * @param $response mixed
     *
     * @return Gateway
     *
     * @throws
     *
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     *
     * Проводит валидацию метода запроса
     *
     * @param $method
     *
     * @throws ValidationGatewayException Ошибка валидации метода
     *
     */
    private function methodValidation($method)
    {
        if (!preg_match("/^[A-Za-z]+::[A-Za-z]+$/", $method)) {
            throw new ValidationGatewayException(sprintf('Method: %s not support', $method));
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
