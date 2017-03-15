<?php
/**
 * Created by PhpStorm.
 * User: UADN_DM
 * Date: 3/6/17
 * Time: 12:26 PM
 */

namespace core\lib;


use core\Configuration;

class Sqlite
{
    private $db;
    public function __construct()
    {
        try {
            $config = Configuration::getConfig();
            $data_base_name = sprintf('sqlite:%s', $config['base']['core_pat'] . $config['base']['database']);
            $this->db = new \PDO($data_base_name);
        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }
    
    public function run($query, $params = array())
    {
        try {
            $stmt = null;
            if (!empty($params)) {
                $stmt = $this->db->prepare($query);
                $stmt->execute($params);
            } else {
                $stmt = $this->db->query($query);
            }
            return $stmt;
        } catch (\PDOException $e) {
            $e->getMessage();
            return false;
        }
    }
}