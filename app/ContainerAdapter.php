<?php

namespace app;

use housedi\Container;

/**
 * Class ContainerAdapter
 * @package app
 */
class ContainerAdapter
{
    /** @var Container|null */
    private static $instance = null;

    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        return self::getInstance()->get($key);
    }

    private static function getInstance(): Container
    {
        if (!self::$instance) {
            $definitions = require_once __DIR__ .'/../config/container.php';
            self::$instance = new Container(['definitions' => $definitions]);
        }

        return self::$instance;
    }
}
