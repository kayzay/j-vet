<?php

namespace core;


class AutoLoader
{
    private $_packages = array();

    public function __construct()
    {
        spl_autoload_register(array($this, '_autoload'));
    }

    public function packages(array $list)
    {
        $this->_packages = $list;
    }

    private function _autoload($class)
    {
        $folder = dirname(dirname(__FILE__));
        $source = explode('\\', $class);
        do {
            $package = implode('/', $source);
            if (isset($this->_packages[$package])) {
                $folder = $this->_packages[$package];
            }
        } while ($part = array_pop($source));;
        $file_path = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
        $path = $folder;
        if (strpos($folder, '.php') === false) {
            $path = $folder.DIRECTORY_SEPARATOR.$file_path;
        }

        if (file_exists($path)) {
            require $path;
        } else {
            throw new \Exception($path);
        }
    }
}