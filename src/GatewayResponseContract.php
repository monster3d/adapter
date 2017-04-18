<?php

interface GatewayResponseContract {

    /**
     *
     * Обработчик ответа
     *
     * @param mixed $response
     * @return mixed
     *
     */
    public function handle($response);

    /**
     *
     * Устанавливает результат
     *
     * @param mixed $response
     *
     * @return mixed
     *
     */
    public function setResponse($response);

    /**
     *
     * Получает результат от сервера
     *
     * @return mixed
     *
     */
    public function getResponse();
}
