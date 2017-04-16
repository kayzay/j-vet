<?php
/**
 * Created by PhpStorm.
 * User: UADN_DM
 * Date: 3/6/17
 * Time: 12:29 PM
 */

namespace core;

class App
{
    private $registry;
    private static $instance;
    private $router;
    private static $link;
    private static $meta;
    private static $db;
    
    private function __construct()
    {
        $config = new Configuration();
        $this->set('config', $config::getConfig());
        self::$db =  new lib\Sqlite($this->get('config'));
        $this->router = new Router();
        $this->router->startRouter(self::$db, $this->get('config'));
        self::$link = $this->router->getLink();
        self::$meta = $this->router->getMeta();
    }
    
    public static function getInstance()
    {
        if(empty(self::$instance)) {
            self::$instance = new App();
        }
        return self::$instance;
    }
    
    public function get($key)
    {
        return $this->registry[$key];
    }

    public function set($key, $value)
    {
        $this->registry[$key] = $value;
    }
    
    public static function getDB()
    {
        return self::$db;
    }

    public static function getRequest()
    {
        return new Request();
    }
    
    public function appStart($loader)
    {
        $action = $this->router->handlerUrl(); 
        $controller = $this->router->getAliasAction($action['name']);
        self::$meta = self::$meta[$controller['action']];
        $this->set('url_action_data', (isset($action['url_action_data'])) ? $action['url_action_data'] : '');
        self::packageManagers($loader, $this->get('config')['package']);
        
        $this->startController($controller);
        unset($action, $controller);
    }
    
    private function startController($action)
    {
        $start_controller = 'controllers\\' . $action['controller'];
        if (is_file($this->get('config')['base']['patch_controller'] . $action['controller'] . '.php')) {
            $start_controller = new $start_controller($this->registry);
            if (method_exists($start_controller, $action['action'])) {
                $method = $action['action'];
                $start_controller->$method();
            } else {
                header('Location: ' . $this->get('url')[2]);
                exit();
            }
        } else {
            throw new \Exception('There is no file: ' . $action['controller']);
        }
    }
    
    private static function packageManagers($loader, $package)
    {
        $loader->packages($package);
        \Url::getInstance(self::$link);
        \MetaData::getInstance(self::$meta);
    }
}