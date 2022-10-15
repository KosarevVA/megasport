<?php

namespace App\Modules\Catalog;

use App\Modules\System\Container;
use App\Modules\System\Db;
use App\Modules\System\Session;

class Product
{
	protected Db $db;
	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	public function getProductsByCategoryId(int $categoryId)
	{
		$container = Container::getInstance();
		$sql = "SELECT * FROM `products` JOIN `catalog` ON `products`.`id` = `catalog`.`product` WHERE `catalog`.`category` = :id;";
		$products = $this->db->sqlExecution($sql, [$categoryId]);
		foreach($products as $index => $product)
		{
			$sql = "SELECT * FROM `property_values` JOIN `properties` ON `property_values`.`property` = `properties`.`id` WHERE `properties`.`category` = :category AND `property_values`.`product` = :product;";
			$additionalFields = $this->db->sqlExecution($sql, [$categoryId, $product['id']]);
			if($additionalFields)
			{
				$products[$index]['ADDITIONAL_FIELDS'] = $additionalFields;
			}
			$session = $container->get(Session::class);
			if($session->has('USER'))
			{
				$products[$index]['BASKET']['COUNT'] = $this->getProductCountFromBasket($product['id']);
			}
		}
		return $products;
	}

	public function getProductById(int $productId)
	{
		$sql = "SELECT * FROM `products` WHERE `id` = :id";
		$product = $this->db->sqlExecution($sql, [$productId]);
		$sql = "SELECT * FROM `property_values` JOIN `properties` ON `property_values`.`property` = `properties`.`id` WHERE `property_values`.`product` = :product;";
		$additionalFields = $this->db->sqlExecution($sql, [$productId]);
		$product['ADDITIONAL_FIELDS'] = $additionalFields;
		return $product;
	}

	public function getProductCountFromBasket(int $productId)
	{
		$container = Container::getInstance();
		$session = $container->get(Session::class);
		$user = $session->get('USER');
		$sql = "SELECT * FROM `basket` LEFT JOIN `order_items` ON `basket`.`id` = `order_items`.`basket` WHERE `product` = :product AND `user` = :user ORDER BY `basket`.`id` desc LIMIT 1";
		$basketItem = $this->db->sqlExecution($sql, [$productId, $user['id']]);
		return $basketItem? $basketItem[0]['order']?0:$basketItem[0]['count'] : 0;
	}
}