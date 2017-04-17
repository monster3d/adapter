<?php

interface GatewayHandlerContract {

    /**
     *
     * Выполняется по принципу obServer
     *
     * @param $response mixed
     * @param $gateway RestApiGateway
     *
     * @return mixed
     *
     */
    public function execute($response, $gateway);
}
