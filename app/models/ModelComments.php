<?php
/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 13.03.2017
 * Time: 0:11
 */

namespace models;


use core\lib\Sqlite;

class ModelComments extends Sqlite
{
    public function commentSave($list)
    {
        $date = new \DateTime();
        $params = array_values($list);
        $params[] = $date->format('Y-F-d H-m-s');
        $query = "INSERT INTO comments (post_id, `from`, article, `data`) VALUES (?, ?, ?, ?)";
        $result = $this->run($query, $params);
        return $result->rowCount();
    }

    public function getComments($id)
    {
        $query = "SELECT * FROM comments WHERE post_id = :id";
        $result = $this->run($query, array(':id' => $id));
        return $result->fetchAll();
    }

    public function getAllComments()
    {
        $query = "SELECT * FROM comments";
        $result = $this->run($query);
        return $result->fetchAll();
    }
}