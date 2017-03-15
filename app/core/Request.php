<?php
/**
 * Created by PhpStorm.
 * User: UADN_DM
 * Date: 8/22/16
 * Time: 12:38 PM
 */

namespace Core;

class Request
{
    public $post;
    public $get;
    public $file;
    public function __construct() {
        $this->post =  $this->cleaning($_POST);
        $this->get  =  $this->cleaning($_GET);
        $this->file =  $this->cleaning($_FILES);
    }

    private function cleaning($list)
    {
        try {
            if (is_array($list)) {
                foreach ($list as $key => $value) {
                    $list[$this->cleaning($key)] = $this->cleaning($value);
                }
            } else {
                $list = htmlspecialchars(trim($list), ENT_COMPAT, 'UTF-8');
            }
            return $list;
        } catch (\Exception $e) {
          //  $e->catchException();
        }
    }

}