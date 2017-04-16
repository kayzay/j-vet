<?php
/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 12.03.2017
 * Time: 11:22
 */

namespace core;


class Configuration
{
    private static $config;
    public function __construct()
    {
        $dir = __DIR__ . '/config';
        $files_config = scandir($dir);
        foreach ($files_config as $value) {
            if (!in_array($value, array(".", ".."))) {
                $key = explode('.', $value)[0];
                self::$config[$key] = require($dir . '/' . $value);
            }
        }
    }


    public static function getConfig($id = null)
    {
        return (!empty($id))
            ? (isset(self::$config[$id]))
                ? self::$config[$id]
                : null
            : self::$config;
    }
}