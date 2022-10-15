<?php

namespace App\Controllers;

use App\Modules\System\Container;
use App\Modules\System\GlobalStorage;
use \App\Modules\Sale\Basket as BT;
use App\Modules\System\HttpContext;
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

	public function plus()
	{
		$container = Container::getInstance();

		$httpContext = $container->get(HttpContext::class);
		$productId = $httpContext->getParameter('productId');

		$session = $container->get(Session::class);
		$user = $session->get('USER');

		$basket = $container->get(BT::class);

		$addOneItemToBasket = $basket->addOneItemToBasketByProductId($productId);
		$basketItems = $basket->getBasketByUserId($user['id']);
		$orderPrice = $basket->getOrderPriceByBasketItems($basketItems);
		$basketItemCount = $basket->getBasketItemCountByBasketItems($basketItems, $productId);
		$basketItemPrice = $basket->getBasketItemPriceByBasketItems($basketItems, $productId);
		echo json_encode(
			[
				'STATUS' => $addOneItemToBasket,
				'ORDER_PRICE' => $orderPrice,
				'PRICE' => $basketItemPrice,
				'COUNT' => $basketItemCount
			]
		);
	}

	public function minus()
	{
		$container = Container::getInstance();

		$httpContext = $container->get(HttpContext::class);
		$productId = $httpContext->getParameter('productId');

		$session = $container->get(Session::class);
		$user = $session->get('USER');

		$basket = $container->get(BT::class);

		$addOneItemToBasket = $basket->deleteOneItemToBasketByProductId($productId);
		$basketItems = $basket->getBasketByUserId($user['id']);
		$orderPrice = $basket->getOrderPriceByBasketItems($basketItems);
		$basketItemCount = $basket->getBasketItemCountByBasketItems($basketItems, $productId);
		$basketItemPrice = $basket->getBasketItemPriceByBasketItems($basketItems, $productId);
		echo json_encode(
			[
				'STATUS' => $addOneItemToBasket,
				'ORDER_PRICE' => $orderPrice,
				'PRICE' => $basketItemPrice,
				'COUNT' => $basketItemCount
			]
		);
	}
}