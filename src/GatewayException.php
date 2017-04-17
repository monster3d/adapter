<?php

class GatewayException extends Exception {
    //pass
}

class ServiceNotFoundException extends GatewayException {
    //pass
}

class HttpGatewayException extends GatewayException {
   //pass
}

class FailGatewayException extends GatewayException {
    //pass
}

class ErrorGatewayException extends GatewayException {
    //pass
}

class ValidationGatewayException extends GatewayException {
    //pass
}
