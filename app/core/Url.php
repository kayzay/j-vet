<?php
/**
 * Created by PhpStorm.
 * User: UADN_DM
 * Date: 3/6/17
 * Time: 11:03 AM
 */

namespace Core;


class Url
{
    private  static $link;
    public  function __construct($list)
    {
        static::$link = $list;
    }

    public static function getLink ($id = null)
    {
        return (!empty($id))
                ?   isset(static::$link[$id])
                        ? static::$link[$id]
                        : static::$link[2]
                :  static::$link;
    }
}