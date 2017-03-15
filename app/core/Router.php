<?php
/**
 * Created by PhpStorm.
 * User: UADN_DM
 * Date: 3/2/17
 * Time: 2:56 PM
 */
namespace Core;

class Router
{
    private $collection_action;
    public $link;
    public function startRouter($db, $config)
    {
        $query = "SELECT rou.action_id, rou.alias, al_act.controller, al_act.action
                  FROM routers AS rou, alias_action AS al_act
                  WHERE rou.action_id = al_act.id";
        $result = $db->run($query)->fetchAll();  
        foreach ($result as $value) {
            $this->link[$value['action_id']] = 'http://' . $config['domain_name'] . '/' . $value['alias'];
            $this->collection_action[$value['alias']] = array('controller' => $value['controller'], 'action' => $value['action']);
        }
    }
    
    public static function handlerUrl($app)
    {
        try {
            $action = '';
            $patch = trim($_SERVER['REQUEST_URI'],'/');
            $parts = (empty($patch)) ? 'home' : explode('/', $patch);
            if (is_array($parts) && preg_match('/^[a-z-]{3,}$/', $parts[0])) {
                $action = $parts[0];
                unset($parts[0]);
                $app->set('url_action_data', array_values($parts));
            } elseif (is_string($parts)) {
                $action = $parts;
            }
            return $action;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAliasAction($alias)
    {
         if(isset($this->collection_action[$alias])) {
             return $this->collection_action[$alias];
         }else{
             header('Location: ' . $this->link[1]);exit();
         }
    }
}