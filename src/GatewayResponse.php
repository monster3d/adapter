<?php

class GatewayResponse {

    use ErrorMessagingTrait;

    /**
     *
     * Указывает нужно ли вернуть исключение при ошибки
     *
     * @var boolean
     *
     */
    private $exception;

    /**
     *
     * GatewayResponse constructor.
     *
     */
    public function __construct()
    {
        $this->exception = true;
    }

    /**
     *
     * Функция будет вызвана если получен результат от сервиса
     *
     * @param $name
     * @param $response
     *
     * @return Gateway
     *
     * @throws GatewayException
     *
     */
    public function __call($name, $response)
    {
        $error = null;
        $data  = null;
        $notHttpErrorCode = [200, 400];
        $gateway = $response[1];
        $code    = $response[0]->code;
        $body    = $response[0]->raw_body;

        if (!in_array($code, $notHttpErrorCode)) {
            $error = new HttpGatewayException(sprintf("Сервис вернул ошибку \n\r Код: %s \n\r Тело: %s", $code, $body));
            $this->writeErrorLog($error);
            throw $error;
        }

        $response = \JSend\JSendResponse::decode($body);

        switch (true) {
            case $response->isFail():
                $data = $response->getData();
                $gateway->setResponse($data);
                $error = new FailGatewayException(sprintf("Ошибка данных \n\r Тело: %s", print_r($data, true)));
                break;
            case $response->isError():
                $data = $response->getErrorMessage();
                $gateway->setResponse($data);
                $error = new ErrorGatewayException(sprintf("Ошибка сервиса \n\r Тело: %s", $data));
                break;
            case $response->isSuccess():
                $data = $response->getData();
                break;
            default:
                $error = new GatewayException("Неизвестная ошибка сервиса");
        }
        if (!is_null($error) && $this->exception) {
            $this->writeErrorLog($error);
            throw $error;
        }
        $gateway->setResponse($data);
        return $gateway;
    }

    /**
     *
     * Отключить или включить выброс исключений
     *
     * @param $switch bool
     *
     */
    public function exception($switch)
    {
        $this->exception = (bool)$switch;
    }
}


