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
$config = \core\Configuration::getConfig();
$app = new \core\App();
$app->set('config', $config);
$app->set('db',  new \core\lib\Sqlite());
$router = new \core\Router();
$router->startRouter($app->get('db'), $app->get('config')['base']);
$action = $router->handlerUrl($app);
$start = $router->getAliasAction($action);
$url = new \core\Url($router->link);
$app->set('url', $url::getLink());
$app->set('request', new \core\Request());
$app->set('view', new \core\View($config['patch'], $url::getLink()));
$app->start($start['controller'], $start['action']);
