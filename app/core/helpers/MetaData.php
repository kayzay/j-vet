<?php

/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 16.04.2017
 * Time: 1:40
 */
class MetaData
{
    private static $instance;
    private static $data;
    public  function __construct()
    {}

    public static function getInstance($meta)
    {
        if(empty(self::$instance)) {
            self::$instance = new MetaData();
            self::$data = $meta;
        }
        return self::$instance;
    }

    public static function setTitle($title)
    {
         self::$data['title'] = $title;
    }
    
    public static function getTitle()
    {
        return self::$data['title'];
    }

    public static function getKeywords()
    {
        return self::$data['keywords'];
    }

    public static function getDescription()
    {
        return self::$data['description'];
    }
}