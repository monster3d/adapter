<?php

$path = APP_ABSPATH . 'libs/Core/';

require_once APP_ABSPATH . 'vendor/autoload.php';
require_once APP_ABSPATH . 'libs/ErrorMessagingTrait.php';
require_once $path . 'GatewayException.php';
require_once $path . 'GatewayResponseContract.php';
require_once $path . 'GatewayHandlerContract.php';
require_once $path . 'GatewayRequestContract.php';
require_once $path . 'Gateway.php';
require_once $path . 'Driver.php';
require_once $path . 'JSendHandler.php';
require_once $path . 'RestApiGateway.php';


class Factory {

    /**
     * Настройки фабрики
     *
     * @var array
     *
     */
    private static $settings;

    /**
     *
     * Фабрика получение сервиса
     *
     * @param string $service
     *
     * @return RestApiGateway
     *
     * @throws ServiceNotFoundException
     *
     */
    public static function get($service) {
        $service = strtolower($service);

        if (array_key_exists($service, static::$settings)) {
            $baseSettings  = static::$settings[$service];
            $driverSettings = $baseSettings['driver_settings'];
            /*
             * Правильно было бы отдавать хост в Драйвер, но по причине использования Unirest интерфеса это невозможно
             */
            $class   = $baseSettings['type'];
            $driver  = new Driver($driverSettings['verify_host'], $driverSettings['verify_peer'], $driverSettings['timeout']);
            $host    = $baseSettings['host'];
            $auth    = $baseSettings['auth'];
            $handler = new $baseSettings['handler']();

            return new $class($driver, $host, $auth,  $handler);
        }
        throw new ServiceNotFoundException(sprintf("Сервис %s не найден", $service));
    }

    /**
     *
     * Устанавливает настройки
     *
     * @param $settings
     */
    public static function setSettings($settings) {
        static::$settings = $settings;
    }
}
