<?php

namespace App\Controllers;

use App\Modules\System\Container;
use App\Modules\System\Session;
use App\Modules\System\View;

class Orders implements \App\Modules\System\ControllerInterface
{
	public function create()
	{
		$container = Container::getInstance();
		$session = $container->get(Session::class);
		$orders = $container->get(\App\Modules\Sale\Orders::class);
		$view = new View();
		if($errors = $orders->createOrder())
		{
			$session->set('ORDER_ERRORS', $errors);
			header('Location: /megasport/basket/');
		}else
		{
			header('Location: /megasport/');
		}
	}

	public function index()
	{
		$container = Container::getInstance();
		$orders = $container->get(\App\Modules\Sale\Orders::class);
		$orders = $orders->getOrders();
		$view = new View();
		$view->show('orders', $orders);
	}
}