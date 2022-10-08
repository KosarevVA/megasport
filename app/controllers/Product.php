<?php

namespace App\Controllers;

use App\Modules\System\Container;
use App\Modules\System\ControllerInterface;
use App\Modules\System\GlobalStorage;
use App\Modules\System\View;
use App\Modules\Catalog\Product as Prod;

class Product implements ControllerInterface
{
	public function index()
	{
		$container = Container::getInstance();
		$urlParams = $container->get(GlobalStorage::class)->get('URL_PARAMETERS');
		$product = $container->get(Prod::class)->getProductById($urlParams['id']);
		$view = new View();
		$view->show('product', $product);
	}
}