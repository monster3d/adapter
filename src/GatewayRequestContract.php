<?php

interface GatewayRequestContract {

    /**
     *
     * Выполняет GET запрос
     *
     * @param string $path
     * @param array $headers
     *
     * @return self
     *
     */
    public function get($path, $headers = []);

    /**
     *
     * Выполнет POST запрос
     *
     * @param string $path
     * @param array $headers
     * @param string|array|null $body
     *
     * @return self
     *
     */
    public function post($path, $headers = [], $body = null);

    /**
     *
     * Выполняет PUT запрос
     *
     * @param string $path
     * @param array $headers
     * @param string|array|null $body
     *
     * @return self
     *
     */
    public function put($path, $headers = [], $body = null);

    /**
     *
     * Выполняет DELETE запрос
     *
     * @param string $path
     * @param array $headers
     *
     * @return self
     *
     */
    public function delete($path, $headers = []);
}
