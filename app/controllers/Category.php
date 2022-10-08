<?php

namespace App\Controllers;

use App\Modules\Catalog\Product;
use App\Modules\Catalog\Category as Section;
use App\Modules\System\Container;
use App\Modules\System\ControllerInterface;
use App\Modules\System\GlobalStorage;
use App\Modules\System\View;

class Category implements ControllerInterface
{
	public function index()
	{
		$container = Container::getInstance();
		$categoryId = $container->get(GlobalStorage::class)->get('URL_PARAMETERS');
		$products = $container->get(Product::class)->getProductsByCategoryId($categoryId['id']);
		$category = $container->get(Section::class)->getCategoryById($categoryId['id']);
		$view = new View();
		$view->show('category', [
			'CATEGORY' => $category,
			'PRODUCTS' => $products
			]
		);
	}
}