<?php
/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 10.03.2017
 * Time: 11:40
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__DIR__) . '/app/core/AutoLoader.php');
$loader = new \core\AutoLoader();
 \core\App::getInstance()->appStart($loader);
