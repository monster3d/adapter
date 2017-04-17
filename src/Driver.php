<?php

class Driver extends Unirest\Request {

    /**
     *
     * Driver constructor.
     *
     * @param $verifyHost bool Отключает проверку SSL для общего хоста
     * @param $verifyPeer bool Отключает проверку SSL узла сети
     * @param $timeout int Устанавливает время запроса
     *
     */
    public function __construct($verifyHost = false, $verifyPeer = false, $timeout = 50)
    {
        $this->verifyHost($verifyHost);
        $this->verifyPeer($verifyPeer);
        $this->timeout($timeout);
    }
}
