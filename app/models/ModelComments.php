<?php
/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 13.03.2017
 * Time: 0:11
 */

namespace models;


use core\App;

class ModelComments
{
    /**
     * @param $list
     * @return mixed
     */
    public function commentSave($list)
    {
        $date = new \DateTime();
        $params = array_values($list);
        $params[] = $date->format('Y-F-d H-m-s');
        $query = "INSERT INTO comments (post_id, `from`, article, `data`) VALUES (?, ?, ?, ?)";
        $result = App::getDB()->run($query, $params);
        return $result->rowCount();
    }

    /**
     * @param $id
     * @return array
     */
    public function getComments($id)
    {
        $query = "SELECT * FROM comments WHERE post_id = :id";
        $result = App::getDB()->run($query, array(':id' => $id));
        return $result->fetchAll();
    }

    /**
     * @return array
     */
    public function getAllComments()
    {
        $query = "SELECT * FROM comments";
        $result = App::getDB()->run($query);
        return $result->fetchAll();
    }
}