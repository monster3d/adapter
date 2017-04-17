<?php


/**
 * Class CoreApiGateway
 *
 * @todo Нужно реализовать многократный вызов. Использовать промежуточный результат
 *
 */
final class RestApiGateway extends Gateway implements GatewayRequestContract, GatewayResponseContract {

    /**
     *
     * @var mixed результат работы сервиса
     *
     */
    private $response;

    /**
     *
     * Отпровляет GET запрос
     *
     * @see CoreApiGateway::request() Механизм обработки запроса
     *
     * @param $path string Путь запроса
     * @param $headers array Заголовки запроса
     *
     * @throws InvalidArgumentException (Ошибка валидации данных)
     * @throws HttpGatewayException (Ошибка запроса)
     *
     * @return RestApiGateway
     *
     */
    public function get($path, $headers = [])
    {
        $this->response = $this->request(__METHOD__, $path, $headers, $body = null);
        return $this;
    }

    /**
     *
     * Отпровляет POST запрос
     *
     * @see CoreApiGateway::request() Механизм обработки запроса
     *
     * @param string $path Путь запроса
     * @param array $headers Заголовки запроса
     * @param string|array $body тело запроса
     *
     * @throws InvalidArgumentException (Ошибка валидации данных)
     * @throws HttpGatewayException (Ошибка запроса)
     *
     * @return RestApiGateway
     *
     */
    public function post($path, $headers = [], $body = null)
    {
        $this->response = $this->request(__METHOD__, $path, $headers, $body);
        return $this;
    }

    /**
     *
     * Отпровляет PUT запрос
     *
     * @see CoreApiGateway::request() Механизм обработки запроса
     *
     * @param string $path Путь запроса
     * @param array $headers Заголовки запроса
     * @param string|array $body Тело запроса
     *
     * @throws InvalidArgumentException (Ошибка валидации данных)
     * @throws HttpGatewayException (Ошибка запроса)
     *
     * @return RestApiGateway
     *
     */
    public function put($path, $headers = [], $body = null)
    {
        $this->response = $this->request(__METHOD__, $path, $headers, $body);
        return $this;
    }

    /**
     *
     * Отпровляет DELETE запрос
     *
     * @see CoreApiGateway::request() Механизм обработки запроса
     *
     * @param string $path Путь запроса
     * @param array $headers Заголовки запроса
     *
     * @throws InvalidArgumentException (Ошибка валидации данных)
     * @throws HttpGatewayException (Ошибка запроса)
     *
     * @return RestApiGateway
     *
     */
    public function delete($path, $headers = [])
    {
        $this->response = $this->request(__METHOD__, $path, $headers, $body = null);
        return $this;
    }

    /**
     *
     * Применяет оброботчки к результату запроса
     *
     * @param mixed $response
     *
     * @throws GatewayException
     *
     * @see GatewayResponse Возможные исключения от хендлера
     *
     * @return mixed
     *
     */
    public function handle($response)
    {
       return $this->handler->execute($response, $this);
    }
    /**
     *
     * Отдает ответ от сервера
     *
     * @return mixed
     *
     */
    public function getResponse()
    {
        if (!is_null($this->handler)) {
            $this->handle($this->response);
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
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }
}
