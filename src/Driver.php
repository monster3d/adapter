<?php

class Driver extends Unirest\Request {

    /**
     *
     * Driver constructor.
     *
     * @param boolean $verifyHost Отключает проверку SSL для общего хоста
     * @param boolean $verifyPeer Отключает проверку SSL узла сети
     * @param int $timeout Устанавливает время запроса
     *
     */
    public function __construct($verifyHost = false, $verifyPeer = false, $timeout = 50)
    {
        $this->verifyHost($verifyHost);
        $this->verifyPeer($verifyPeer);
        $this->timeout($timeout);
    }
}
