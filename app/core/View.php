<?php
/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 11.03.2017
 * Time: 0:36
 */

namespace core;


class View
{
    private $patch;
    private $url;
    public function __construct($config_view_element, $link)
    {
        $this->patch = $config_view_element;
        $this->url = $link;
    }

    public function generate($layout = 'default', $template, $data = null)
    {
        $file = $this->patch['layout'].$layout.'.php';
        if (is_file($file)){
            if(is_array($data)) {
                extract($data);
                unset($data);
            }

               require($file);

            } else {
                trigger_error('Error: Could not load template ' . $file . '!');
                exit();
            }
    }

    public function ajaxRespond($error_code, $error_description, $data)
    {
        $result = json_encode(
            array(
                'error_code' => $error_code,
                'error_desc' => $error_description,
                'data' => $data
            )
        );
        echo $result;
    }

    public function useElement($element, $parameters = array())
    {
        if (file_exists($this->patch['shared'] . $element)) {
            $element_path = $this->patch['shared'] . $element;
            if(is_array($parameters)) {
                extract($parameters);
                unset($parameters);
            }
            require($element_path);
        }  else {
            throw new \Exception("Element file not found: " . print_r($element, true));
        }
    }
}