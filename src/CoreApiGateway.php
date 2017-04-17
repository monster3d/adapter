<?php


/**
 * Class CoreApiGateway
 *
 * @todo Нужно реализовать многократный вызов. Использовать промежуточный результат
 *
 */
class CoreApiGateway extends Gateway implements GatewayContract, GatewayResponseContract {

    /**
     *
     * Отпровляет GET запрос
     *
     * @see CoreApiGateway::request() Механизм обработки запроса
     *
     * @param $path string Путь запроса
     * @param $headers array Заголовки запроса
     * @param $body mixed Тело запроса
     *
     * @throws GatewayException (Ошибка валидации данных)
     *
     * @return CoreApiGateway
     *
     */
    public function get($path, $headers = [], $body = null)
    {
        $this->request(__METHOD__, $path, $headers, $body);
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
     * @param mixed $body тело запроса
     *
     * @throws ValidationGatewayException (Ошибка валидации данных)
     * @throws HttpGatewayException (Ошибка запроса)
     *
     * @return CoreApiGateway
     *
     */
    public function post($path, $headers = [], $body = null)
    {
        $this->request(__METHOD__, $path, $headers, $body);
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
     * @param mixed $body Тело запроса
     *
     * @throws ValidationGatewayException (Ошибка валидации данных)
     * @throws HttpGatewayException (Ошибка запроса)
     *
     * @return CoreApiGateway
     *
     */
    public function put($path, $headers = [], $body = null)
    {
        $this->request(__METHOD__, $path, $headers, $body);
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
     * @param mixed $body Тело запроса
     *
     * @throws ValidationGatewayException (Ошибка валидации данных)
     * @throws HttpGatewayException (Ошибка запроса)
     *
     * @return CoreApiGateway
     *
     */
    public function delete($path, $headers = [], $body = null)
    {
        $this->request(__METHOD__, $path, $headers, $body);
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
    public function execute($response)
    {
       return $this->handler->parse($response, $this);
    }
}
