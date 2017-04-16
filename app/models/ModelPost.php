<?php

/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 12.03.2017
 * Time: 11:10
 */
namespace models;

use core\App;

class ModelPost 
{
    public function getPostAll()
    {           
        $query = "SELECT p.id, p.name, p.description, p.author, p.data, COUNT(com.id) as leanch
                  FROM post as p
                  LEFT JOIN comments as com on (p.id = com.post_id)
                  GROUP BY p.id
                  ORDER BY p.data DESC " ;
        $result = App::getDB()->run($query);
        return $result->fetchAll();
    }
    
    public function getPost($id)
    {
        $query = "SELECT p.id, p.name, p.description, p.author, p.data, COUNT(com.id) as leanch
                  FROM post as p
                  LEFT JOIN comments as com on (p.id = com.post_id)
                  WHERE p.id = :id" ;
        $result = App::getDB()->run($query, array(':id' => $id));
        return $result->fetch();
    }

    public function postSave($list)
    {
        $date = new \DateTime();
        $params = array_values($list);
        $params[] = $date->format('Y-F-d');
        $query = "INSERT INTO post (`name`, author, description, `data`) VALUES (?, ?, ?, ?)";
        $result = App::getDB()->run($query, $params);
        return $result->rowCount();
    }
    
    public function popular($limit)
    {
        $params = array(':limit' => $limit);
        $query = "SELECT p.id, p.name, p.description, p.author, p.data, COUNT(com.id) as leanch
                  FROM post as p
                  LEFT JOIN comments as com on (p.id = com.post_id)
                  GROUP BY p.id
                  ORDER BY leanch DESC  LIMIT :limit" ;
        $result = App::getDB()->run($query, $params);
        return $result->fetchAll();
    }
}