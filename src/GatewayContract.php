<?php

interface GatewayContract {

    /**
     *
     * Выполняет GET запрос
     *
     * @param $path string
     * @param $headers array
     * @param $body null
     *
     * @return self
     *
     */
    public function get($path, $headers = [], $body = null);

    /**
     *
     * Выполнет POST запрос
     *
     * @param $path string
     * @param $headers array
     * @param $body null
     *
     * @return self
     *
     */
    public function post($path, $headers = [], $body = null);

    /**
     *
     * Выполняет PUT запрос
     *
     * @param $path string
     * @param $headers array
     * @param $body null
     *
     * @return self
     *
     */
    public function put($path, $headers = [], $body = null);

    /**
     *
     * Выполняет DELETE запрос
     *
     * @param $path string
     * @param $headers array
     * @param $body null
     *
     * @return self
     *
     */
    public function delete($path, $headers = [], $body = null);
}
