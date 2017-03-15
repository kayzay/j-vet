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
    protected $registry;

    public function __construct()
    {}

    public function get($key)
    {
        return $this->registry[$key];
    }

    public function set($key, $value)
    {
        $this->registry[$key] = $value;
    }
    
    public function start($controller, $action)
    {
        $start_controller = 'controllers\\' . $controller;
        if (is_file($this->get('config')['base']['patch_controller'] . $controller . '.php')) {
            $start_controller = new $start_controller($this->registry);
            if (method_exists($start_controller, $action)) {
                $start_controller->$action();
            } else {
                header('Location: ' . $this->get('url')[2]);
                exit();
            }
        } else {
            throw new \Exception('There is no file: ' . $controller);
        }
    }
}