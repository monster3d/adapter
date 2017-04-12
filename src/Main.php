<?php

$path = APP_ABSPATH . 'libs/Core/';

require_once APP_ABSPATH . 'vendor/autoload.php';
require_once APP_ABSPATH . 'libs/ErrorMessagingTrait.php';
require_once $path . 'GatewayException.php';
require_once $path . 'GatewayResponseContract.php';
require_once $path . 'GatewayContract.php';
require_once $path . 'Gateway.php';
require_once $path . 'Driver.php';
require_once $path . 'GatewayResponse.php';
require_once $path . 'CoreApiGateway.php';


class Adapter {

    /**
     *
     * Фабрика получение сервиса
     *
     * @param $service string
     *
     * @return GatewayContract
     *
     * @throws ServiceNotFoundException
     *
     */
    public static function get($service) {
        $service = strtolower($service);

        /*
         * Тут добовляется новый адаптер для удаленного сервиса
         *
         * class   = Класс сервиса
         * host    = Хост сервиса
         * auth    = Если есть ключ авторизации или null
         * handler = Класс который будет обробатывать результаты или null
         *
         */
        $adapters = [
            'core'     => ['class' => 'CoreApiGateway', 'host' => CORE_URL, 'auth' => CORE_AUTH, 'handler' => 'GatewayResponse'],
            'tracking' => ['class' => null, 'host' => '', 'handler' => null],
            'routing'  => ['class' => null, 'host' => '', 'handler' => null]
        ];

        if (array_key_exists($service, $adapters)) {
            $coreApi = $adapters[$service];
            /*
             * Правильно было бы отдавать хост в Драйвер, но по причине использования Unirest интерфеса это невозможно
             */
            return new $coreApi['class'](new Driver(), $coreApi['host'], $coreApi['auth'],  new $coreApi['handler']());
        }
        throw new ServiceNotFoundException(sprintf("Сервис %s не найден", $service));
    }
}
