<?php
namespace core;

abstract class Controller {
	protected $registry;

	public function __construct($list = null) {
		$this->registry = $list;
	}

	public function __get($key) {
		return $this->registry[$key];
	}

	public function __set($key, $value) {
		$this->registry[$key] =  $value;
	}

}