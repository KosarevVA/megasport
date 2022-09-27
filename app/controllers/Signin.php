<?php

namespace App\Controllers;

use App\Modules\System\Container;
use App\Modules\System\ControllerInterface;
use App\Modules\System\Db;
use App\Modules\System\HttpContext;
use App\Modules\System\User;
use App\Modules\System\View;

class Signin implements ControllerInterface
{
	public function index()
	{
		$view = new View();
		$view->show('signin', []);
	}

	public function signIn()
	{
		$user = Container::getInstance()->get(User::class);
		$result = $user->authorize();
		$view = new View();
		$view->show('signin', $result);
	}
}