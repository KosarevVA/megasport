<?php

namespace App\Modules\System;

class HttpContext
{
	protected array $httpRequestValues;

	public function __construct()
	{
		$this->setHttpRequestValues();
		//TODO добавить методы для работы с url
	}

	public function setHttpRequestValues()
	{
		foreach ($_REQUEST as $name => $value)
		{
			$this->httpRequestValues[$name] = htmlspecialchars($value);
		}
	}

	public function getParameter(string $key) : string
	{
		$result = "";
		if(isset($this->httpRequestValues[$key]))
		{
			$result = $this->httpRequestValues[$key];
		}
		return $result;
	}

	public function getCurrentURL()
	{
		return $_SERVER['REQUEST_URI'];
	}
}