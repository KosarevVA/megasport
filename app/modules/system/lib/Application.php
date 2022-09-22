<?php

namespace App\Modules\System;

class Application
{
	protected Route $currRoute;

	public function run() : void
	{
		$this->init();
		$this->exec();
	}

	public function init() : void
	{
		$this->registerAutoloader();
		$this->startRouter();
	}

	public function registerAutoloader() : void
	{
		$autoloader = new Psr4Autoloader();
		$autoloader->register();
		$autoloader->addNamespace('App\Modules\System\\', 'app/modules/system/lib/');
	}

	public function startRouter() : void
	{
		$router = new Router();
		$router->run();
		$this->currRoute = $router->getCurrentRoute();
	}

	public function exec()
	{
		$controller = new Controller($this->currRoute);
		$controller->run();
	}
}