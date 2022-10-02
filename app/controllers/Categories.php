<?php

namespace App\Controllers;

use App\Modules\Catalog\Category;
use App\Modules\System\Container;
use App\Modules\System\ControllerInterface;
use App\Modules\System\View;

class Categories implements ControllerInterface
{
	public function index()
	{
		$categories = Container::getInstance()->get(Category::class)->getCategories();
		$view = new View();
		$view->show('categories', $categories);
	}
}