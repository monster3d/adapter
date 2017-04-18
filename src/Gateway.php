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
     * Gateway constructor
     *
     * @param Driver $driver Http драйвер
     * @param string $host хост сервиса
     * @param string $auth токен авторизации
     * @param Object|null $responseHandler обработчик результата запроса
     *
     */
    public function __construct($driver, $host, $auth = null, $responseHandler = null)
    {
        $this->driver  = $driver;
        $this->handler = $responseHandler;
        $this->auth    = $auth;
        $this->setHost($host);
    }

    /**
     *
     * Устанавливает url сервиса
     *
     * @param string $host хост
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
     * @param string $method название Http метода
     * @param string $path путь запроса
     * @param array $header заголовки запроса
     * @param string|array $body тело запроса
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
     * @param string $method
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
