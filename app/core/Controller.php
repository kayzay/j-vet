<?php
namespace core;

abstract class Controller {
	protected $registry;
	protected  static $view;

	public function __construct($list = null) {
		$this->registry = $list;
		self::$view = new View();
	}

	public function __get($key) {
		return $this->registry[$key];
	}

	public function __set($key, $value) {
		$this->registry[$key] =  $value;
	}

}