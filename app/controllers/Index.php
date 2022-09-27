<?php

namespace App\Controllers;

use App\Modules\System\ControllerInterface;
use App\Modules\System\View;

class Index implements ControllerInterface
{
	public function index()
	{
		$view = new View();
		$view->show('main', []);
	}
}