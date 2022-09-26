<?php

namespace App\Controllers;

use App\Modules\System\Container;
use App\Modules\System\ControllerInterface;
use App\Modules\System\User;
use App\Modules\System\View;

class Signup implements ControllerInterface
{
	public function index()
	{
		$view = new View();
		$view->show('signup', []);
	}

	public function signUp()
	{
		$user = Container::getInstance()->get(User::class);
		$result = $user->registration();
		$view = new View();
		$view->show('signup', $result);
	}
}