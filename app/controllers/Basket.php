<?php

namespace App\Controllers;

use App\Modules\System\Container;
use App\Modules\System\GlobalStorage;
use \App\Modules\Sale\Basket as BT;
use App\Modules\System\Session;
use App\Modules\System\View;

class Basket implements \App\Modules\System\ControllerInterface
{
	public function add()
	{
		$container = Container::getInstance();
		$pageParameters = $container->get(GlobalStorage::class)->get('URL_PARAMETERS');
		$productId = $pageParameters['product'];
		$basket = $container->get(BT::class);
		$basket->addProductToBasket($productId);
	}

	public function index()
	{
		$container = Container::getInstance();
		$session = $container->get(Session::class);
		$user = $session->get('USER');
		if(!$user)
		{
			header('Location: /megasport/');
			die();
		}
		$basket = $container->get(BT::class);
		$basketItems = $basket->getBasketByUserId($user['id']);
		$orderPrice = $basket->getOrderPriceByBasketItems($basketItems);
		$view = new View();
		$view->show('basket', [
			'BASKET' => $basketItems,
			'ORDER_PRICE' => $orderPrice
		]);
	}
}