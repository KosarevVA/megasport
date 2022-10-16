<?php

namespace App\Modules\System;

use App\Modules\Catalog\Category;
use App\Modules\Catalog\Product;
use App\Modules\Sale\Basket;
use App\Modules\Sale\Cities;
use App\Modules\Sale\DeliveryCompanies;

class Container
{
	protected array $services;
	protected array $cachedServices;
	static protected Container $instance;

	private function __construct()
	{
		$this->services = [
			Router::class => fn() => new Router(),
			Controller::class => fn() => new Controller(),
			Configuration::class => fn() => new Configuration(),
			Db::class => fn() => new Db(self::get(Configuration::class)),
			Session::class => fn () => new Session(),
			User::class => fn() => new User(self::get(Db::class), self::get(Session::class)),
			HttpContext::class => fn() => new HttpContext(),
			GlobalStorage::class => fn() => new GlobalStorage(),
			Category::class => fn() => new Category(self::get(Db::class)),
			Product::class => fn() => new Product(self::get(Db::class)),
			Basket::class => fn() => new Basket(self::get(Db::class)),
			DeliveryCompanies::class => fn() => new DeliveryCompanies(self::get(Db::class)),
			Cities::class => fn() => new Cities(self::get(Db::class)),
		];
	}

	static public function getInstance() : Container
	{
	    if(!isset(self::$instance))
	    {
		    self::$instance = new Container();
	    }
		return self::$instance;
	}

	public function get(string $id)
	{
		if(isset($this->cachedServices[$id]))
		{
			return $this->cachedServices[$id];
		}
		$this->cachedServices[$id] = $this->services[$id]();
		return $this->cachedServices[$id];
	}
}