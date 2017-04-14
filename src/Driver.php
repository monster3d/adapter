<?php

class Driver extends Unirest\Request {

    /**
     *
     * Driver constructor.
     *
     * @param array $settings
     *
     * @example array['verify_host' => true, 'verify_peer' => true, 'timeout' => 40]
     *
     */
    public function __construct($settings = [])
    {
        $defaultSettings = $this->getDefaultSettings();
        if (array_key_exists('verify_host', $settings)) {
            $verifyHost = (bool)$settings['verify_host'];
        } else {
            $verifyHost = $defaultSettings['verify_host'];
        }

        if (array_key_exists('verify_peer', $settings)) {
            $verifyPeer = (bool)$settings['verify_peer'];
        } else {
            $verifyPeer = $defaultSettings['verify_peer'];
        }

        if (array_key_exists('timeout', $settings)) {
            $timeout = (int)$settings['timeout'];
        } else {
            $timeout = $defaultSettings['timeout'];
        }

        $this->verifyHost($verifyHost);
        $this->verifyPeer($verifyPeer);
        $this->timeout($timeout);
    }

    /**
     *
     * Настройки по умолчанию
     *
     * @return array
     *
     */
    private function getDefaultSettings()
    {
        return [
            'verify_host' => false,
            'verify_peer' => false,
            'timeout'     => 50
        ];
    }
}
