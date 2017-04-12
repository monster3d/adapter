<?php

interface GatewayResponseContract {

    /**
     *
     * Обработчик ответа
     *
     * @param $response
     * @return mixed
     *
     */
    public function responseHandler($response);
}
