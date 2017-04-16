<?php
/**
 * Created by PhpStorm.
 * User: UADN_DM
 * Date: 3/6/17
 * Time: 11:03 AM
 */

class Url
{
    private  static $link;
    private static $instance;
    
    public  function __construct()
    {}

    public static function getInstance($url)
    {
        if(empty(self::$instance)) {
            self::$instance = new Url();
            self::$link = $url;
        }
        return self::$instance;
    }

    public static function getLink ($id = null)
    {
        return (!empty($id))
                ? isset(static::$link[$id])
                        ? static::$link[$id]
                        : static::$link[2]
                : static::$link;
    }

    public static function redirect($link,  $status = 302)
    {
        header('Location: ' . $link, true, $status);
        exit();
    }
}