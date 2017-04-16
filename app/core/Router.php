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
    private $link;
    private $meta;
    public function startRouter($db, $config)
    {
        $query = "SELECT 
                      rou.action_id,
                      rou.alias,
                      rou.title,
                      rou.keywords,
                      rou.description,
                      al_act.controller,
                      al_act.action
                  FROM routers AS rou, alias_action AS al_act
                  WHERE rou.action_id = al_act.id";
        $result = $db->run($query)->fetchAll();  
        foreach ($result as $value) {
            $this->link[$value['action_id']] = 'http://' . $config['base']['domain_name'] . '/' . $value['alias'];
            $this->collection_action[$value['alias']] = array(
                                                                'controller' => $value['controller'], 
                                                                'action' => $value['action']
                                                               );
            $this->meta[$value['action']] = array(
                                                    'title' => $value['title'],
                                                    'keywords' => $value['keywords'],
                                                    'description' => $value['description']
                                                   );
        }
        $this->collection_action = !empty($config['ajax_url'])
            ? array_merge($this->collection_action, $config['ajax_url'])
            : $this->collection_action;

        unset($db,$config);
    }
    
    public static function handlerUrl()
    {
        try {
            $action = array();
            $patch = trim($_SERVER['REQUEST_URI'],'/');
            $parts = (empty($patch)) ? 'home' : explode('/', $patch);  
            if (is_array($parts) && preg_match('/^[a-z-]{3,}$/', $parts[0]) && $parts[0] != 'ajax') {
                $action['name'] = $parts[0];
                unset($parts[0]);
                $action['url_action_data'] = array_values($parts);
            } elseif (is_array($parts) && preg_match('/ajax/', $parts[0])) {
                $action['name'] = $parts[1];
            } elseif (is_string($parts)) {
                $action['name'] = $parts;
            }
            unset($parts, $patch);
            return $action;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getMetaData($name)
    {
        return isset($this->meta[$name])
                ? $this->meta[$name]
                : array(
                'title' => '',
                'keywords' => '',
                'description' => ''
            );
    }

    public function getAliasAction($alias)
    {
         if(isset($this->collection_action[$alias])) {
             return $this->collection_action[$alias];
         }else{
             header('Location: ' . $this->link[1]);exit();
         }
    }
    
    public function getLink()
    {
        return $this->link;
    }
    
    public function getMeta()
    {
        return $this->meta;
    }
        
}