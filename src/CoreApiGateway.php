<?php


/**
 * Class CoreApiGateway
 *
 * @todo Нужно реализовать много кратный вызов. Использовать промежуточный результат
 *
 */
class CoreApiGateway extends Gateway implements GatewayContract, GatewayResponseContract {

    /**
     *
     * @var Unirest\Response
     *
     */
    private $response;

    /**
     *
     * @see GatewayContract
     *
     * @param $path string Путь запроса
     * @param $headers array Заголовки запроса
     * @param $body mixed Тело запроса
     *
     * @throws GatewayException
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
     * @see GatewayContract
     *
     * @param string $path Путь запроса
     * @param array $headers Заголовки запроса
     * @param mixed $body тело запроса
     *
     * @throws GatewayException
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
     * @see GatewayContract
     *
     * @param string $path Путь запроса
     * @param array $headers Заголовки запроса
     * @param mixed $body Тело запроса
     *
     * @throws GatewayException
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
     * @see GateWayContract
     *
     * @param string $path Путь запроса
     * @param array $headers Заголовки запроса
     * @param mixed $body Тело запроса
     *
     * @throws GatewayException
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
     * Получить результат запроса
     *
     * @return \Unirest\Response
     *
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     *
     * Устанавливает результат ответа от сервиса
     *
     * @param $response
     *
     * @return CoreApiGateway
     *
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     *
     * @see GatewayResponseContract
     *
     * @param mixed $response
     *
     * @throws GatewayException
     *
     * @return mixed
     *
     */
    public function responseHandler($response)
    {
       return $this->handler->parse($response, $this);
    }
}
