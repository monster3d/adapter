<?php

abstract class Gateway {

    /**
     *
     * @var Driver выполняет запросы, реализуя HTTP методы
     *
     */
    private $driver;

    /**
     *
     * @var GatewayHandlerContract обробатывает результаты запроса
     *
     */
    protected $handler;

    /**
     *
     * @var string url сервиса
     *
     */
    private $host;

    /**
     *
     * @var string токен авторизации
     *
     */
    private $auth;

    /**
     *
     * @var mixed ответ от сервиса
     *
     */
    private $response;

    /**
     *
     * Gateway constructor
     *
     * @param $driver Driver Http драйвер
     * @param $host String хост сервиса
     * @param $auth String|null токен авторизации
     * @param $responseHandel Object|null обработчик результата запроса
     *
     */
    public function __construct($driver, $host, $auth = null, $responseHandel = null)
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
     * @param $host String хост
     *
     * @throws InvalidArgumentException
     *
     */
    private function setHost($host)
    {
        if (!(bool)filter_var($host, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException(sprintf("Invalid url: %s", $host));
        }
        $this->host = $host;
    }

    /**
     *
     * Выполняет запрос
     *
     * @param $method string название Http метода
     * @param $path string путь запроса
     * @param $header array заголовки запроса
     * @param $body string|array тело запроса
     *
     * @throws HttpGatewayException Ошибка запроса
     * @throws InvalidArgumentException Ошибка валидации метода запроса
     *
     * @return mixed
     *
     */
    public function request($method, $path, $header, $body)
    {
        $response = null;
        $this->methodValidation($method);
        $requestMethod = strtoupper(explode('::', $method)[1]);

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
        return $response;
    }

    /**
     *
     * Проводит валидацию метода запроса
     *
     * @param $method string
     *
     * @throws InvalidArgumentException Ошибка валидации метода
     *
     */
    private function methodValidation($method)
    {
        if (!preg_match("/^[A-Za-z]+::[A-Za-z]+$/", $method)) {
            throw new InvalidArgumentException(sprintf('Method: %s not support', $method));
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
