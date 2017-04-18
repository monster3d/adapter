<?php

interface GatewayHandlerContract {

    /**
     *
     * Выполняется по принципу obServer
     *
     * @param mixed $response
     * @param RestApiGateway $gateway
     *
     * @return mixed
     *
     */
    public function execute($response, $gateway);
}
