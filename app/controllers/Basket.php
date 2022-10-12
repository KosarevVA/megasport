<?php

namespace App\Controllers;

use App\Modules\System\Container;
use App\Modules\System\GlobalStorage;
use \App\Modules\Sale\Basket as BT;

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
}