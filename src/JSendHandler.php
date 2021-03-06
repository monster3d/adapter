<?php

class JSendHandler implements GatewayHandlerContract {

    use ErrorMessagingTrait;

    /**
     *
     * Функция будет вызвана если получен результат от сервиса
     *
     * @param mixed $response результат ответа
     * @param RestApiGateway $gateway
     *
     * @throws HttpGatewayException Ошибка запроса к сервису
     * @throws ValidationGatewayException Ошибка валидации JSON Результата
     *
     * @throws FailGatewayException Ошибка данных (JSend)
     * @throws ErrorGatewayException Сервис вернул ошибку (JSend)
     *
     * @see https://labs.omniti.com/labs/jsend
     *
     * @throws GatewayException Неизвестная ошибка
     *
     * @return RestApiGateway
     *
     */
    public function execute($response, $gateway)
    {
        $error = null;
        $data  = null;
        $notHttpErrorCode = [200, 400];
        $code    = $response->code;
        $body    = $response->raw_body;

        if (!in_array($code, $notHttpErrorCode)) {
            $error = new HttpGatewayException(sprintf("Сервис вернул ошибку \n\r Код: %s \n\r Тело: %s", $code, $body));
            $this->writeErrorLog($error);
            throw $error;
        }
        try {
            $response = \JSend\JSendResponse::decode($body);
        } catch (\JSend\InvalidJSendException $e) {
            throw new ValidationGatewayException(sprintf("Не валидный JSON Тело: %s", print_r($body, true)));
        }
        switch (true) {
            case $response->isFail():
                $data = $response->getData();
                $error = new FailGatewayException(sprintf("Ошибка данных \n\r Тело: %s", print_r($data, true)));
                break;
            case $response->isError():
                $data = $response->getErrorMessage();
                $error = new ErrorGatewayException(sprintf("Ошибка сервиса \n\r Тело: %s", $data));
                break;
            case $response->isSuccess():
                $data = $response->getData();
                break;
            default:
                $error = new GatewayException("Неизвестная ошибка сервиса");
        }
        if (!is_null($error)) {
            $this->writeErrorLog($error);
            throw $error;
        }
        $gateway->setResponse($data);
        return $gateway;
    }
}


