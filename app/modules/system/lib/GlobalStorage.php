<?php

namespace App\Modules\System;

class GlobalStorage
{
	protected array $storage;

	public function set(string $key, $value) : void
	{
		$this->storage[$key] = $value;
	}

	public function get(string $key)
	{
		$result = [];
		if($this->has($key))
			return $result = $this->storage[$key];
		return $result;
	}

	public function has(string $key) : bool
	{
		return isset($this->storage[$key]);
	}
}